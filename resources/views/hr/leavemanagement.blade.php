<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave Management | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li><a href="{{ route('dashboard') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Dashboard</a></li>
                    <li><a href="{{ route('employees.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Employees</a></li>
                    <li><a href="{{ route('credentials.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Credentials</a></li>
                    <li><a href="{{ route('timekeeping.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Time Keeping</a></li>
                    <li>
                        <a href="{{ route('leave.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            Leave Management
                        </a>
                    </li>
                    <li><a href="{{ route('announcements.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Announcements</a></li>
                </ul>
            </nav>

            <div class="mt-8 border-t border-white/20 px-5 py-5 lg:mt-auto">
                <div class="mb-4">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Martinez, Ian Isaac' }}</p>
                    <p class="text-xs text-blue-100">{{ auth()->user()->email ?? 'user' }}</p>
                </div>
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Leave</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1f2b5d]">Leave Management</h2>
                        <p class="text-sm text-slate-500">View and manage employee leave balances</p>
                    </div>
                    <button data-open-modal="upload-biometrics-modal" class="rounded-lg bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">Upload Biometrics</button>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Total Employees</p>
                        <p class="mt-1 text-4xl font-extrabold">5</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Vacation Used</p>
                        <p class="mt-1 text-4xl font-extrabold">18</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Sick Leave Used</p>
                        <p class="mt-1 text-4xl font-extrabold">8</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Current Year</p>
                        <p class="mt-1 text-4xl font-extrabold">2026</p>
                    </article>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white p-3 shadow-sm">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <input type="text" placeholder="Search Employees" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
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
                                <option>January 2026</option>
                                <option>February 2026</option>
                                <option>March 2026</option>
                            </select>
                        </div>
                    </div>
                </article>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <article data-faculty-card data-name="Maria Santos" data-remaining="32" data-used="6" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">MS</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Maria Santos</p>
                                <p class="text-sm text-slate-500">College of Computing</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-4/5 rounded bg-emerald-700"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-3/4 rounded bg-amber-500"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-full rounded bg-violet-600"></div></div></div>
                        </div>
                        <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+5 unused from previous year</p>
                    </article>

                    <article data-faculty-card data-name="Juan Dela Cruz" data-remaining="28" data-used="10" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">JD</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Juan Dela Cruz</p>
                                <p class="text-sm text-slate-500">College of Engineering</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-2/3 rounded bg-emerald-700"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-11/12 rounded bg-amber-500"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-2/3 rounded bg-violet-600"></div></div></div>
                        </div>
                        <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+3 unused from previous year</p>
                    </article>

                    <article data-faculty-card data-name="Ana Reyes" data-remaining="30" data-used="8" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">AR</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Ana Reyes</p>
                                <p class="text-sm text-slate-500">College of Business</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-3/4 rounded bg-emerald-700"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-2/3 rounded bg-amber-500"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-full rounded bg-violet-600"></div></div></div>
                        </div>
                        <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+5 unused from previous year</p>
                    </article>

                    <article data-faculty-card data-name="Carlos Garcia" data-remaining="24" data-used="12" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">CG</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Carlos Garcia</p>
                                <p class="text-sm text-slate-500">College of Education</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-1/2 rounded bg-emerald-700"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-full rounded bg-amber-500"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-1/3 rounded bg-violet-600"></div></div></div>
                        </div>
                        <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+3 unused from previous year</p>
                    </article>

                    <article data-faculty-card data-name="Lisa Mendoza" data-remaining="34" data-used="5" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md md:col-span-2 lg:col-span-1">
                        <div class="mb-3 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">LM</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Lisa Mendoza</p>
                                <p class="text-sm text-slate-500">Human Resources</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-11/12 rounded bg-emerald-700"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-11/12 rounded bg-amber-500"></div></div></div>
                            <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-full rounded bg-violet-600"></div></div></div>
                        </div>
                        <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+5 unused from previous year</p>
                    </article>
                </div>

                <div class="h-8"></div>
            </section>
        </main>
    </div>

    <div id="upload-biometrics-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-4xl font-bold text-[#1f2b8b]">Upload Biometrics PDF</h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-7 pb-7">
                <label class="mb-3 block text-2xl font-medium text-slate-700">Biometric File (PDF)</label>

                <div class="rounded-lg border border-dashed border-slate-400 p-8 text-center">
                    <div class="mx-auto inline-flex h-14 w-14 items-center justify-center text-slate-400">
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 16V4" />
                            <path d="m7 9 5-5 5 5" />
                            <path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3" />
                        </svg>
                    </div>
                    <p class="mt-3 text-lg text-slate-500">Click to upload or drag and drop</p>
                    <p class="text-sm text-slate-400">PDF, CSV, or XLSX</p>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" data-close-modal class="rounded-md border border-slate-400 px-8 py-2.5 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="button" data-close-modal class="inline-flex items-center justify-center gap-2 rounded-md bg-[#00386f] px-8 py-2.5 text-lg font-semibold text-white hover:bg-[#002f5d]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        Process File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="leave-details-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-4xl font-bold text-[#1f2b8b]">Leave Details - <span id="leave-details-name">Maria Santos</span></h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-7 pb-7">
                <div class="rounded-xl bg-slate-200 p-1">
                    <div class="grid grid-cols-2 gap-2 text-center text-2xl font-semibold text-[#1f2b8b]">
                        <button type="button" data-leave-tab="balance" class="rounded-lg bg-white px-4 py-2 text-[#1f2b8b]">Leave Balance</button>
                        <button type="button" data-leave-tab="history" class="rounded-lg px-4 py-2 text-slate-600">Leave History</button>
                    </div>
                </div>

                <section id="leave-balance-content" class="mt-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-remaining-days" class="text-6xl font-extrabold text-emerald-700">32</p>
                            <p class="text-3xl text-slate-700">Remaining Days</p>
                        </article>
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-used-days" class="text-6xl font-extrabold text-amber-600">6</p>
                            <p class="text-3xl text-slate-700">Days Used</p>
                        </article>
                    </div>

                    <article class="mt-5 rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                        <h4 class="text-3xl font-bold text-slate-800">Leave Balance Breakdown (2026)</h4>

                        <div class="mt-5 space-y-4">
                            <div>
                                <p class="text-2xl text-slate-800">Service Incentive Leave</p>
                                <div class="mt-1 h-2 rounded bg-slate-200"><div class="h-2 w-4/5 rounded bg-blue-600"></div></div>
                                <div class="mt-1 flex justify-between text-sm text-slate-500"><span>Used: 3 days</span><span>Remaining: 12 days</span></div>
                            </div>

                            <div>
                                <p class="text-2xl text-slate-800">Sick Leave</p>
                                <div class="mt-1 h-2 rounded bg-slate-200"><div class="h-2 w-5/6 rounded bg-amber-500"></div></div>
                                <div class="mt-1 flex justify-between text-sm text-slate-500"><span>Used: 2 days</span><span>Remaining: 13 days</span></div>
                            </div>

                            <div>
                                <p class="text-2xl text-slate-800">Emergency Leave</p>
                                <div class="mt-1 h-2 rounded bg-slate-200"><div class="h-2 w-full rounded bg-violet-600"></div></div>
                                <div class="mt-1 flex justify-between text-sm text-slate-500"><span>Used: 0 days</span><span>Remaining: 3 days</span></div>
                            </div>

                            <div>
                                <p class="text-2xl text-slate-800">Vacation Leave</p>
                                <div class="mt-1 h-2 rounded bg-slate-200"><div class="h-2 w-4/5 rounded bg-emerald-700"></div></div>
                                <div class="mt-1 flex justify-between text-sm text-slate-500"><span>Used: 1 day</span><span>Remaining: 4 days</span></div>
                            </div>
                        </div>
                    </article>

                    <article class="mt-5 rounded-xl border border-blue-300 bg-blue-100 px-6 py-5 shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-3xl font-semibold text-[#1f2b8b]">Unused Leave (Previous Year)</p>
                                <p class="text-2xl text-[#1f2b8b]">Carried over from 2025</p>
                            </div>
                            <span class="rounded-lg bg-blue-200 px-4 py-2 text-3xl font-bold text-[#1f2b8b]">+5 days</span>
                        </div>
                    </article>
                </section>

                <section id="leave-history-content" class="mt-5 hidden">
                    <article class="rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">Approved Requests</p>
                                <p class="text-3xl font-bold text-emerald-700">14</p>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">Pending Requests</p>
                                <p class="text-3xl font-bold text-amber-600">2</p>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">Rejected Requests</p>
                                <p class="text-3xl font-bold text-rose-600">1</p>
                            </div>
                        </div>

                        <div class="mt-5 overflow-x-auto rounded-xl border border-slate-200">
                            <table class="min-w-full text-left">
                                <thead class="bg-slate-100 text-sm uppercase tracking-wide text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3">Date Filed</th>
                                        <th class="px-4 py-3">Leave Type</th>
                                        <th class="px-4 py-3">Duration</th>
                                        <th class="px-4 py-3">Reason</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                                    <tr>
                                        <td class="px-4 py-3">Mar 10, 2026</td>
                                        <td class="px-4 py-3">Sick Leave</td>
                                        <td class="px-4 py-3">2 days</td>
                                        <td class="px-4 py-3">Flu recovery</td>
                                        <td class="px-4 py-3"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Feb 22, 2026</td>
                                        <td class="px-4 py-3">Vacation Leave</td>
                                        <td class="px-4 py-3">3 days</td>
                                        <td class="px-4 py-3">Family trip</td>
                                        <td class="px-4 py-3"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Jan 18, 2026</td>
                                        <td class="px-4 py-3">Emergency Leave</td>
                                        <td class="px-4 py-3">1 day</td>
                                        <td class="px-4 py-3">Urgent personal matter</td>
                                        <td class="px-4 py-3"><span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Dec 05, 2025</td>
                                        <td class="px-4 py-3">Service Incentive Leave</td>
                                        <td class="px-4 py-3">1 day</td>
                                        <td class="px-4 py-3">Government appointment</td>
                                        <td class="px-4 py-3"><span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">Rejected</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </article>
                </section>
            </div>
        </div>
    </div>

    <script>
        const openButtons = document.querySelectorAll('[data-open-modal]');
        const closeButtons = document.querySelectorAll('[data-close-modal]');
        const modals = document.querySelectorAll('#upload-biometrics-modal, #leave-details-modal');

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const hasVisibleModal = Array.from(modals).some((item) => !item.classList.contains('hidden'));
            if (!hasVisibleModal) {
                document.body.classList.remove('overflow-hidden');
            }
        }

        openButtons.forEach((button) => {
            button.addEventListener('click', () => {
                openModal(button.dataset.openModal);
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const modal = button.closest('.fixed.inset-0');
                if (modal) closeModal(modal);
            });
        });

        modals.forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal(modal);
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;
            modals.forEach((modal) => {
                if (!modal.classList.contains('hidden')) {
                    closeModal(modal);
                }
            });
        });

        const facultyCards = document.querySelectorAll('[data-faculty-card]');
        const leaveName = document.getElementById('leave-details-name');
        const remainingDays = document.getElementById('leave-remaining-days');
        const usedDays = document.getElementById('leave-used-days');
        const leaveTabButtons = document.querySelectorAll('[data-leave-tab]');
        const leaveBalanceContent = document.getElementById('leave-balance-content');
        const leaveHistoryContent = document.getElementById('leave-history-content');

        function setLeaveTab(tab) {
            const isBalance = tab === 'balance';
            leaveBalanceContent.classList.toggle('hidden', !isBalance);
            leaveHistoryContent.classList.toggle('hidden', isBalance);

            leaveTabButtons.forEach((button) => {
                const isActive = button.dataset.leaveTab === tab;
                button.classList.toggle('bg-white', isActive);
                button.classList.toggle('text-[#1f2b8b]', isActive);
                button.classList.toggle('text-slate-600', !isActive);
            });
        }

        leaveTabButtons.forEach((button) => {
            button.addEventListener('click', () => {
                setLeaveTab(button.dataset.leaveTab);
            });
        });

        facultyCards.forEach((card) => {
            card.addEventListener('click', () => {
                leaveName.textContent = card.dataset.name || 'Faculty';
                remainingDays.textContent = card.dataset.remaining || '0';
                usedDays.textContent = card.dataset.used || '0';
                setLeaveTab('balance');
                openModal('leave-details-modal');
            });
        });
    </script>
</body>
</html>
