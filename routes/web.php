<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// HR Module Routes
Route::prefix('hr')->group(function () {
    Route::get('/', function () {
        return view('hr.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('hr.dashboard');
    })->name('dashboard.show');

    Route::get('/employees', function () {
        return view('hr.employees');
    })->name('employees.index');

    Route::get('/employees/profile', function () {
        return view('hr.viewemployeeprofile');
    })->name('employees.profile');

    Route::get('/credentials', function () {
        return view('hr.credentials');
    })->name('credentials.index');

    Route::get('/timekeeping', function () {
        return view('hr.timekeeping');
    })->name('timekeeping.index');

    Route::get('/timekeeping/daily-time-record', function () {
        return view('hr.dailytimerecord');
    })->name('timekeeping.dtr');

    Route::get('/leave-management', function () {
        return view('hr.leavemanagement');
    })->name('leave.index');

    Route::get('/announcements', function () {
        return view('hr.announcements');
    })->name('announcements.index');

    Route::get('/notifications', function () {
        return view('hr.notifications');
    })->name('notifications.index');
});

// Employee (User) Module Routes
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('employee.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('dashboard');

    Route::get('/credentials', function () {
        return view('employee.credentials');
    })->name('credentials');

    Route::get('/credentials/upload', function () {
        return view('employee.credentials-upload');
    })->name('credentials.upload');

    Route::get('/attendance-dtr', function () {
        return view('employee.attendance');
    })->name('attendance');

    Route::get('/leave-monitoring', function () {
        return view('employee.leave');
    })->name('leave');

    Route::get('/notifications', function () {
        return view('employee.notifications');
    })->name('notifications');

    Route::get('/account', function () {
        return view('employee.account');
    })->name('account');
});

// Admin (User) Module Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/user-management/accounts', function () {
        return view('admin.user-accounts');
    })->name('users.accounts');

    Route::get('/user-management/role-assignment', function () {
        return view('admin.role-assignment');
    })->name('users.role-assignment');

    Route::get('/user-management/rbac-permissions', function () {
        return view('admin.rbac');
    })->name('users.rbac');

    Route::get('/policy/cutoff-schedules', function () {
        return view('admin.cutoff-schedules');
    })->name('policy.cutoff');

    Route::get('/policy/leave-rules', function () {
        return view('admin.leave-rules');
    })->name('policy.leave');

    Route::get('/policy/compliance-rules', function () {
        return view('admin.compliance-rules');
    })->name('policy.compliance');

    Route::get('/policy/notification-templates', function () {
        return view('admin.notification-templates');
    })->name('policy.templates');

    Route::get('/integration/api-integrations', function () {
        return view('admin.api-integrations');
    })->name('integration.api');

    Route::get('/integration/audit-logs', function () {
        return view('admin.audit-logs');
    })->name('integration.audit');

    Route::get('/integration/data-validation', function () {
        return view('admin.data-validation');
    })->name('integration.validation');

    Route::get('/integration/backup-security', function () {
        return view('admin.backup-security');
    })->name('integration.backup');

    Route::get('/report-oversight', function () {
        return view('admin.report-oversight');
    })->name('reports');
});

// Default route
Route::get('/', function () {
    return view('hr.dashboard');
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