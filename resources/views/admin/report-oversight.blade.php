@extends('admin.layout')

@section('title', 'Report & Oversight')
@section('page_title', 'Report & Oversight')

@section('content')
    <div class="flex flex-wrap items-center gap-2">
        <button class="rounded border border-slate-300 bg-white px-3 py-2 text-xs">Filters</button>
        <select class="rounded border border-slate-300 bg-white px-3 py-2 text-xs"><option>1st Term 2025-2026</option></select>
        <select class="rounded border border-slate-300 bg-white px-3 py-2 text-xs"><option>All Departments</option></select>
        <button class="rounded border border-slate-300 bg-white px-3 py-2 text-xs">Print</button>
        <button class="rounded border border-slate-300 bg-white px-3 py-2 text-xs">Export PDF</button>
        <button class="rounded bg-emerald-700 px-3 py-2 text-xs text-white">Export Excel</button>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Users</p><p class="text-4xl font-extrabold">5</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Active Faculty</p><p class="text-4xl font-extrabold">5</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Compliance Rate</p><p class="text-4xl font-extrabold">67%</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Attendance Rate</p><p class="text-4xl font-extrabold">85%</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Expiring PRC</p><p class="text-4xl font-extrabold">2</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Pending Verifications</p><p class="text-4xl font-extrabold">5</p></article>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm xl:col-span-2"><h3 class="text-2xl font-bold text-[#24358a]">Attendance Trends vs Target</h3><div class="mt-3 h-56 rounded border border-slate-200 bg-slate-50"></div></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><h3 class="text-2xl font-bold text-[#24358a]">Employee Distribution</h3><div class="mt-3 h-56 rounded border border-slate-200 bg-slate-50"></div></article>
    </div>

    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
        <h3 class="text-2xl font-bold text-[#24358a]">Department Summary</h3>
        <table class="mt-3 min-w-full text-left text-xs">
            <thead class="bg-slate-100"><tr><th class="px-2 py-2">Department</th><th class="px-2 py-2">Employees</th><th class="px-2 py-2">Compliance %</th><th class="px-2 py-2">Attendance %</th><th class="px-2 py-2">Status</th></tr></thead>
            <tbody class="divide-y divide-slate-200">
                <tr><td class="px-2 py-2">Engineering</td><td class="px-2 py-2">1</td><td class="px-2 py-2">94%</td><td class="px-2 py-2">93%</td><td class="px-2 py-2">Excellent</td></tr>
                <tr><td class="px-2 py-2">Arts & Sciences</td><td class="px-2 py-2">1</td><td class="px-2 py-2">97%</td><td class="px-2 py-2">90%</td><td class="px-2 py-2">Excellent</td></tr>
                <tr><td class="px-2 py-2">IT</td><td class="px-2 py-2">1</td><td class="px-2 py-2">97%</td><td class="px-2 py-2">95%</td><td class="px-2 py-2">Good</td></tr>
                <tr><td class="px-2 py-2">Business</td><td class="px-2 py-2">1</td><td class="px-2 py-2">95%</td><td class="px-2 py-2">95%</td><td class="px-2 py-2">Excellent</td></tr>
                <tr><td class="px-2 py-2">Education</td><td class="px-2 py-2">1</td><td class="px-2 py-2">95%</td><td class="px-2 py-2">90%</td><td class="px-2 py-2">Excellent</td></tr>
            </tbody>
        </table>
    </article>
@endsection