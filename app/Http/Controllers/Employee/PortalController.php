<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementNotification;
use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $employee = Employee::query()->with('department')->where('email', $user->email)->first();

        $notificationsCount = AnnouncementNotification::query()
            ->where('user_id', $user->id)
            ->count();

        $recentAlerts = AnnouncementNotification::query()
            ->with('announcement')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(3)
            ->get();

        $activeCredentials = $employee && $employee->resume_last_updated_at ? 1 : 0;
        $pendingCredentials = $employee && $employee->resume_last_updated_at && $employee->resume_last_updated_at->lt(now()->subMonths(6)) ? 1 : 0;

        $calendarEvents = $recentAlerts
            ->map(fn (AnnouncementNotification $notification) => $notification->announcement?->title)
            ->filter()
            ->values();

        return view('employee.dashboard', [
            'employee' => $employee,
            'stats' => [
                'active_credentials' => $activeCredentials,
                'pending_credentials' => $pendingCredentials,
                'compliance_total' => max($activeCredentials, 1),
                'compliance_passed' => $activeCredentials,
                'leave_balance' => $this->leaveBalanceFor($employee),
                'notifications' => $notificationsCount,
                'compliant' => $activeCredentials,
                'expiring_soon' => $pendingCredentials,
                'non_compliant' => $activeCredentials === 0 ? 1 : 0,
            ],
            'recentAlerts' => $recentAlerts,
            'calendar' => [
                'month_label' => now()->format('F Y'),
                'today' => (int) now()->format('j'),
                'events' => $calendarEvents,
            ],
        ]);
    }

    public function credentials(Request $request): View
    {
        $employee = Employee::query()->with('department')->where('email', $request->user()->email)->first();

        $credentials = collect();

        if ($employee && $employee->resume_last_updated_at) {
            $credentials->push([
                'type' => 'resume',
                'label' => 'Resume',
                'title' => 'Professional Resume',
                'status' => $employee->resume_last_updated_at->lt(now()->subMonths(6)) ? 'Needs Update' : 'Valid',
                'updated_at' => $employee->resume_last_updated_at,
            ]);
        }

        $byType = $credentials->groupBy('type')->map->count();

        return view('employee.credentials', [
            'credentials' => $credentials,
            'credentialCounts' => [
                'all' => $credentials->count(),
                'resume' => (int) $byType->get('resume', 0),
                'prc' => (int) $byType->get('prc', 0),
                'seminars' => (int) $byType->get('seminars', 0),
                'degrees' => (int) $byType->get('degrees', 0),
                'ranking' => (int) $byType->get('ranking', 0),
            ],
        ]);
    }

    public function credentialsUpload(Request $request): View
    {
        $employee = Employee::query()->with('department')->where('email', $request->user()->email)->first();

        return view('employee.credentials-upload', [
            'employee' => $employee,
            'credentialTypes' => [
                'Resume',
                'PRC License',
                'Seminar / Training',
                'Academic Degree',
                'Ranking File',
            ],
            'departments' => Employee::query()
                ->with('department')
                ->whereNotNull('department_id')
                ->get()
                ->pluck('department.name')
                ->filter()
                ->unique()
                ->values(),
        ]);
    }

    public function attendance(Request $request): View
    {
        $employee = Employee::query()->where('email', $request->user()->email)->first();
        $records = $this->buildAttendanceRecords($employee);

        $totals = [
            'tardiness' => $records->sum('tardiness_minutes'),
            'undertime' => $records->sum('undertime_minutes'),
            'overtime' => $records->sum('overtime_minutes'),
            'absences' => $records->where('status', 'Absent')->count(),
            'workload_credits' => $records->where('status', 'Present')->count(),
        ];

        return view('employee.attendance', [
            'records' => $records,
            'totals' => $totals,
            'periods' => [now()->format('F Y')],
        ]);
    }

    public function leave(Request $request): View
    {
        $employee = Employee::query()->where('email', $request->user()->email)->first();
        $seed = $employee ? abs(crc32($employee->employee_id ?? $employee->email)) : 7;

        $leaveBalances = [
            ['type' => 'Vacation Leave', 'remaining' => 8 + ($seed % 6)],
            ['type' => 'Sick Leave', 'remaining' => 6 + ($seed % 5)],
            ['type' => 'Emergency Leave', 'remaining' => 2 + ($seed % 2)],
        ];

        $leaveHistory = collect([
            [
                'type' => 'Sick Leave',
                'start' => now()->subDays(23)->toDateString(),
                'end' => now()->subDays(22)->toDateString(),
                'days' => 2,
                'status' => 'Approved',
                'cutoff' => now()->subDays(15)->format('M d, Y'),
                'reason' => 'Medical rest',
            ],
            [
                'type' => 'Vacation Leave',
                'start' => now()->subDays(45)->toDateString(),
                'end' => now()->subDays(43)->toDateString(),
                'days' => 3,
                'status' => 'Approved',
                'cutoff' => now()->subDays(30)->format('M d, Y'),
                'reason' => 'Family commitment',
            ],
        ]);

        return view('employee.leave', [
            'leaveBalances' => $leaveBalances,
            'leaveHistory' => $leaveHistory,
        ]);
    }

    public function account(Request $request): View
    {
        $employee = Employee::query()->with('department')->where('email', $request->user()->email)->first();

        return view('employee.account', [
            'employee' => $employee,
            'employeeTypes' => ['Faculty', 'Security', 'ASP'],
        ]);
    }

    private function leaveBalanceFor(?Employee $employee): int
    {
        if (! $employee) {
            return 0;
        }

        return 10 + (abs(crc32($employee->employee_id ?? $employee->email)) % 8);
    }

    private function buildAttendanceRecords(?Employee $employee): Collection
    {
        $period = CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth());

        return collect($period)
            ->filter(fn (Carbon $date) => ! $date->isWeekend())
            ->take(12)
            ->map(function (Carbon $date, int $index) use ($employee) {
                $seed = $employee ? abs(crc32(($employee->employee_id ?? $employee->email).$date->toDateString())) : $index;

                $isAbsent = $seed % 11 === 0;
                $tardiness = $isAbsent ? 0 : ($seed % 3) * 5;
                $undertime = $isAbsent ? 0 : ($seed % 2) * 5;
                $overtime = $isAbsent ? 0 : ($seed % 4) * 5;

                $timeIn = $isAbsent ? null : $date->copy()->setTime(8, 30)->addMinutes($tardiness)->format('h:i A');
                $timeOut = $isAbsent ? null : $date->copy()->setTime(17, 30)->subMinutes($undertime)->addMinutes($overtime)->format('h:i A');

                return [
                    'date' => $date->format('M d, Y'),
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'scheduled' => '08:30 AM - 05:30 PM',
                    'tardiness_minutes' => $tardiness,
                    'undertime_minutes' => $undertime,
                    'overtime_minutes' => $overtime,
                    'status' => $isAbsent ? 'Absent' : 'Present',
                ];
            })
            ->values();
    }
}
