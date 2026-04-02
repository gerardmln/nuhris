<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PortalController as AdminPortalController;
use App\Http\Controllers\Employee\PortalController as EmployeePortalController;
use App\Http\Controllers\Hr\AnnouncementController;
use App\Http\Controllers\Hr\DashboardController;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\OperationsController;
use App\Models\AnnouncementNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// HR Module Routes
Route::prefix('hr')->middleware(['auth', 'user.type:2'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.show');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->whereNumber('employee')->name('employees.show');

    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->whereNumber('employee')->name('employees.edit');

    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->whereNumber('employee')->name('employees.update');

    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->whereNumber('employee')->name('employees.destroy');

    Route::get('/employees/profile', [OperationsController::class, 'profile'])->name('employees.profile');

    Route::get('/credentials', [OperationsController::class, 'credentials'])->name('credentials.index');

    Route::get('/timekeeping', [OperationsController::class, 'timekeeping'])->name('timekeeping.index');

    Route::post('/biometrics/upload', [OperationsController::class, 'uploadBiometrics'])->name('biometrics.upload');

    Route::get('/timekeeping/daily-time-record', [OperationsController::class, 'dailyTimeRecord'])->name('timekeeping.dtr');

    Route::get('/leave-management', [OperationsController::class, 'leaveManagement'])->name('leave.index');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    Route::get('/notifications', function () {
        $notifications = AnnouncementNotification::query()
            ->with('announcement')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('hr.notifications', [
            'notifications' => $notifications,
        ]);
    })->name('notifications.index');
});

// Employee (User) Module Routes
Route::prefix('employee')->name('employee.')->middleware(['auth', 'user.type:3'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('employee.dashboard');
    });

    Route::get('/dashboard', [EmployeePortalController::class, 'dashboard'])->name('dashboard');

    Route::get('/credentials', [EmployeePortalController::class, 'credentials'])->name('credentials');

    Route::get('/credentials/upload', [EmployeePortalController::class, 'credentialsUpload'])->name('credentials.upload');

    Route::get('/attendance-dtr', [EmployeePortalController::class, 'attendance'])->name('attendance');

    Route::get('/leave-monitoring', [EmployeePortalController::class, 'leave'])->name('leave');

    Route::get('/notifications', function () {
        $notifications = AnnouncementNotification::query()
            ->with('announcement')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('employee.notifications', [
            'notifications' => $notifications,
        ]);
    })->name('notifications');

    Route::get('/account', [EmployeePortalController::class, 'account'])->name('account');
});

// Admin (User) Module Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'user.type:1'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminPortalController::class, 'dashboard'])->name('dashboard');

    Route::get('/user-management/accounts', [AdminPortalController::class, 'userAccounts'])->name('users.accounts');

    Route::get('/user-management/role-assignment', [AdminPortalController::class, 'roleAssignment'])->name('users.role-assignment');

    Route::get('/user-management/rbac-permissions', [AdminPortalController::class, 'rbac'])->name('users.rbac');

    Route::get('/policy/cutoff-schedules', [AdminPortalController::class, 'cutoffSchedules'])->name('policy.cutoff');

    Route::get('/policy/leave-rules', [AdminPortalController::class, 'leaveRules'])->name('policy.leave');

    Route::get('/policy/compliance-rules', [AdminPortalController::class, 'complianceRules'])->name('policy.compliance');

    Route::get('/policy/notification-templates', [AdminPortalController::class, 'notificationTemplates'])->name('policy.templates');

    Route::get('/integration/api-integrations', [AdminPortalController::class, 'apiIntegrations'])->name('integration.api');

    Route::get('/integration/audit-logs', [AdminPortalController::class, 'auditLogs'])->name('integration.audit');

    Route::get('/integration/data-validation', [AdminPortalController::class, 'dataValidation'])->name('integration.validation');

    Route::get('/integration/backup-security', [AdminPortalController::class, 'backupSecurity'])->name('integration.backup');

    Route::get('/report-oversight', [AdminPortalController::class, 'reportOversight'])->name('reports');
});

// Default route
Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return match ((int) Auth::user()->user_type) {
        1 => redirect()->route('admin.dashboard'),
        2 => redirect()->route('dashboard'),
        default => redirect()->route('employee.dashboard'),
    };
})->name('home');

/*
Keep profile protected, or remove this whole group if you want everything public.
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';