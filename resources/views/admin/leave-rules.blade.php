@extends('admin.layout')

@section('title', 'Leave Computation Rules')
@section('page_title', 'Leave Computation Rules')

@section('content')
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Leave Types</p><p class="text-4xl font-extrabold">6</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">With Rollover</p><p class="text-4xl font-extrabold">1</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Employee Types</p><p class="text-4xl font-extrabold">5</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Max VL Credits</p><p class="text-4xl font-extrabold">15 days</p></article>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm xl:col-span-2">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-xl font-bold">Leave Types</h3>
                <button id="open-leave-type-modal" class="rounded-lg bg-[#242b34] px-4 py-2 text-xs font-semibold text-white">+ Add Leave Type</button>
            </div>
            <table class="min-w-full text-left text-xs">
                <thead class="bg-slate-100"><tr><th class="px-2 py-2">Type</th><th class="px-2 py-2">Accrual</th><th class="px-2 py-2">Max Credits</th><th class="px-2 py-2">Rollover</th><th class="px-2 py-2">Applies To</th><th class="px-2 py-2">Actions</th></tr></thead>
                <tbody class="divide-y divide-slate-200">
                    <tr><td class="px-2 py-2">Vacation Leave</td><td class="px-2 py-2">1.25 days/month</td><td class="px-2 py-2">15</td><td class="px-2 py-2">Active</td><td class="px-2 py-2">All</td><td class="px-2 py-2">...</td></tr>
                    <tr><td class="px-2 py-2">Sick Leave</td><td class="px-2 py-2">1.25 days/month</td><td class="px-2 py-2">10</td><td class="px-2 py-2">No</td><td class="px-2 py-2">All</td><td class="px-2 py-2">...</td></tr>
                    <tr><td class="px-2 py-2">Emergency Leave</td><td class="px-2 py-2">Fixed</td><td class="px-2 py-2">3</td><td class="px-2 py-2">No</td><td class="px-2 py-2">All</td><td class="px-2 py-2">...</td></tr>
                </tbody>
            </table>
        </article>

        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <h3 class="text-xl font-bold">Accrual Calculator</h3>
            <div class="mt-3 space-y-2 text-sm">
                <select class="w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option>Regular Employee</option>
                    <option>Probationary</option>
                    <option>Faculty (Full - Time)</option>
                    <option>Faculty (Part - Time)</option>
                    <option>Contractual</option>
                </select>
                <input class="w-full rounded-lg border border-slate-300 px-3 py-2" value="12">
                <input class="w-full rounded-lg border border-slate-300 px-3 py-2" value="5">
            </div>
        </article>
    </div>

    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
        <h3 class="text-xl font-bold">Leave Allocation by Employee Type</h3>
        <table class="mt-3 min-w-full text-left text-xs">
            <thead class="bg-slate-100"><tr><th class="px-2 py-2">Employee Type</th><th class="px-2 py-2">Vacation Leave</th><th class="px-2 py-2">Sick Leave</th><th class="px-2 py-2">Emergency Leave</th><th class="px-2 py-2">Total Credits</th></tr></thead>
            <tbody class="divide-y divide-slate-200">
                <tr><td class="px-2 py-2">Regular Employee</td><td class="px-2 py-2">15</td><td class="px-2 py-2">15</td><td class="px-2 py-2">3</td><td class="px-2 py-2 font-semibold">33</td></tr>
                <tr><td class="px-2 py-2">Probationary</td><td class="px-2 py-2">5</td><td class="px-2 py-2">15</td><td class="px-2 py-2">3</td><td class="px-2 py-2 font-semibold">13</td></tr>
                <tr><td class="px-2 py-2">Faculty (Full-time)</td><td class="px-2 py-2">15</td><td class="px-2 py-2">15</td><td class="px-2 py-2">3</td><td class="px-2 py-2 font-semibold">33</td></tr>
            </tbody>
        </table>
    </article>

    <div id="leave-type-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 p-4">
        <div class="w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
            <h4 class="text-3xl font-bold">Add Leave Type</h4>
            <p class="text-sm text-slate-500">Create a new leave type with accrual rules</p>
            <div class="mt-3 space-y-2">
                <input type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2" placeholder="e.g., Birthday Leave">
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" class="rounded-xl border border-slate-300 px-3 py-2" placeholder="0">
                    <input type="number" class="rounded-xl border border-slate-300 px-3 py-2" placeholder="15">
                </div>
                <select class="w-full rounded-xl border border-slate-300 px-3 py-2">
                    <option>All Employees</option>
                    <option>Regular Employees</option>
                    <option>Faculty only</option>
                    <option>Female Employees</option>
                    <option>Male Employees</option>
                </select>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button id="close-leave-type-modal" class="rounded-lg px-4 py-2 text-sm font-semibold">Cancel</button>
                <button class="rounded-lg bg-[#242b34] px-4 py-2 text-sm font-semibold text-white">+ Add Type</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const modal = document.getElementById('leave-type-modal');
            document.getElementById('open-leave-type-modal').addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
            document.getElementById('close-leave-type-modal').addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        })();
    </script>
@endpush