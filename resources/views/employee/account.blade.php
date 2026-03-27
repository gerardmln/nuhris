@extends('employee.layout')

@section('title', 'Account')
@section('page_title', 'Account')

@section('content')
    <article class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-sm">
        <div class="h-20 bg-[#003a78]"></div>
        <div class="flex flex-wrap items-end gap-4 px-6 pb-6">
            <div class="-mt-10 grid h-24 w-24 place-content-center rounded-2xl border-4 border-white bg-slate-200 text-2xl font-bold text-slate-700">IM</div>
            <div>
                <p class="text-2xl font-bold text-slate-900">Ian Isaac Martinez</p>
                <p class="text-sm text-slate-500">martinezian@gmail.com</p>
            </div>
        </div>
    </article>

    <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
        <h2 class="text-3xl font-bold text-slate-900">Profile Information</h2>

        <form class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3" method="POST" action="#">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Employee Type</label>
                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option>Select type</option>
                    <option>Faculty</option>
                    <option>Security</option>
                    <option>ASP</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Employee ID</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., NU-2025-001">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Department</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., SACE">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Phone</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., 09171234567">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Position</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., Instructor I">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Date Hired</label>
                <input type="date" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Home address">
            </div>

            <div class="lg:col-span-3">
                <button type="submit" class="float-right rounded-xl bg-[#003a78] px-6 py-2 text-sm font-semibold text-white hover:bg-[#002f61]">Save Changes</button>
            </div>
        </form>
    </article>
@endsection