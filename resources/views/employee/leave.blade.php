@extends('employee.layout')

@section('title', 'Leave Monitoring')
@section('page_title', 'Leave Monitoring')

@section('content')
    <p class="text-sm text-slate-600">View your leave balances and history. Leave data is managed by HR (read-only).</p>
    <p class="text-center text-lg text-slate-400">No leave balance data available yet. HR will upload this information.</p>

    <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
        <h2 class="text-3xl font-bold text-slate-900">Leave History</h2>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-4 py-2">Type</th>
                        <th class="px-4 py-2">Start Date</th>
                        <th class="px-4 py-2">End Date</th>
                        <th class="px-4 py-2">Days Deducted</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Cut-off</th>
                        <th class="px-4 py-2">Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="py-24 text-center text-2xl text-slate-400">No leave history found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>
@endsection