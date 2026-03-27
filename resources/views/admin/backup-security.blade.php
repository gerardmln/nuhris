@extends('admin.layout')

@section('title', 'Backup & Security')
@section('page_title', 'Backup & Security')

@section('content')
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Last Backup</p><p class="text-4xl font-extrabold">4 hours ago</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Storage Used</p><p class="text-4xl font-extrabold">45.2 GB / 100 GB</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Failed Logins (24h)</p><p class="text-4xl font-extrabold">16</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Security Score</p><p class="text-4xl font-extrabold">92/100</p></article>
    </div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <h3 class="text-2xl font-bold text-[#24358a]">Backup Management</h3>
            <div class="mt-2 flex gap-2">
                <button class="rounded border border-slate-300 bg-[#083b72] px-3 py-1 text-xs font-semibold text-white">Manual Backup</button>
                <button class="rounded border border-slate-300 bg-white px-3 py-1 text-xs font-semibold">Restore Backup</button>
            </div>
            <div class="mt-3 space-y-2 text-xs">
                <div class="flex items-center justify-between rounded bg-slate-100 px-3 py-2"><span>Full Backup</span><span>2.4 GB</span></div>
                <div class="flex items-center justify-between rounded bg-slate-100 px-3 py-2"><span>Incremental</span><span>116 MB</span></div>
                <div class="flex items-center justify-between rounded bg-slate-100 px-3 py-2"><span>Incremental</span><span>243 MB</span></div>
            </div>
        </article>

        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <h3 class="text-2xl font-bold text-[#24358a]">Security Alerts</h3>
            <div class="mt-3 space-y-2 text-xs">
                <div class="rounded bg-amber-100 px-3 py-2">Multiple failed login attempts</div>
                <div class="rounded bg-blue-100 px-3 py-2">Automatic backup completed successfully</div>
                <div class="rounded bg-amber-100 px-3 py-2">Unusual activity detected: 50+ API calls</div>
                <div class="rounded bg-emerald-100 px-3 py-2">Security patch applied successfully</div>
            </div>
        </article>
    </div>
@endsection
