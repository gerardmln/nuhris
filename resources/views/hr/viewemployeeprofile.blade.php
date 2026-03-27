<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Profile | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li><a href="{{ route('employees.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm"><span class="h-2 w-2 rounded-full bg-slate-900"></span>Employees</a></li>
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

            <section class="space-y-4 px-5 py-5 sm:px-6 sm:py-6">
                <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-[#1f2b5d] hover:text-[#162048]">
                    <span class="text-base">&larr;</span>
                    Employee Profile
                </a>

                <article class="rounded-xl border border-slate-300 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex items-start gap-5">
                            <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-[#00386f] text-3xl text-white">MS</span>
                            <div>
                                <h2 class="text-4xl font-bold text-[#1f2b5d]">Maria Santos</h2>
                                <p class="text-2xl text-slate-600">Associate Professor</p>
                                <span class="mt-2 inline-block rounded bg-yellow-300 px-2 py-1 text-xs font-semibold text-slate-900">Associate Professor II</span>
                            </div>
                        </div>
                        <span class="rounded-md bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Active</span>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-2 text-sm text-slate-600 md:grid-cols-3">
                        <p>maria.santos@nu.edu.ph</p>
                        <p>+63 917 123 4567</p>
                        <p>College of Computing</p>
                        <p>Hired: Jun 15, 2021</p>
                        <p>08:30 - 17:30</p>
                        <p>ID: NU-2021-001</p>
                    </div>
                </article>

                <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between rounded-lg border-l-4 border-amber-500 bg-white px-4 py-3">
                        <div>
                            <p class="text-lg font-semibold text-slate-800">Resume Status</p>
                            <p class="text-sm text-slate-500">Last updated: January 15, 2024</p>
                        </div>
                        <button class="rounded-md bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">Mark as Updated</button>
                    </div>
                </article>

                <div class="inline-flex overflow-hidden rounded-lg border border-slate-300 bg-white text-sm font-semibold" role="tablist" aria-label="Employee profile sections">
                    <button id="tab-prc" data-target="panel-prc" class="tab-btn border-r border-slate-300 bg-slate-100 px-4 py-2 text-slate-900" role="tab" aria-selected="true">PRC Licenses (0)</button>
                    <button id="tab-trainings" data-target="panel-trainings" class="tab-btn border-r border-slate-300 px-4 py-2 text-slate-700" role="tab" aria-selected="false">Trainings (0)</button>
                    <button id="tab-attendance" data-target="panel-attendance" class="tab-btn px-4 py-2 text-slate-700" role="tab" aria-selected="false">Recent Attendance</button>
                </div>

                <article id="panel-prc" class="tab-panel rounded-xl border border-slate-300 bg-white p-5 shadow-sm" role="tabpanel" aria-labelledby="tab-prc">
                    <h3 class="text-3xl font-bold text-slate-800">PRC Licenses</h3>
                    <div class="mt-4 rounded-lg border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-lg font-semibold text-slate-800">Professional Teacher License</p>
                                <p class="text-sm text-slate-500">License #: 0234567</p>
                                <p class="text-sm text-slate-500">Expires: Oct 23, 2029</p>
                            </div>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Pending</span>
                        </div>
                    </div>
                </article>

                <article id="panel-trainings" class="tab-panel hidden rounded-xl border border-slate-300 bg-white p-5 shadow-sm" role="tabpanel" aria-labelledby="tab-trainings">
                    <h3 class="text-3xl font-bold text-slate-800">Trainings &amp; Development</h3>
                    <div class="mt-10 text-center text-2xl text-slate-500">No trainings recorded</div>
                </article>

                <article id="panel-attendance" class="tab-panel hidden rounded-xl border border-slate-300 bg-white p-5 shadow-sm" role="tabpanel" aria-labelledby="tab-attendance">
                    <h3 class="text-3xl font-bold text-slate-800">Recent Attendance (Last 30 Days)</h3>
                    <div class="mt-10 text-center text-2xl text-slate-500">No attendance recorded</div>
                </article>
            </section>
        </main>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach((button) => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-target');

                document.querySelectorAll('.tab-panel').forEach((panel) => {
                    panel.classList.add('hidden');
                });

                document.querySelectorAll('.tab-btn').forEach((tab) => {
                    tab.classList.remove('bg-slate-100', 'text-slate-900');
                    tab.classList.add('text-slate-700');
                    tab.setAttribute('aria-selected', 'false');
                });

                document.getElementById(target).classList.remove('hidden');
                button.classList.add('bg-slate-100', 'text-slate-900');
                button.classList.remove('text-slate-700');
                button.setAttribute('aria-selected', 'true');
            });
        });
    </script>
</body>
</html>
