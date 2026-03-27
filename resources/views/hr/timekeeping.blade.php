<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Time Keeping | {{ config('app.name', 'NU HRIS') }}</title>
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
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">TimeKeeping</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1f2b5d]">Time Keeping</h2>
                        <p class="text-sm text-slate-500">View biometric attendance records and generate DTR</p>
                    </div>
                    <button data-open-modal="upload-biometrics-modal" class="rounded-lg bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">Upload Biometrics</button>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white p-3 shadow-sm">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <input
                                type="text"
                                placeholder="Search Employees"
                                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none"
                            >
                        </div>
                        <div>
                            <select class="w-full rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                <option>January 2026</option>
                                <option>February 2026</option>
                                <option>March 2026</option>
                            </select>
                        </div>
                    </div>
                </article>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">MS</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Maria Santos</p>
                                <p class="text-sm text-slate-500">College of Computing</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-emerald-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-emerald-700">0</p>
                                <p class="text-xs font-semibold text-emerald-700">Present</p>
                            </div>
                            <div class="rounded-lg bg-amber-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-amber-700">0</p>
                                <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Official: 08:30 - 17:30</p>
                        <a href="{{ route('timekeeping.dtr') }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">JD</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Juan Dela Cruz</p>
                                <p class="text-sm text-slate-500">College of Engineering</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-emerald-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-emerald-700">0</p>
                                <p class="text-xs font-semibold text-emerald-700">Present</p>
                            </div>
                            <div class="rounded-lg bg-amber-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-amber-700">0</p>
                                <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Official: 07:30 - 16:30</p>
                        <a href="{{ route('timekeeping.dtr') }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">AR</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Ana Reyes</p>
                                <p class="text-sm text-slate-500">College of Business</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-emerald-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-emerald-700">0</p>
                                <p class="text-xs font-semibold text-emerald-700">Present</p>
                            </div>
                            <div class="rounded-lg bg-amber-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-amber-700">0</p>
                                <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Official: 08:00 - 17:00</p>
                        <a href="{{ route('timekeeping.dtr') }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">CG</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Carlos Garcia</p>
                                <p class="text-sm text-slate-500">College of Education</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-emerald-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-emerald-700">0</p>
                                <p class="text-xs font-semibold text-emerald-700">Present</p>
                            </div>
                            <div class="rounded-lg bg-amber-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-amber-700">0</p>
                                <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Official: 08:30 - 17:30</p>
                        <a href="{{ route('timekeeping.dtr') }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">LM</span>
                            <div>
                                <p class="text-xl font-bold text-[#1f2b5d]">Lisa Mendoza</p>
                                <p class="text-sm text-slate-500">Human Resources</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-emerald-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-emerald-700">0</p>
                                <p class="text-xs font-semibold text-emerald-700">Present</p>
                            </div>
                            <div class="rounded-lg bg-amber-100 p-3 text-center">
                                <p class="text-4xl font-extrabold text-amber-700">0</p>
                                <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Official: 08:00 - 17:00</p>
                        <a href="{{ route('timekeeping.dtr') }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
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

    <script>
        const modalOpenButtons = document.querySelectorAll('[data-open-modal]');
        const modalCloseButtons = document.querySelectorAll('[data-close-modal]');
        const uploadBiometricsModal = document.getElementById('upload-biometrics-modal');

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(modal) {
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        modalOpenButtons.forEach((button) => {
            button.addEventListener('click', () => {
                openModal(button.dataset.openModal);
            });
        });

        modalCloseButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const modal = button.closest('.fixed.inset-0');
                closeModal(modal);
            });
        });

        if (uploadBiometricsModal) {
            uploadBiometricsModal.addEventListener('click', (event) => {
                if (event.target === uploadBiometricsModal) {
                    closeModal(uploadBiometricsModal);
                }
            });
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal(uploadBiometricsModal);
            }
        });
    </script>
</body>
</html>
