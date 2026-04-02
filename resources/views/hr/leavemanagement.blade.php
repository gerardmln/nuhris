@extends('hr.layout')

@php
    $pageTitle = 'Leave Management';
    $pageHeading = 'Leave';
    $activeNav = 'leave';
@endphp

@section('content')
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
            <p class="mt-1 text-4xl font-extrabold">{{ $stats['total_employees'] }}</p>
        </article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Vacation Used</p>
            <p class="mt-1 text-4xl font-extrabold">{{ $stats['vacation_used'] }}</p>
        </article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Sick Leave Used</p>
            <p class="mt-1 text-4xl font-extrabold">{{ $stats['sick_used'] }}</p>
        </article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Current Year</p>
            <p class="mt-1 text-4xl font-extrabold">{{ $stats['current_year'] }}</p>
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
                    @foreach ($departments as $department)
                        <option>{{ $department->name }}</option>
                    @endforeach
                </select>
                <select class="rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                    <option>{{ now()->format('F Y') }}</option>
                </select>
            </div>
        </div>
    </article>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        @foreach ($leaveCards as $card)
            <article data-faculty-card data-name="{{ $card['name'] }}" data-department="{{ $card['department'] }}" data-remaining="{{ $card['remaining'] }}" data-used="{{ $card['used'] }}" class="cursor-pointer rounded-xl border border-slate-300 bg-white p-4 shadow-sm transition hover:shadow-md">
                <div class="mb-3 flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">{{ $card['initials'] }}</span>
                    <div>
                        <p class="text-xl font-bold text-[#1f2b5d]">{{ $card['name'] }}</p>
                        <p class="text-sm text-slate-500">{{ $card['department'] }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <div><p class="mb-1 text-xs text-slate-500">Vacation Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-4/5 rounded bg-emerald-700"></div></div></div>
                    <div><p class="mb-1 text-xs text-slate-500">Sick Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-3/4 rounded bg-amber-500"></div></div></div>
                    <div><p class="mb-1 text-xs text-slate-500">Emergency Leave</p><div class="h-1.5 rounded bg-slate-200"><div class="h-1.5 w-full rounded bg-violet-600"></div></div></div>
                </div>
                <p class="mt-3 inline-block rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">+{{ $card['carry_over'] }} unused from previous year</p>
            </article>
        @endforeach
    </div>

    <div id="upload-biometrics-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-4xl font-bold text-[#1f2b8b]">Upload Biometrics PDF</h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <form class="px-7 pb-7" method="POST" action="{{ route('biometrics.upload') }}" enctype="multipart/form-data">
                @csrf
                <label class="mb-3 block text-2xl font-medium text-slate-700">Biometric File (PDF only)</label>

                <label for="biometrics_file_leave" class="block cursor-pointer rounded-lg border border-dashed border-slate-400 p-8 text-center">
                    <input id="biometrics_file_leave" name="biometrics_file" type="file" accept="application/pdf,.pdf" class="sr-only" required>
                    <div class="mx-auto inline-flex h-14 w-14 items-center justify-center text-slate-400">
                        <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 16V4" />
                            <path d="m7 9 5-5 5 5" />
                            <path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3" />
                        </svg>
                    </div>
                    <p class="mt-3 text-lg text-slate-500">Click to upload or drag and drop</p>
                    <p class="text-sm text-slate-400">PDF only</p>
                </label>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="button" data-close-modal class="rounded-md border border-slate-400 px-8 py-2.5 text-lg font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md bg-[#00386f] px-8 py-2.5 text-lg font-semibold text-white hover:bg-[#002f5d]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        Process PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="leave-details-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-4xl font-bold text-[#1f2b8b]">Leave Details - <span id="leave-details-name">Employee</span></h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-7 pb-7">
                <div class="rounded-xl bg-slate-200 p-1">
                    <div class="grid grid-cols-2 gap-2 text-center text-2xl font-semibold text-[#1f2b8b]">
                        <button type="button" data-leave-tab="balance" class="leave-tab-btn rounded-lg bg-white px-4 py-2 text-[#1f2b8b]">Leave Balance</button>
                        <button type="button" data-leave-tab="history" class="leave-tab-btn rounded-lg px-4 py-2 text-slate-600">Leave History</button>
                    </div>
                </div>

                <section id="leave-balance-content" class="mt-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-remaining-days" class="text-6xl font-extrabold text-emerald-700">0</p>
                            <p class="text-3xl text-slate-700">Remaining Days</p>
                        </article>
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-used-days" class="text-6xl font-extrabold text-amber-600">0</p>
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

    <div id="leave-details-modal" class="fixed inset-0 z-50 hidden items-start justify-center overflow-y-auto bg-black/45 p-4 py-6 sm:items-center">
        <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between px-7 py-6">
                <h3 class="text-4xl font-bold text-[#1f2b8b]">Leave Details - <span id="leave-details-name">Employee</span></h3>
                <button type="button" data-close-modal class="text-4xl leading-none text-slate-500 hover:text-slate-700">&times;</button>
            </div>

            <div class="px-7 pb-7">
                <div class="rounded-xl bg-slate-200 p-1">
                    <div class="grid grid-cols-2 gap-2 text-center text-2xl font-semibold text-[#1f2b8b]">
                        <button type="button" data-leave-tab="balance" class="leave-tab-btn rounded-lg bg-white px-4 py-2 text-[#1f2b8b]">Leave Balance</button>
                        <button type="button" data-leave-tab="history" class="leave-tab-btn rounded-lg px-4 py-2 text-slate-600">Leave History</button>
                    </div>
                </div>

                <section id="leave-balance-content" class="mt-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-remaining-days" class="text-6xl font-extrabold text-emerald-700">0</p>
                            <p class="text-3xl text-slate-700">Remaining Days</p>
                        </article>
                        <article class="rounded-xl border border-slate-300 bg-white p-6 text-center shadow-sm">
                            <p id="leave-used-days" class="text-6xl font-extrabold text-amber-600">0</p>
                            <p class="text-3xl text-slate-700">Days Used</p>
                        </article>
                    </div>
                </section>

                <section id="leave-history-content" class="mt-5 hidden">
                    <article class="rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                        <p class="text-slate-500">Leave history is shown in the main table above.</p>
                    </article>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
            if (!modal) return;

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
                leaveName.textContent = card.dataset.name || 'Employee';
                remainingDays.textContent = card.dataset.remaining || '0';
                usedDays.textContent = card.dataset.used || '0';
                setLeaveTab('balance');
                openModal('leave-details-modal');
            });
        });
    </script>
@endpush