<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased overflow-x-hidden overflow-y-auto">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full bg-[#00386f] text-white lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:shrink-0">
            <div class="border-b border-white/20 px-6 py-5">
                <p class="text-2xl font-extrabold tracking-wide">NU HRIS</p>
                <p class="text-sm text-blue-100">Human Resources</p>
            </div>

            <nav class="px-4 py-4">
                <ul class="space-y-2 text-[15px]">
                    <li>
                        <a href="{{ route('dashboard') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('employees.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            Employees
                        </a>
                    </li>
                    <li><a href="{{ route('credentials.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Credentials</a></li>
                    <li><a href="{{ route('timekeeping.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Time Keeping</a></li>
                    <li><a href="{{ route('leave.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Leave Management</a></li>
                    <li><a href="{{ route('announcements.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Announcements</a></li>
                </ul>
            </nav>

            <div class="mt-8 border-t border-white/20 px-5 py-5 lg:mt-auto">
                <div class="mb-4">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Martinez, Ian Isaac' }}</p>
                    <p class="text-xs text-blue-100">{{ auth()->user()->email ?? 'user' }}</p>
                </div>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-white/20 px-4 py-2 text-left text-sm font-medium hover:bg-white/10">
                            Sign out
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Employees</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                @if (session('success'))
                    <div class="rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1f2b5d]">Employees</h2>
                        <p class="text-sm text-slate-500">Manage faculty and staff records</p>
                    </div>
                    <button data-open-modal="employee-add-modal" class="rounded-lg bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">+ Add Employee</button>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white p-3 shadow-sm">
                    <form method="GET" action="{{ route('employees.index') }}" class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ $filters['search'] }}"
                                placeholder="Search by name, email, or ID..."
                                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none"
                            >
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <select name="department_id" class="rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected($filters['department_id'] == $department->id)>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <div class="flex gap-2">
                                <select name="status" class="w-full rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                    <option value="">All Status</option>
                                    <option value="active" @selected($filters['status'] === 'active')>Active</option>
                                    <option value="on_leave" @selected($filters['status'] === 'on_leave')>On Leave</option>
                                    <option value="resigned" @selected($filters['status'] === 'resigned')>Resigned</option>
                                    <option value="terminated" @selected($filters['status'] === 'terminated')>Terminated</option>
                                </select>
                                <button type="submit" class="rounded-md bg-[#00386f] px-3 py-2 text-xs font-semibold text-white hover:bg-[#002f5d]">Filter</button>
                            </div>
                        </div>
                    </form>
                </article>

                <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white shadow-sm">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-300 bg-slate-50 text-xs uppercase tracking-wide text-slate-600">
                            <tr>
                                <th class="px-5 py-3">Employee</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Position</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Resume</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($employees as $employee)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">
                                                {{ strtoupper(substr($employee->first_name, 0, 1).substr($employee->last_name, 0, 1)) }}
                                            </span>
                                            <div>
                                                <p class="font-semibold text-slate-800">{{ $employee->full_name }}</p>
                                                <p class="text-xs text-slate-500">{{ $employee->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-700">{{ $employee->department?->name }}</td>
                                    <td class="px-4 py-4 text-slate-700">{{ $employee->position }}</td>
                                    <td class="px-4 py-4">
                                        <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                                            {{ str_replace('_', ' ', ucfirst($employee->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if ($employee->resume_last_updated_at)
                                            <span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Updated</span>
                                        @else
                                            <span class="rounded border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Needs Update</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">
                                        <details class="relative inline-block">
                                            <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                            <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                                <a href="#"
                                                    data-open-modal="employee-details-modal"
                                                    data-employee-id="{{ $employee->id }}"
                                                    data-employee-employee-id="{{ $employee->employee_id }}"
                                                    data-employee-first-name="{{ $employee->first_name }}"
                                                    data-employee-last-name="{{ $employee->last_name }}"
                                                    data-employee-full-name="{{ $employee->full_name }}"
                                                    data-employee-email="{{ $employee->email }}"
                                                    data-employee-phone="{{ $employee->phone }}"
                                                    data-employee-department-id="{{ $employee->department_id }}"
                                                    data-employee-department-name="{{ $employee->department?->name }}"
                                                    data-employee-position="{{ $employee->position }}"
                                                    data-employee-employment-type="{{ $employee->employment_type }}"
                                                    data-employee-ranking="{{ $employee->ranking }}"
                                                    data-employee-status="{{ $employee->status }}"
                                                    data-employee-hire-date="{{ $employee->hire_date?->format('Y-m-d') }}"
                                                    data-employee-official-time-in="{{ $employee->official_time_in?->format('H:i') }}"
                                                    data-employee-official-time-out="{{ $employee->official_time_out?->format('H:i') }}"
                                                    data-employee-resume-last-updated="{{ $employee->resume_last_updated_at?->format('Y-m-d') }}"
                                                    class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                                <a href="#"
                                                    data-open-modal="employee-edit-modal"
                                                    data-employee-id="{{ $employee->id }}"
                                                    data-employee-employee-id="{{ $employee->employee_id }}"
                                                    data-employee-first-name="{{ $employee->first_name }}"
                                                    data-employee-last-name="{{ $employee->last_name }}"
                                                    data-employee-full-name="{{ $employee->full_name }}"
                                                    data-employee-email="{{ $employee->email }}"
                                                    data-employee-phone="{{ $employee->phone }}"
                                                    data-employee-department-id="{{ $employee->department_id }}"
                                                    data-employee-department-name="{{ $employee->department?->name }}"
                                                    data-employee-position="{{ $employee->position }}"
                                                    data-employee-employment-type="{{ $employee->employment_type }}"
                                                    data-employee-ranking="{{ $employee->ranking }}"
                                                    data-employee-status="{{ $employee->status }}"
                                                    data-employee-hire-date="{{ $employee->hire_date?->format('Y-m-d') }}"
                                                    data-employee-official-time-in="{{ $employee->official_time_in?->format('H:i') }}"
                                                    data-employee-official-time-out="{{ $employee->official_time_out?->format('H:i') }}"
                                                    data-employee-resume-last-updated="{{ $employee->resume_last_updated_at?->format('Y-m-d') }}"
                                                    class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                                <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                                <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Delete this employee?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</button>
                                                </form>
                                            </div>
                                        </details>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-6 text-center text-sm text-slate-500">No employee records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </article>

                <div>
                    {{ $employees->links() }}
                </div>

                <div class="h-8"></div>
            </section>
        </main>
    </div>
    <div id="employee-add-modal" class="modal-overlay fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-8 py-6">
                <div>
                    <h3 class="text-4xl font-bold text-[#1f2b5d]">Add New Employee</h3>
                    <p class="text-2xl text-slate-500">Enter the details of the new employee</p>
                </div>
                <button type="button" data-close-modal class="text-5xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <form method="POST" action="{{ route('employees.store') }}" data-employee-form class="grid grid-cols-1 gap-4 px-8 pb-8 md:grid-cols-2">
                @csrf
                <div class="md:col-span-2 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3">
                    <p class="text-sm font-semibold text-[#1f2b8b]">Employee ID</p>
                    <p class="text-sm text-slate-500">Automatically generated on save using the format <span class="font-medium text-slate-700">YYYY-001</span>.</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Email *</label>
                    <input name="email" type="email" placeholder="email@nu.edu.ph" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">First Name *</label>
                    <input name="first_name" type="text" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Last Name *</label>
                    <input name="last_name" type="text" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Phone</label>
                    <input name="phone" type="text" placeholder="+63 XXX XXX XXXX" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employee Type *</label>
                    <select name="employment_type" data-employee-control="employment_type" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700" required>
                        <option value="">Select type</option>
                        @foreach ($employmentTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Position *</label>
                    <select name="position" data-employee-control="position" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700" required>
                        <option value="">Select Position / Office</option>
                        @foreach ($employeePositions as $position)
                            <option value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-employee-field="department">
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Department *</label>
                    <select name="department_id" data-employee-control="department" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-500">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-employee-field="ranking">
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Faculty Ranking</label>
                    <select name="ranking" data-employee-control="ranking" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700">
                        <option value="">N/A</option>
                        @foreach ($facultyRankings as $ranking)
                            <option value="{{ $ranking }}">{{ $ranking }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Status</label>
                    <select name="status" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                        <option value="active">Active</option>
                        <option value="on_leave">On Leave</option>
                        <option value="resigned">Resigned</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Hire Date</label>
                    <input name="hire_date" type="date" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time In</label>
                    <input name="official_time_in" type="time" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time Out</label>
                    <input name="official_time_out" type="time" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Resume Last Updated</label>
                    <input name="resume_last_updated_at" type="date" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>

                <div class="md:col-span-2 mt-2 flex justify-end gap-3">
                    <button type="button" data-close-modal class="rounded-md border border-slate-300 px-5 py-2 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="rounded-md bg-[#00386f] px-5 py-2 text-lg font-semibold text-white hover:bg-[#002f5d]">Add Employee</button>
                </div>
            </form>
        </div>
    </div>

    <div id="employee-details-modal" class="modal-overlay fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between border-b border-slate-300 px-6 py-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#1f2b5d]">Employee Details</h3>
                </div>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>
            <div class="border-b border-slate-300 px-6 py-5">
                <div class="flex items-center gap-4">
                    <span id="details-initials" class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#00386f] text-2xl text-white">MS</span>
                    <div>
                        <p id="details-full-name" class="text-4xl font-bold text-[#1f2b8b]">Maria Santos</p>
                        <p id="details-position" class="text-2xl text-slate-600">Associate Professor</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 px-6 py-6 text-slate-800 md:grid-cols-2">
                <div>
                    <p class="text-base text-slate-500">Employee ID</p>
                    <p id="details-employee-id" class="text-2xl">NU-2021-001</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Department</p>
                    <p id="details-department" class="text-2xl">College of Computing</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Email</p>
                    <p id="details-email" class="text-2xl">maria.santos@nu.edu.ph</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Phone</p>
                    <p id="details-phone" class="text-2xl">+63 917 123 4567</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Employment Type</p>
                    <p id="details-employment-type" class="text-2xl">Full-time Faculty</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Ranking</p>
                    <p id="details-ranking" class="text-2xl">Associate Professor II</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Hire Date</p>
                    <p id="details-hire-date" class="text-2xl">Jun 15, 2021</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Official Time</p>
                    <p id="details-official-time" class="text-2xl">08:30 - 17:30</p>
                </div>
            </div>
        </div>
    </div>

    <div id="employee-edit-modal" class="modal-overlay fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-8 py-6">
                <div>
                    <h3 class="text-4xl font-bold text-[#1f2b5d]">Edit Employee</h3>
                    <p class="text-2xl text-slate-500">Update employee information</p>
                </div>
                <button type="button" data-close-modal class="text-5xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <form id="employee-edit-form" method="POST" data-employee-form class="grid grid-cols-1 gap-4 px-8 pb-8 md:grid-cols-2">
                @csrf
                @method('PUT')
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employee ID</label>
                    <input id="edit-employee-id" name="employee_id" type="text" value="NU-2021-001" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Email *</label>
                    <input id="edit-email" name="email" type="email" value="maria.santos@nu.edu.ph" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">First Name *</label>
                    <input id="edit-first-name" name="first_name" type="text" value="Maria" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Last Name *</label>
                    <input id="edit-last-name" name="last_name" type="text" value="Santos" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg" required>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Phone</label>
                    <input id="edit-phone" name="phone" type="text" value="+63 917 123 4567" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employee Type *</label>
                    <select id="edit-employment-type" name="employment_type" data-employee-control="employment_type" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700" required>
                        @foreach ($employmentTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Position *</label>
                    <select id="edit-position" name="position" data-employee-control="position" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700" required>
                        @foreach ($employeePositions as $position)
                            <option value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-employee-field="department">
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Department *</label>
                    <select id="edit-department-id" name="department_id" data-employee-control="department" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-500">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div data-employee-field="ranking">
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Faculty Ranking</label>
                    <select id="edit-ranking" name="ranking" data-employee-control="ranking" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-700">
                        <option value="">N/A</option>
                        @foreach ($facultyRankings as $ranking)
                            <option value="{{ $ranking }}">{{ $ranking }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Status</label>
                    <select id="edit-status" name="status" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                        <option value="active">Active</option>
                        <option value="on_leave">On Leave</option>
                        <option value="resigned">Resigned</option>
                        <option value="terminated">Terminated</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Hire Date</label>
                    <input id="edit-hire-date" name="hire_date" type="date" value="2021-06-15" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time In</label>
                    <input id="edit-official-time-in" name="official_time_in" type="time" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time Out</label>
                    <input id="edit-official-time-out" name="official_time_out" type="time" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Resume Last Updated</label>
                    <input id="edit-resume-last-updated" name="resume_last_updated_at" type="date" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>

                <div class="md:col-span-2 mt-2 flex justify-end gap-3">
                    <button type="button" data-close-modal class="rounded-md border border-slate-300 px-5 py-2 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="rounded-md bg-[#00386f] px-5 py-2 text-lg font-semibold text-white hover:bg-[#002f5d]">Edit Employee</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openers = document.querySelectorAll('[data-open-modal]');
        const closers = document.querySelectorAll('[data-close-modal]');
        const modals = document.querySelectorAll('.modal-overlay');

        const employeeEditForm = document.getElementById('employee-edit-form');
        const detailsInitials = document.getElementById('details-initials');
        const detailsFullName = document.getElementById('details-full-name');
        const detailsPosition = document.getElementById('details-position');
        const detailsEmployeeId = document.getElementById('details-employee-id');
        const detailsDepartment = document.getElementById('details-department');
        const detailsEmail = document.getElementById('details-email');
        const detailsPhone = document.getElementById('details-phone');
        const detailsEmploymentType = document.getElementById('details-employment-type');
        const detailsRanking = document.getElementById('details-ranking');
        const detailsHireDate = document.getElementById('details-hire-date');
        const detailsOfficialTime = document.getElementById('details-official-time');

        const editEmployeeId = document.getElementById('edit-employee-id');
        const editEmail = document.getElementById('edit-email');
        const editFirstName = document.getElementById('edit-first-name');
        const editLastName = document.getElementById('edit-last-name');
        const editPhone = document.getElementById('edit-phone');
        const editDepartmentId = document.getElementById('edit-department-id');
        const editPosition = document.getElementById('edit-position');
        const editEmploymentType = document.getElementById('edit-employment-type');
        const editRanking = document.getElementById('edit-ranking');
        const editStatus = document.getElementById('edit-status');
        const editHireDate = document.getElementById('edit-hire-date');
        const editOfficialTimeIn = document.getElementById('edit-official-time-in');
        const editOfficialTimeOut = document.getElementById('edit-official-time-out');
        const editResumeLastUpdated = document.getElementById('edit-resume-last-updated');

        function formatDateForDetails(dateValue) {
            if (!dateValue) return 'N/A';
            const date = new Date(dateValue);
            if (Number.isNaN(date.getTime())) return 'N/A';
            return date.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
        }

        function populateEmployeeModals(trigger) {
            const employeeId = trigger.dataset.employeeId || '';
            const employeeCode = trigger.dataset.employeeEmployeeId || '';
            const fullName = trigger.dataset.employeeFullName || '';
            const firstName = trigger.dataset.employeeFirstName || '';
            const lastName = trigger.dataset.employeeLastName || '';
            const email = trigger.dataset.employeeEmail || '';
            const phone = trigger.dataset.employeePhone || 'N/A';
            const departmentName = trigger.dataset.employeeDepartmentName || 'N/A';
            const departmentId = trigger.dataset.employeeDepartmentId || '';
            const position = trigger.dataset.employeePosition || '';
            const employmentType = trigger.dataset.employeeEmploymentType || 'N/A';
            const ranking = trigger.dataset.employeeRanking || 'N/A';
            const status = trigger.dataset.employeeStatus || 'active';
            const hireDate = trigger.dataset.employeeHireDate || '';
            const officialTimeIn = trigger.dataset.employeeOfficialTimeIn || '';
            const officialTimeOut = trigger.dataset.employeeOfficialTimeOut || '';
            const resumeLastUpdated = trigger.dataset.employeeResumeLastUpdated || '';

            const initials = `${(firstName[0] || '').toUpperCase()}${(lastName[0] || '').toUpperCase()}`;

            if (detailsInitials) detailsInitials.textContent = initials || 'NA';
            if (detailsFullName) detailsFullName.textContent = fullName || 'N/A';
            if (detailsPosition) detailsPosition.textContent = position || 'N/A';
            if (detailsEmployeeId) detailsEmployeeId.textContent = employeeCode || 'N/A';
            if (detailsDepartment) detailsDepartment.textContent = departmentName;
            if (detailsEmail) detailsEmail.textContent = email || 'N/A';
            if (detailsPhone) detailsPhone.textContent = phone || 'N/A';
            if (detailsEmploymentType) detailsEmploymentType.textContent = employmentType || 'N/A';
            if (detailsRanking) detailsRanking.textContent = ranking || 'N/A';
            if (detailsHireDate) detailsHireDate.textContent = formatDateForDetails(hireDate);
            if (detailsOfficialTime) {
                detailsOfficialTime.textContent = officialTimeIn && officialTimeOut
                    ? `${officialTimeIn} - ${officialTimeOut}`
                    : 'N/A';
            }

            if (employeeEditForm && employeeId) {
                employeeEditForm.action = `/hr/employees/${employeeId}`;
            }
            if (editEmployeeId) editEmployeeId.value = employeeCode;
            if (editEmail) editEmail.value = email;
            if (editFirstName) editFirstName.value = firstName;
            if (editLastName) editLastName.value = lastName;
            if (editPhone) editPhone.value = phone === 'N/A' ? '' : phone;
            if (editDepartmentId) editDepartmentId.value = departmentId;
            if (editPosition) editPosition.value = position;
            if (editEmploymentType) editEmploymentType.value = employmentType === 'N/A' ? '' : employmentType;
            if (editRanking) editRanking.value = ranking === 'N/A' ? '' : ranking;
            if (editStatus) editStatus.value = status;
            if (editHireDate) editHireDate.value = hireDate;
            if (editOfficialTimeIn) editOfficialTimeIn.value = officialTimeIn;
            if (editOfficialTimeOut) editOfficialTimeOut.value = officialTimeOut;
            if (editResumeLastUpdated) editResumeLastUpdated.value = resumeLastUpdated;

            if (editPosition) {
                editPosition.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        function closeAllModals() {
            modals.forEach((modal) => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            document.body.classList.remove('overflow-hidden');
        }

        openers.forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                const modalId = trigger.getAttribute('data-open-modal');
                const modal = document.getElementById(modalId);
                if (!modal) return;

                if (trigger.dataset.employeeId) {
                    populateEmployeeModals(trigger);
                }

                closeAllModals();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            });
        });

        closers.forEach((trigger) => {
            trigger.addEventListener('click', closeAllModals);
        });

        modals.forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeAllModals();
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });
    </script>
</body>
</html>
