<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Announcements | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li><a href="{{ route('leave.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Leave Management</a></li>
                    <li>
                        <a href="{{ route('announcements.index') }}" class="flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            Announcements
                        </a>
                    </li>
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
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Announcements</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1f2b5d]">Announcements</h2>
                        <p class="text-sm text-slate-500">Manage HR announcements and notifications</p>
                    </div>
                    <button data-open-modal="new-announcement-modal" class="rounded-lg bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">+ New Announcement</button>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Total</p>
                        <p class="mt-1 text-4xl font-extrabold">3</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Active</p>
                        <p class="mt-1 text-4xl font-extrabold">3</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Urgent</p>
                        <p class="mt-1 text-4xl font-extrabold">1</p>
                    </article>
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <p class="text-xs font-medium text-slate-500">Current Month</p>
                        <p class="mt-1 text-4xl font-extrabold">3</p>
                    </article>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white p-3 shadow-sm">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <input type="text" placeholder="Search announcements..." class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
                        </div>
                        <div>
                            <select class="w-full rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                                <option>All Types</option>
                                <option>General</option>
                                <option>Urgent</option>
                                <option>Reminder</option>
                                <option>Event</option>
                                <option>Policy Update</option>
                            </select>
                        </div>
                    </div>
                </article>

                <div class="flex flex-wrap gap-2">
                    <span class="rounded-md bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">Announcements</span>
                    <span class="rounded-md bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Sent Notifications</span>
                </div>

                <div class="space-y-4">
                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-2 flex items-start justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-1">
                                <span class="rounded border border-red-200 bg-red-50 px-2 py-0.5 text-[10px] font-semibold text-red-700">Urgent</span>
                                <span class="rounded border border-red-200 bg-red-50 px-2 py-0.5 text-[10px] font-semibold text-red-700">High</span>
                                <span class="rounded border border-red-200 bg-red-50 px-2 py-0.5 text-[10px] font-semibold text-red-700">Faculty Only</span>
                            </div>
                            <details class="relative">
                                <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none text-slate-500 hover:bg-slate-100">...</summary>
                                <div class="absolute right-0 z-20 mt-2 w-32 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                                    <a href="#" data-open-modal="edit-announcement-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                    <a href="#" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Hide</a>
                                    <a href="#" class="block rounded-lg border border-red-300 px-3 py-1.5 text-center text-xs font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                </div>
                            </details>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">CHED Compliance Deadline Reminder</h3>
                        <p class="mt-2 text-sm text-slate-600">This is a reminder that all faculty members must submit their updated curriculum vitae and credentials for the upcoming CHED compliance review. Please ensure your resume is updated in the system by January 31, 2025.</p>
                        <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-500">
                            <span>Jan 10, 2025</span>
                            <span>Expires: Jan 31, 2025</span>
                        </div>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-2 flex items-start justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-1">
                                <span class="rounded border border-indigo-200 bg-indigo-50 px-2 py-0.5 text-[10px] font-semibold text-indigo-700">Event</span>
                                <span class="rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-700">Normal</span>
                                <span class="rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-700">Faculty Only</span>
                            </div>
                            <details class="relative">
                                <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none text-slate-500 hover:bg-slate-100">...</summary>
                                <div class="absolute right-0 z-20 mt-2 w-32 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                                    <a href="#" data-open-modal="edit-announcement-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                    <a href="#" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Hide</a>
                                    <a href="#" class="block rounded-lg border border-red-300 px-3 py-1.5 text-center text-xs font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                </div>
                            </details>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Faculty Development Program Registration</h3>
                        <p class="mt-2 text-sm text-slate-600">Registration is now open for the Faculty Development Program scheduled for February 2025. Topics include research methodology, teaching innovations, and academic writing. Register through HR.</p>
                        <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-500">
                            <span>Jan 8, 2025</span>
                            <span>Expires: Feb 1, 2025</span>
                        </div>
                    </article>

                    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                        <div class="mb-2 flex items-start justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-1">
                                <span class="rounded border border-violet-200 bg-violet-50 px-2 py-0.5 text-[10px] font-semibold text-violet-700">Policy Update</span>
                                <span class="rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-700">Normal</span>
                                <span class="rounded border border-slate-200 bg-slate-50 px-2 py-0.5 text-[10px] font-semibold text-slate-700">Everyone</span>
                            </div>
                            <details class="relative">
                                <summary class="cursor-pointer list-none rounded-md px-2 py-1 text-lg leading-none text-slate-500 hover:bg-slate-100">...</summary>
                                <div class="absolute right-0 z-20 mt-2 w-32 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                                    <a href="#" data-open-modal="edit-announcement-modal" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Edit</a>
                                    <a href="#" class="mb-1 block rounded-lg border border-slate-300 px-3 py-1.5 text-center text-xs font-semibold text-slate-800 hover:bg-slate-50">Hide</a>
                                    <a href="#" class="block rounded-lg border border-red-300 px-3 py-1.5 text-center text-xs font-semibold text-red-600 hover:bg-red-50">Delete</a>
                                </div>
                            </details>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Updated Leave Policy</h3>
                        <p class="mt-2 text-sm text-slate-600">Please be informed of the updated leave policy effective January 1, 2025. Key changes include revised sick leave documentation requirements and new parental leave benefits. Full policy document available at HR.</p>
                        <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-500">
                            <span>Jan 5, 2025</span>
                        </div>
                    </article>
                </div>

                <div class="h-8"></div>
            </section>
        </main>
    </div>

    <div id="new-announcement-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-8 py-6">
                <div>
                    <h3 class="text-4xl font-bold text-[#1f2b8b]">New Announcement</h3>
                    <p class="text-xl text-slate-500">Create a new announcement for employees</p>
                </div>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-8 pb-8">
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Title *</label>
                        <input type="text" placeholder="Announcement title" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Content *</label>
                        <textarea rows="4" placeholder="Write your announcement here..." class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Priority</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                                <option>Medium</option>
                                <option>Low</option>
                                <option>High</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Target Audience</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                                <option>Specific Department</option>
                                <option>Faculty Only</option>
                                <option>Everyone</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Target Department</label>
                        <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
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

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Publish Date</label>
                            <input type="date" value="2026-02-01" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Expiry Date</label>
                            <input type="date" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-2">
                        <label for="publish-now-new" class="text-xl font-semibold text-[#1f2b8b]">Publish immediately</label>
                        <input id="publish-now-new" type="checkbox" class="h-5 w-10 cursor-pointer accent-[#1f2b8b]">
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" data-close-modal class="rounded-md border border-slate-400 px-6 py-2 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="button" data-close-modal class="rounded-md bg-[#00386f] px-6 py-2 text-lg font-semibold text-white hover:bg-[#002f5d]">Post announcement</button>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-announcement-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-8 py-6">
                <div>
                    <h3 class="text-4xl font-bold text-[#1f2b8b]">Edit Announcement</h3>
                    <p class="text-xl text-slate-500">Update the announcement</p>
                </div>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-8 pb-8">
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Title *</label>
                        <input type="text" value="CHED Compliance Deadline Reminder" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Content *</label>
                        <textarea rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">This is a reminder that all faculty members must submit their updated curriculum vitae and credentials for the upcoming CHED compliance review. Please ensure your resume is updated in the system by January 31, 2025.</textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Type</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                                <option>Urgent</option>
                                <option>General</option>
                                <option>Reminder</option>
                                <option>Event</option>
                                <option>Policy Update</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Priority</label>
                            <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Target Department</label>
                        <select class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                            <option>All</option>
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

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Publish Date</label>
                            <input type="date" value="2025-01-10" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="mb-1 block text-lg font-semibold text-[#1f2b8b]">Expiry Date</label>
                            <input type="date" value="2025-01-31" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-lg focus:border-blue-400 focus:outline-none">
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-2">
                        <label for="publish-now-edit" class="text-xl font-semibold text-[#1f2b8b]">Publish immediately</label>
                        <input id="publish-now-edit" type="checkbox" checked class="h-5 w-10 cursor-pointer accent-[#1f2b8b]">
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" data-close-modal class="rounded-md border border-slate-400 px-6 py-2 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="button" data-close-modal class="rounded-md bg-[#00386f] px-6 py-2 text-lg font-semibold text-white hover:bg-[#002f5d]">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalOpeners = document.querySelectorAll('[data-open-modal]');
        const modalClosers = document.querySelectorAll('[data-close-modal]');
        const modalElements = document.querySelectorAll('#new-announcement-modal, #edit-announcement-modal');

        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function hideModal(modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const hasOpenModal = Array.from(modalElements).some((item) => !item.classList.contains('hidden'));
            if (!hasOpenModal) {
                document.body.classList.remove('overflow-hidden');
            }
        }

        modalOpeners.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                showModal(button.dataset.openModal);
            });
        });

        modalClosers.forEach((button) => {
            button.addEventListener('click', () => {
                const modal = button.closest('.fixed.inset-0');
                if (modal) hideModal(modal);
            });
        });

        modalElements.forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    hideModal(modal);
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') return;

            modalElements.forEach((modal) => {
                if (!modal.classList.contains('hidden')) {
                    hideModal(modal);
                }
            });
        });
    </script>
</body>
</html>
