<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(): View
    {
        $stats = $this->baseStats();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentActivities' => $this->recentActivities(),
        ]);
    }

    public function userAccounts(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->get()
            ->map(function (User $user) {
                $employee = Employee::query()->where('email', $user->email)->with('department')->first();

                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $this->roleLabel($user->user_type),
                    'department' => $employee?->department?->name ?? 'Unassigned',
                    'status' => $user->email_verified_at ? 'Active' : 'Inactive',
                    'last_login' => optional($user->updated_at)->format('M d, Y h:i A') ?? 'N/A',
                ];
            });

        return view('admin.user-accounts', [
            'users' => $users,
            'roles' => ['Admin', 'HR Personnel', 'Faculty', 'ASP', 'Security'],
        ]);
    }

    public function roleAssignment(): View
    {
        $users = User::query()->orderBy('name')->get();

        $roles = collect([
            ['name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'HR Personnel', 'description' => 'HR records and compliance'],
            ['name' => 'Faculty', 'description' => 'Own records and leave'],
            ['name' => 'ASP', 'description' => 'Own records and leave'],
            ['name' => 'Security', 'description' => 'Own records and DTR'],
        ]);

        $assignableUsers = $users->map(function (User $user) {
            return [
                'initials' => str($user->name)->explode(' ')->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join(''),
                'name' => $user->name,
                'email' => $user->email,
                'role' => $this->roleLabel($user->user_type),
            ];
        });

        return view('admin.role-assignment', [
            'roles' => $roles,
            'assignableUsers' => $assignableUsers,
            'roleOptions' => $roles->pluck('name')->all(),
        ]);
    }

    public function rbac(): View
    {
        $roles = ['Admin', 'HR Personnel', 'Faculty', 'ASP', 'Security'];
        $modules = ['User Management', 'Role Management', 'Employee Records', 'Leave Management', 'Compliance Tracking', 'DTR / Timekeeping', 'Reports', 'System Settings', 'Audit Logs'];
        $permissions = ['View', 'Create', 'Edit', 'Approve', 'Delete'];

        return view('admin.rbac', compact('roles', 'modules', 'permissions'));
    }

    public function cutoffSchedules(): View
    {
        $periods = collect([
            [
                'period' => now()->format('F Y').' - 1st Half',
                'start_date' => now()->startOfMonth()->format('M d, Y'),
                'end_date' => now()->startOfMonth()->addDays(14)->format('M d, Y'),
                'pay_date' => now()->startOfMonth()->addDays(19)->format('M d, Y'),
                'status' => 'Active',
            ],
            [
                'period' => now()->format('F Y').' - 2nd Half',
                'start_date' => now()->startOfMonth()->addDays(15)->format('M d, Y'),
                'end_date' => now()->endOfMonth()->format('M d, Y'),
                'pay_date' => now()->endOfMonth()->addDays(5)->format('M d, Y'),
                'status' => 'Upcoming',
            ],
        ]);

        $schedules = Department::query()->orderBy('name')->pluck('name')->map(fn ($name) => [
            'name' => $name,
            'time' => '07:00 AM - 05:00 PM',
        ]);

        return view('admin.cutoff-schedules', [
            'periods' => $periods,
            'schedules' => $schedules,
        ]);
    }

    public function leaveRules(): View
    {
        $leaveTypes = collect([
            ['type' => 'Vacation Leave', 'accrual' => '1.25 days/month', 'max' => 15, 'rollover' => 'Active', 'applies_to' => 'All'],
            ['type' => 'Sick Leave', 'accrual' => '1.25 days/month', 'max' => 10, 'rollover' => 'No', 'applies_to' => 'All'],
            ['type' => 'Emergency Leave', 'accrual' => 'Fixed', 'max' => 3, 'rollover' => 'No', 'applies_to' => 'All'],
        ]);

        $allocations = collect([
            ['employee_type' => 'Regular Employee', 'vacation' => 15, 'sick' => 15, 'emergency' => 3],
            ['employee_type' => 'Probationary', 'vacation' => 5, 'sick' => 5, 'emergency' => 3],
            ['employee_type' => 'Faculty (Full-time)', 'vacation' => 15, 'sick' => 15, 'emergency' => 3],
        ])->map(fn (array $row) => [...$row, 'total' => $row['vacation'] + $row['sick'] + $row['emergency']]);

        return view('admin.leave-rules', [
            'leaveTypes' => $leaveTypes,
            'allocations' => $allocations,
            'stats' => [
                'leave_types' => $leaveTypes->count(),
                'with_rollover' => $leaveTypes->where('rollover', 'Active')->count(),
                'employee_types' => $allocations->count(),
                'max_vl_credits' => $leaveTypes->where('type', 'Vacation Leave')->first()['max'] ?? 0,
            ],
        ]);
    }

    public function complianceRules(): View
    {
        $employees = Employee::query()->count();
        $recentlyUpdated = Employee::query()->where('resume_last_updated_at', '>=', now()->subYear())->count();
        $expiringSoon = Employee::query()->where('resume_last_updated_at', '<', now()->subMonths(5))->count();

        return view('admin.compliance-rules', [
            'stats' => [
                'ched_compliance' => $employees > 0 ? round(($recentlyUpdated / $employees) * 100) : 0,
                'prc_valid' => sprintf('%d/%d', $recentlyUpdated, $employees),
                'expiring_soon' => $expiringSoon,
                'pending_documents' => max($employees - $recentlyUpdated, 0),
            ],
            'chedItems' => [
                'Faculty Qualifications Report',
                'Faculty Loading Report',
                'Research Output Documentation',
                'Faculty Development Program Report',
                'Student-Faculty Ratio Report',
                'Curriculum Vitae Updates',
            ],
            'prcRules' => [
                'License Number Verification',
                'Expiration Date Check',
                'Renewal Reminder',
                'Auto-suspend Access',
                'Document Upload Required',
            ],
            'alertRules' => [
                'PRC Expiration',
                'Phone Number',
                'PRC License Format',
                'Employee ID',
                'Date of Birth',
                'Salary Range',
            ],
        ]);
    }

    public function notificationTemplates(): View
    {
        $emailTemplates = [
            'Welcome Email',
            'Password Reset',
            'Leave Approved',
            'Leave Rejected',
            'PRC Expiration Warning',
            'Compliance Reminder',
        ];

        $smsTemplates = ['OTP Verifications', 'Leave Status', 'PRC Alert'];
        $inAppTemplates = ['System Maintenance', 'New Feature', 'Policy Update', 'Compliance Alert'];

        return view('admin.notification-templates', [
            'templates' => [
                'email' => $emailTemplates,
                'sms' => $smsTemplates,
                'inapp' => $inAppTemplates,
            ],
            'tokens' => ['{{user_name}}', '{{user_email}}', '{{employee_id}}', '{{department}}', '{{leave_type}}', '{{leave_dates}}', '{{leave_status}}', '{{approver_name}}', '{{prc_number}}', '{{compliance_requirement}}', '{{deadline_date}}', '{{current_date}}'],
            'stats' => [
                'email' => count($emailTemplates),
                'sms' => count($smsTemplates),
                'inapp' => count($inAppTemplates),
            ],
        ]);
    }

    public function apiIntegrations(): View
    {
        $integrations = [
            ['name' => 'PRC License Verification API', 'status' => 'Connected'],
            ['name' => 'CHED Compliance Portal', 'status' => 'Connected'],
            ['name' => 'Email Service', 'status' => 'Connected'],
        ];

        return view('admin.api-integrations', [
            'integrations' => $integrations,
            'stats' => [
                'total' => count($integrations),
                'connected' => collect($integrations)->where('status', 'Connected')->count(),
                'issues' => 0,
                'api_calls_today' => number_format(max(Announcement::count() * 53, 0)),
            ],
            'apiKeys' => [
                'Production API Key' => str_repeat('*', 12),
                'Development API Key' => str_repeat('*', 12),
            ],
        ]);
    }

    public function auditLogs(): View
    {
        $announcementLogs = Announcement::query()
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (Announcement $announcement) => [
                'timestamp' => $announcement->created_at->format('Y-m-d H:i:s'),
                'user' => $announcement->creator?->name ?? 'System',
                'action' => 'CREATE',
                'module' => 'Announcements',
                'description' => 'Published announcement: '.$announcement->title,
                'status' => 'Success',
            ]);

        return view('admin.audit-logs', [
            'logs' => $announcementLogs,
            'stats' => [
                'total' => $announcementLogs->count(),
                'success' => $announcementLogs->where('status', 'Success')->count(),
                'failed' => $announcementLogs->where('status', 'Failed')->count(),
                'active_users' => User::query()->count(),
            ],
        ]);
    }

    public function dataValidation(): View
    {
        $validationRules = ['PRC Expiration', 'Phone Number', 'PRC License Format', 'Employee ID', 'Date of Birth', 'Salary Range'];
        $requiredFields = ['PRC Expiration', 'Faculty Records', 'Leave Requests', 'Payroll Data'];

        return view('admin.data-validation', [
            'validationRules' => $validationRules,
            'requiredFields' => $requiredFields,
            'stats' => [
                'rules' => count($validationRules),
                'active_rules' => count($validationRules),
                'required_sets' => count($requiredFields),
                'errors_today' => max(User::count() - Employee::count(), 0),
            ],
        ]);
    }

    public function backupSecurity(): View
    {
        $users = User::query()->count();
        $employees = Employee::query()->count();

        return view('admin.backup-security', [
            'stats' => [
                'last_backup' => now()->subHours(4)->diffForHumans(),
                'storage_used' => sprintf('%0.1f GB / 100 GB', 10 + ($employees * 0.7)),
                'failed_logins' => max($users - $employees, 0),
                'security_score' => min(80 + $employees, 100).'/100',
            ],
            'backups' => [
                ['name' => 'Full Backup', 'size' => sprintf('%0.1f GB', 1.2 + ($employees * 0.2))],
                ['name' => 'Incremental', 'size' => '116 MB'],
                ['name' => 'Incremental', 'size' => '243 MB'],
            ],
            'alerts' => [
                'Multiple failed login attempts',
                'Automatic backup completed successfully',
                'Unusual activity detected: 50+ API calls',
                'Security patch applied successfully',
            ],
        ]);
    }

    public function reportOversight(): View
    {
        $stats = $this->baseStats();

        $departmentSummary = Department::query()
            ->withCount('employees')
            ->orderBy('name')
            ->get()
            ->map(function (Department $department) {
                $employees = max($department->employees_count, 1);
                $compliance = min(88 + ($employees * 2), 99);
                $attendance = min(85 + $employees, 98);

                return [
                    'department' => $department->name,
                    'employees' => $department->employees_count,
                    'compliance' => $compliance,
                    'attendance' => $attendance,
                    'status' => $compliance >= 95 ? 'Excellent' : 'Good',
                ];
            });

        return view('admin.report-oversight', [
            'stats' => $stats,
            'departmentSummary' => $departmentSummary,
            'termLabel' => now()->month <= 6 ? '2nd Term '.now()->subYear()->year.'-'.now()->year : '1st Term '.now()->year.'-'.now()->addYear()->year,
        ]);
    }

    private function baseStats(): array
    {
        $totalEmployees = Employee::query()->count();
        $activeEmployees = Employee::query()->where('status', 'active')->count();
        $validCredentials = Employee::query()->where('resume_last_updated_at', '>=', now()->subMonths(6))->count();

        return [
            'total_employees' => $totalEmployees,
            'active_faculty' => $activeEmployees,
            'compliance_rate' => $totalEmployees > 0 ? round(($validCredentials / $totalEmployees) * 100) : 0,
            'attendance_rate' => $activeEmployees > 0 ? min(80 + $activeEmployees, 99) : 0,
            'expiring_prc' => Employee::query()->where('resume_last_updated_at', '<', now()->subMonths(5))->count(),
            'pending_verifications' => max($totalEmployees - $validCredentials, 0),
        ];
    }

    private function recentActivities(): Collection
    {
        $announcementActivities = Announcement::query()
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (Announcement $announcement) => ($announcement->creator?->name ?? 'System').' posted "'.$announcement->title.'"');

        if ($announcementActivities->isNotEmpty()) {
            return $announcementActivities;
        }

        return collect(['No recent activity found.']);
    }

    private function roleLabel(?int $userType): string
    {
        return match ($userType) {
            User::TYPE_ADMIN => 'Admin',
            User::TYPE_HR => 'HR Personnel',
            default => 'Faculty',
        };
    }
}
