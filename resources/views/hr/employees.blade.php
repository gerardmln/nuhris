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
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1f2b5d]">Employees</h2>
                        <p class="text-sm text-slate-500">Manage faculty and staff records</p>
                    </div>
                    <button data-open-modal="employee-add-modal" class="rounded-lg bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">+ Add Employee</button>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white p-3 shadow-sm">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <input
                                type="text"
                                placeholder="Search by name, email, or ID..."
                                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none"
                            >
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <select class="rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                <option>All Departments</option>
                                <option>College of Engineering</option>
                                <option>College of Business</option>
                                <option>College of Education</option>
                                <option>College of Arts &amp; Sciences</option>
                                <option>College of Computing</option>
                                <option>College of Allied Health</option>
                                <option>Administration</option>
                                <option>Human Resources</option>
                            </select>
                            <select class="rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>On Leave</option>
                                <option>Resigned</option>
                                <option>Terminated</option>
                            </select>
                        </div>
                    </div>
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
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">MS</span>
                                        <div>
                                            <p class="font-semibold text-slate-800">Maria Santos</p>
                                            <p class="text-xs text-slate-500">maria.santos@nu.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">College of Computing</td>
                                <td class="px-4 py-4 text-slate-700">Associate Professor</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></td>
                                <td class="px-4 py-4"><span class="rounded border border-emerald-200 bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Updated</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="employee-details-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                            <a href="#" data-open-modal="employee-edit-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                            <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                            <a href="#" class="block rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                        </div>
                                    </details>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">JD</span>
                                        <div>
                                            <p class="font-semibold text-slate-800">Juan Dela Cruz</p>
                                            <p class="text-xs text-slate-500">juan.delacruz@nu.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">College of Engineering</td>
                                <td class="px-4 py-4 text-slate-700">Professor</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></td>
                                <td class="px-4 py-4"><span class="rounded border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Needs Update</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="employee-details-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                            <a href="#" data-open-modal="employee-edit-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                            <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                            <a href="#" class="block rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                        </div>
                                    </details>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">AR</span>
                                        <div>
                                            <p class="font-semibold text-slate-800">Ana Reyes</p>
                                            <p class="text-xs text-slate-500">ana.reyes@nu.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">College of Business</td>
                                <td class="px-4 py-4 text-slate-700">Instructor</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></td>
                                <td class="px-4 py-4"><span class="rounded border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Needs Update</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="employee-details-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                            <a href="#" data-open-modal="employee-edit-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                            <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                            <a href="#" class="block rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                        </div>
                                    </details>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">CG</span>
                                        <div>
                                            <p class="font-semibold text-slate-800">Carlos Garcia</p>
                                            <p class="text-xs text-slate-500">carlos.garcia@nu.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">College of Education</td>
                                <td class="px-4 py-4 text-slate-700">Assistant Professor</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></td>
                                <td class="px-4 py-4"><span class="rounded border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Needs Update</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="employee-details-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                            <a href="#" data-open-modal="employee-edit-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                            <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                            <a href="#" class="block rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                        </div>
                                    </details>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#00386f] text-xs font-semibold text-white">LM</span>
                                        <div>
                                            <p class="font-semibold text-slate-800">Lisa Mendoza</p>
                                            <p class="text-xs text-slate-500">lisa.mendoza@nu.edu.ph</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">Human Resources</td>
                                <td class="px-4 py-4 text-slate-700">HR Specialist</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Active</span></td>
                                <td class="px-4 py-4"><span class="rounded border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Needs Update</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-44 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="employee-details-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Details</a>
                                            <a href="#" data-open-modal="employee-edit-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                            <a href="{{ route('employees.profile') }}" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">View Profile</a>
                                            <a href="#" class="block rounded-lg border border-red-300 px-3 py-2 text-center font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                        </div>
                                    </details>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </article>

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

            <form class="grid grid-cols-1 gap-4 px-8 pb-8 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employee ID</label>
                    <input type="text" placeholder="EMP-001" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Email *</label>
                    <input type="email" placeholder="email@nu.edu.ph" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">First Name *</label>
                    <input type="text" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Last Name *</label>
                    <input type="text" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Phone</label>
                    <input type="text" placeholder="+63 XXX XXX XXXX" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Department *</label>
                    <select class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-500">
                        <option>Select Department</option>
                        <option>College of Engineering</option>
                        <option>College of Business</option>
                        <option>College of Education</option>
                        <option>College of Arts &amp; Sciences</option>
                        <option>College of Computing</option>
                        <option>College of Allied Health</option>
                        <option>Administration</option>
                        <option>Human Resources</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Position *</label>
                    <input type="text" placeholder="e.g. Associate Professor" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employment Type</label>
                    <select class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg text-slate-500">
                        <option>Select type</option>
                        <option>Full-time Faculty</option>
                        <option>Part-time Faculty</option>
                        <option>Administrative Staff</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Ranking</label>
                    <select class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                        <option>N/A</option>
                        <option>Instructor I</option>
                        <option>Instructor II</option>
                        <option>Associate Professor I</option>
                        <option>Associate Professor II</option>
                        <option>Professor</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Status</label>
                    <select class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                        <option>Active</option>
                        <option>On Leave</option>
                        <option>Resigned</option>
                        <option>Terminated</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Hire Date</label>
                    <input type="text" placeholder="mm/dd/yyyy" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time In</label>
                    <input type="text" value="8:30 AM" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time Out</label>
                    <input type="text" value="5:30 PM" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Resume Last Updated</label>
                    <input type="text" placeholder="mm/dd/yyyy" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
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
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#00386f] text-2xl text-white">MS</span>
                    <div>
                        <p class="text-4xl font-bold text-[#1f2b8b]">Maria Santos</p>
                        <p class="text-2xl text-slate-600">Associate Professor</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 px-6 py-6 text-slate-800 md:grid-cols-2">
                <div>
                    <p class="text-base text-slate-500">Employee ID</p>
                    <p class="text-2xl">NU-2021-001</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Department</p>
                    <p class="text-2xl">College of Computing</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Email</p>
                    <p class="text-2xl">maria.santos@nu.edu.ph</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Phone</p>
                    <p class="text-2xl">+63 917 123 4567</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Employment Type</p>
                    <p class="text-2xl">Full-time Faculty</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Ranking</p>
                    <p class="text-2xl">Associate Professor II</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Hire Date</p>
                    <p class="text-2xl">Jun 15, 2021</p>
                </div>
                <div>
                    <p class="text-base text-slate-500">Official Time</p>
                    <p class="text-2xl">08:30 - 17:30</p>
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

            <form class="grid grid-cols-1 gap-4 px-8 pb-8 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employee ID</label>
                    <input type="text" value="NU-2021-001" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Email *</label>
                    <input type="email" value="maria.santos@nu.edu.ph" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">First Name *</label>
                    <input type="text" value="Maria" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Last Name *</label>
                    <input type="text" value="Santos" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Phone</label>
                    <input type="text" value="+63 917 123 4567" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Department *</label>
                    <input type="text" value="College of Computing" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Position *</label>
                    <input type="text" value="Associate Professor" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Employment Type</label>
                    <input type="text" value="Full-time Faculty" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Ranking</label>
                    <input type="text" value="Associate Professor II" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Status</label>
                    <input type="text" value="Active" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Hire Date</label>
                    <input type="text" value="06/15/2021" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time In</label>
                    <input type="text" value="8:30 AM" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Official Time Out</label>
                    <input type="text" value="5:30 PM" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#1f2b8b]">Resume Last Updated</label>
                    <input type="text" value="02/01/2026" class="w-full rounded-md border border-slate-300 px-4 py-2 text-lg">
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
