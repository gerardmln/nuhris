@extends('admin.layout')

@section('title', 'API Integrations')
@section('page_title', 'API Integrations')

@section('content')
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Integrations</p><p class="text-4xl font-extrabold">5</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Connected</p><p class="text-4xl font-extrabold">5</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Issues</p><p class="text-4xl font-extrabold">1</p></article>
        <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">API Calls Today</p><p class="text-4xl font-extrabold">4,585</p></article>
    </div>

    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-[#24358a]">API Integrations</h3>
            <button class="rounded-lg bg-[#083b72] px-4 py-2 text-xs font-semibold text-white">+ Add Integration</button>
        </div>
        <div class="space-y-3">
            @foreach (['PRC License Verification API', 'CHED Compliance Portal', 'Email Service'] as $api)
                <div class="rounded-lg bg-[#cfe1f5] p-3">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold">{{ $api }}</p>
                        <div class="flex gap-2">
                            <button class="rounded border border-slate-300 bg-white px-2 py-1 text-xs">Configure</button>
                            <button class="rounded border border-blue-300 bg-white px-2 py-1 text-xs text-blue-700">Sync Now</button>
                        </div>
                    </div>
                    <div class="mt-2 h-1 rounded bg-slate-200"></div>
                </div>
            @endforeach
        </div>
    </article>

    <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
        <h3 class="text-2xl font-bold text-[#24358a]">API Keys</h3>
        <div class="mt-3 space-y-2">
            <div class="rounded-lg bg-[#cfe1f5] p-3"><p class="font-semibold">Production API Key</p><p class="text-xs">••••••••••••</p></div>
            <div class="rounded-lg bg-[#cfe1f5] p-3"><p class="font-semibold">Development API Key</p><p class="text-xs">••••••••••••</p></div>
        </div>
    </article>
@endsection