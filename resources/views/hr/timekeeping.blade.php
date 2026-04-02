@extends('hr.layout')

@php
    $pageTitle = 'Time Keeping';
    $pageHeading = 'TimeKeeping';
    $activeNav = 'timekeeping';
@endphp

@section('content')
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
                <input type="text" placeholder="Search Employees" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
            </div>
            <div>
                <select class="w-full rounded-md border border-slate-300 px-2 py-2 text-sm focus:border-blue-400 focus:outline-none">
                    @foreach ($periods as $period)
                        <option>{{ $period }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </article>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($employeeCards as $card)
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                <div class="mb-4 flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#00386f] text-sm font-semibold text-white">{{ $card['initials'] }}</span>
                    <div>
                        <p class="text-xl font-bold text-[#1f2b5d]">{{ $card['name'] }}</p>
                        <p class="text-sm text-slate-500">{{ $card['department'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-emerald-100 p-3 text-center">
                        <p class="text-4xl font-extrabold text-emerald-700">{{ $card['present'] }}</p>
                        <p class="text-xs font-semibold text-emerald-700">Present</p>
                    </div>
                    <div class="rounded-lg bg-amber-100 p-3 text-center">
                        <p class="text-4xl font-extrabold text-amber-700">{{ $card['tardiness'] }}</p>
                        <p class="text-xs font-semibold text-amber-700">Tardiness(min)</p>
                    </div>
                </div>
                <p class="mt-3 text-xs text-slate-500">Official: {{ $card['official_time'] }}</p>
                <a href="{{ route('timekeeping.dtr', ['employee' => $card['id']]) }}" class="mt-3 block w-full rounded-md bg-[#00386f] px-3 py-2 text-center text-sm font-semibold text-white hover:bg-[#002f5d]">View DTR</a>
            </article>
        @empty
            <p class="text-slate-500">No employees found.</p>
        @endforelse
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

                <label for="biometrics_file" class="block cursor-pointer rounded-lg border border-dashed border-slate-400 p-8 text-center">
                    <input id="biometrics_file" name="biometrics_file" type="file" accept="application/pdf,.pdf" class="sr-only" required>
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
@endsection

@push('scripts')
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
@endpush