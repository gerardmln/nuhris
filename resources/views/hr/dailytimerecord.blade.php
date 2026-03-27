<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daily Time Record | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li>
                        <a href="{{ route('timekeeping.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            Time Keeping
                        </a>
                    </li>
                    <li><a href="{{ route('leave.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Leave Management</a></li>
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
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Daily Time Record</h1>
                        <p class="text-sm text-slate-500">View biometric attendance records</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                <a href="{{ route('timekeeping.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
                    <span>&larr;</span>
                    Back to List
                </a>

                <article class="rounded-xl border border-slate-300 bg-[#cfe1f5] p-4 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-[#1f2b5d]">Maria Santos</h2>
                            <p class="text-sm text-slate-600">College of Computing</p>
                            <p class="text-sm text-slate-500">Period: February 2026</p>
                        </div>
                        <button class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Export</button>
                    </div>
                </article>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Present Days</p>
                        <p class="text-4xl font-extrabold text-emerald-700">0</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Absent Days</p>
                        <p class="text-4xl font-extrabold text-red-600">0</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Total Tardiness</p>
                        <p class="text-4xl font-extrabold text-amber-600">0 min</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs text-slate-500">Total Undertime</p>
                        <p class="text-4xl font-extrabold text-violet-600">0 min</p>
                    </article>
                </div>

                <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                    <div class="mb-3">
                        <h3 class="text-2xl font-bold text-[#1f2b5d]">February 2026</h3>
                        <p class="text-xs text-slate-500">Official Time: 08:30 - 17:30</p>
                    </div>

                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-300 text-xs uppercase tracking-wide text-slate-600">
                            <tr>
                                <th class="px-3 py-2">Date</th>
                                <th class="px-3 py-2">Day</th>
                                <th class="px-3 py-2">Time In</th>
                                <th class="px-3 py-2">Time Out</th>
                                <th class="px-3 py-2">Tardiness</th>
                                <th class="px-3 py-2">Undertime</th>
                                <th class="px-3 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr><td class="px-3 py-2">Feb 1</td><td class="px-3 py-2">Sun</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 2</td><td class="px-3 py-2">Mon</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 3</td><td class="px-3 py-2">Tue</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 4</td><td class="px-3 py-2">Wed</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 5</td><td class="px-3 py-2">Thu</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 6</td><td class="px-3 py-2">Fri</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 7</td><td class="px-3 py-2">Sat</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 8</td><td class="px-3 py-2">Sun</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 9</td><td class="px-3 py-2">Mon</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 10</td><td class="px-3 py-2">Tue</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 11</td><td class="px-3 py-2">Wed</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 12</td><td class="px-3 py-2">Thu</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 13</td><td class="px-3 py-2">Fri</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"></td></tr>
                            <tr><td class="px-3 py-2">Feb 14</td><td class="px-3 py-2">Sat</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 21</td><td class="px-3 py-2">Sat</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 22</td><td class="px-3 py-2">Sun</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                            <tr><td class="px-3 py-2">Feb 28</td><td class="px-3 py-2">Sat</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2">-</td><td class="px-3 py-2"><span class="rounded border border-slate-300 px-2 py-0.5 text-xs">Weekend</span></td></tr>
                        </tbody>
                    </table>
                </article>

                <div class="h-8"></div>
            </section>
        </main>
    </div>
</body>
</html>
