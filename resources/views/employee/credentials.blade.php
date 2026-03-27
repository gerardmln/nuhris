@extends('employee.layout')

@section('title', 'Credentials')
@section('page_title', 'Credentials')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-600">Upload and manage your credentials. HR will review and verify submissions.</p>
        <a href="{{ route('employee.credentials.upload') }}" class="rounded-xl bg-[#242b34] px-5 py-2 text-sm font-semibold text-white hover:bg-[#1b222b]">+ Upload New</a>
    </div>

    <div class="inline-flex flex-wrap items-center gap-1 rounded-xl bg-[#c7c7c9] p-1 text-xs font-semibold text-slate-900">
        <button type="button" data-filter="all" class="cred-filter rounded-lg bg-[#d9d9db] px-4 py-2">All</button>
        <button type="button" data-filter="resume" class="cred-filter rounded-lg px-4 py-2 hover:bg-[#d9d9db]">Resume</button>
        <button type="button" data-filter="prc" class="cred-filter rounded-lg px-4 py-2 hover:bg-[#d9d9db]">PRC License</button>
        <button type="button" data-filter="seminars" class="cred-filter rounded-lg px-4 py-2 hover:bg-[#d9d9db]">Seminars</button>
        <button type="button" data-filter="degrees" class="cred-filter rounded-lg px-4 py-2 hover:bg-[#d9d9db]">Degrees</button>
        <button type="button" data-filter="ranking" class="cred-filter rounded-lg px-4 py-2 hover:bg-[#d9d9db]">Ranking</button>
    </div>

    <div class="grid place-items-center py-24">
        <p id="credentials-empty" class="text-3xl text-slate-400">No credentials found. Upload your first credential above</p>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const buttons = document.querySelectorAll('.cred-filter');
            const emptyText = document.getElementById('credentials-empty');

            const labels = {
                all: 'No credentials found. Upload your first credential above',
                resume: 'No Resume credentials found. Upload your first file above',
                prc: 'No PRC License credentials found. Upload your first file above',
                seminars: 'No Seminar credentials found. Upload your first file above',
                degrees: 'No Degree credentials found. Upload your first file above',
                ranking: 'No Ranking credentials found. Upload your first file above',
            };

            const applyFilter = (filter) => {
                buttons.forEach((button) => {
                    const active = button.dataset.filter === filter;
                    button.classList.toggle('bg-[#d9d9db]', active);
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                if (emptyText) {
                    emptyText.textContent = labels[filter] ?? labels.all;
                }
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => applyFilter(button.dataset.filter));
            });

            applyFilter('all');
        })();
    </script>
@endpush