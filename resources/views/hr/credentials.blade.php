<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Credentials | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li>
                        <a href="{{ route('credentials.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            Credentials
                        </a>
                    </li>
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
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Credentials</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                <div>
                    <h2 class="text-3xl font-bold text-[#1f2b5d]">Credential Verification</h2>
                    <p class="text-sm text-slate-500">Manage and verify faculty credentials</p>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Total Credentials</p>
                        <p class="mt-1 text-4xl font-extrabold">4</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Pending Review</p>
                        <p class="mt-1 text-4xl font-extrabold">4</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Verified</p>
                        <p class="mt-1 text-4xl font-extrabold">0</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Expiring Soon</p>
                        <p class="mt-1 text-4xl font-extrabold">0</p>
                    </article>
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
                                <option>Pending</option>
                                <option>Verified</option>
                                <option>Rejected</option>
                                <option>Expired</option>
                            </select>
                        </div>
                    </div>
                </article>

                <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white shadow-sm">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-300 bg-slate-50 text-xs uppercase tracking-wide text-slate-600">
                            <tr>
                                <th class="px-5 py-3">Employee</th>
                                <th class="px-4 py-3">Credential</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Expiry Date</th>
                                <th class="px-4 py-3">Status</th>
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
                                <td class="px-4 py-4 text-slate-700">Professional Teacher License</td>
                                <td class="px-4 py-4 text-slate-700">PRC License</td>
                                <td class="px-4 py-4 text-slate-700">March 15, 2024</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="review-credential-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Review Credential</a>
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
                                <td class="px-4 py-4 text-slate-700">Licensed Civil Engineer</td>
                                <td class="px-4 py-4 text-slate-700">PRC License</td>
                                <td class="px-4 py-4 text-slate-700">June 20, 2026</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="review-credential-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Review Credential</a>
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
                                <td class="px-4 py-4 text-slate-700">Advanced Teaching Methods</td>
                                <td class="px-4 py-4 text-slate-700">Training Certificate</td>
                                <td class="px-4 py-4 text-slate-700">May 12, 2027</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="review-credential-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Review Credential</a>
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
                                <td class="px-4 py-4 text-slate-700">Doctor of Education</td>
                                <td class="px-4 py-4 text-slate-700">Degree</td>
                                <td class="px-4 py-4 text-slate-700">No Expiry</td>
                                <td class="px-4 py-4"><span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">Pending</span></td>
                                <td class="px-4 py-4 text-slate-600">
                                    <details class="relative inline-block">
                                        <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none hover:bg-slate-100">...</summary>
                                        <div class="absolute right-0 z-20 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                                            <a href="#" data-open-modal="review-credential-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-2 text-center font-semibold text-slate-800 hover:bg-slate-50">Review Credential</a>
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

    <div id="review-credential-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-3xl font-bold text-[#1f2b5d]">Review Credential</h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-7 pb-7">
                <article class="rounded-lg bg-[#d9e8f8] p-6">
                    <h4 class="text-4xl font-bold text-[#1f2b8b]">Licensed Civil Engineer</h4>
                    <p class="text-2xl text-slate-700">Juan Dela Cruz</p>

                    <div class="mt-5 grid grid-cols-1 gap-4 text-slate-800 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-slate-600">License Number</p>
                            <p class="text-3xl">0234567</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Issue Date</p>
                            <p class="text-3xl">Jun 20, 2019</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Expiry Date</p>
                            <p class="text-3xl">Jun 20, 2026</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600">Current Status</p>
                            <p class="text-3xl">Pending</p>
                        </div>
                    </div>
                </article>

                <div class="mt-4 rounded-lg border border-slate-400 p-6 text-center text-slate-400">
                    <div class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-lg border border-slate-500 bg-white/70">
                        <svg class="h-8 w-8 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 16V4" />
                            <path d="m7 9 5-5 5 5" />
                            <path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3" />
                        </svg>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="mb-2 block text-2xl font-semibold text-slate-800">Verification Notes</label>
                    <textarea rows="4" placeholder="Add notes about the verification..." class="w-full rounded-md border border-slate-400 px-4 py-3 text-lg focus:border-blue-400 focus:outline-none"></textarea>
                </div>

                <div class="mt-5 flex justify-end gap-3">
                    <button type="button" class="rounded-md border border-slate-400 px-8 py-2 text-lg font-semibold text-slate-700 hover:bg-slate-50">Reject</button>
                    <button type="button" data-close-modal class="rounded-md bg-[#00386f] px-8 py-2 text-lg font-semibold text-white hover:bg-[#002f5d]">Approve</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const openers = document.querySelectorAll('[data-open-modal]');
        const closers = document.querySelectorAll('[data-close-modal]');
        const modal = document.getElementById('review-credential-modal');

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        openers.forEach((trigger) => {
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            });
        });

        closers.forEach((trigger) => {
            trigger.addEventListener('click', closeModal);
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
