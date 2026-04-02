<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class OperationsController extends Controller
{
    public function profile(Request $request): View
    {
        $employeeId = $request->integer('employee');

        $employee = Employee::query()
            ->with('department')
            ->when($employeeId, fn ($query) => $query->whereKey($employeeId))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->first();

        return view('hr.viewemployeeprofile', [
            'employee' => $employee,
        ]);
    }

    public function credentials(): View
    {
        $employees = Employee::query()
            ->with('department')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $credentialRows = $employees->map(function (Employee $employee) {
            $isExpired = ! $employee->resume_last_updated_at || $employee->resume_last_updated_at->lt(now()->subMonths(6));

            return [
                'employee' => $employee,
                'credential' => 'Professional Resume',
                'type' => 'Resume',
                'expiry_date' => optional($employee->resume_last_updated_at)->addMonths(12)?->format('M d, Y') ?? 'N/A',
                'status' => $isExpired ? 'Pending' : 'Verified',
            ];
        });

        return view('hr.credentials', [
            'credentialRows' => $credentialRows,
            'departments' => Department::query()->orderBy('name')->get(),
            'stats' => [
                'total' => $credentialRows->count(),
                'pending' => $credentialRows->where('status', 'Pending')->count(),
                'verified' => $credentialRows->where('status', 'Verified')->count(),
                'expiring_soon' => $credentialRows->filter(fn ($row) => $row['employee']->resume_last_updated_at && $row['employee']->resume_last_updated_at->lt(now()->subMonths(5)))->count(),
            ],
        ]);
    }

    public function timekeeping(): View
    {
        $employeeCards = Employee::query()
            ->with('department')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(fn (Employee $employee) => [
                'id' => $employee->id,
                'initials' => str($employee->full_name)->explode(' ')->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join(''),
                'name' => $employee->full_name,
                'department' => $employee->department?->name ?? 'Unassigned',
                'present' => max(0, 18 - (abs(crc32(($employee->employee_id ?? $employee->email).'present')) % 4)),
                'tardiness' => abs(crc32(($employee->employee_id ?? $employee->email).'late')) % 36,
                'official_time' => sprintf('%s - %s', optional($employee->official_time_in)?->format('H:i') ?? '08:30', optional($employee->official_time_out)?->format('H:i') ?? '17:30'),
            ]);

        return view('hr.timekeeping', [
            'employeeCards' => $employeeCards,
            'periods' => [now()->format('F Y')],
        ]);
    }

    public function dailyTimeRecord(Request $request): View
    {
        $employeeId = $request->integer('employee');

        $employee = Employee::query()
            ->with('department')
            ->when($employeeId, fn ($query) => $query->whereKey($employeeId))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->first();

        $records = $this->buildAttendanceRows($employee);

        $summary = [
            'present_days' => $records->where('status', 'Present')->count(),
            'absent_days' => $records->where('status', 'Absent')->count(),
            'tardiness_total' => $records->sum('tardiness_minutes'),
            'undertime_total' => $records->sum('undertime_minutes'),
        ];

        return view('hr.dailytimerecord', [
            'employee' => $employee,
            'records' => $records,
            'summary' => $summary,
            'period_label' => now()->format('F Y'),
            'official_time' => sprintf('%s - %s', optional($employee?->official_time_in)?->format('H:i') ?? '08:30', optional($employee?->official_time_out)?->format('H:i') ?? '17:30'),
        ]);
    }

    public function leaveManagement(): View
    {
        $employees = Employee::query()
            ->with('department')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $leaveCards = $employees->map(function (Employee $employee) {
            $seed = abs(crc32($employee->employee_id ?? $employee->email));

            $vacationRemaining = 8 + ($seed % 8);
            $sickRemaining = 7 + ($seed % 7);
            $emergencyRemaining = 2 + ($seed % 2);
            $remaining = $vacationRemaining + $sickRemaining + $emergencyRemaining;
            $used = max(36 - $remaining, 0);

            return [
                'name' => $employee->full_name,
                'department' => $employee->department?->name ?? 'Unassigned',
                'initials' => str($employee->full_name)->explode(' ')->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join(''),
                'vacation_remaining' => $vacationRemaining,
                'sick_remaining' => $sickRemaining,
                'emergency_remaining' => $emergencyRemaining,
                'remaining' => $remaining,
                'used' => $used,
                'carry_over' => $seed % 6,
            ];
        });

        return view('hr.leavemanagement', [
            'leaveCards' => $leaveCards,
            'departments' => Department::query()->orderBy('name')->get(),
            'stats' => [
                'total_employees' => $leaveCards->count(),
                'vacation_used' => $leaveCards->sum('used'),
                'sick_used' => $leaveCards->sum('used') > 0 ? (int) floor($leaveCards->sum('used') * 0.4) : 0,
                'current_year' => now()->year,
            ],
        ]);
    }

    public function uploadBiometrics(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'biometrics_file' => ['required', 'file', 'mimes:pdf'],
        ]);

        $path = $validated['biometrics_file']->store('biometrics', 'private');

        return back()->with('success', 'Biometrics PDF uploaded successfully. Stored at: '.$path);
    }

    private function buildAttendanceRows(?Employee $employee): Collection
    {
        $period = CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth());

        return collect($period)
            ->take(18)
            ->map(function (Carbon $date, int $index) use ($employee) {
                $seed = $employee ? abs(crc32(($employee->employee_id ?? $employee->email).$date->toDateString())) : $index;

                if ($date->isWeekend()) {
                    return [
                        'date' => $date->format('M j'),
                        'day' => $date->format('D'),
                        'time_in' => '-',
                        'time_out' => '-',
                        'tardiness_minutes' => 0,
                        'undertime_minutes' => 0,
                        'status' => 'Weekend',
                    ];
                }

                $isAbsent = $seed % 12 === 0;
                $tardiness = $isAbsent ? 0 : ($seed % 4) * 5;
                $undertime = $isAbsent ? 0 : ($seed % 3) * 5;

                return [
                    'date' => $date->format('M j'),
                    'day' => $date->format('D'),
                    'time_in' => $isAbsent ? '-' : $date->copy()->setTime(8, 30)->addMinutes($tardiness)->format('H:i'),
                    'time_out' => $isAbsent ? '-' : $date->copy()->setTime(17, 30)->subMinutes($undertime)->format('H:i'),
                    'tardiness_minutes' => $tardiness,
                    'undertime_minutes' => $undertime,
                    'status' => $isAbsent ? 'Absent' : 'Present',
                ];
            })
            ->values();
    }
}
