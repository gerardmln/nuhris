<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daily Time Record | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased">
    <main class="mx-auto max-w-7xl space-y-5 px-4 py-6 sm:px-6">
        <a href="{{ route('timekeeping.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
            <span>&larr;</span>
            Back to Time Keeping
        </a>

        <article class="rounded-xl border border-slate-300 bg-[#cfe1f5] p-4 shadow-sm">
            <h1 class="text-2xl font-bold text-[#1f2b5d]">{{ $employee?->full_name ?? 'Employee' }}</h1>
            <p class="text-sm text-slate-600">{{ $employee?->department?->name ?? 'Unassigned' }} | Period: {{ $period_label }}</p>
            <p class="text-xs text-slate-600">Official Time: {{ $official_time }}</p>
        </article>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Present Days</p><p class="text-3xl font-extrabold text-emerald-700">{{ $summary['present_days'] }}</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Absent Days</p><p class="text-3xl font-extrabold text-red-600">{{ $summary['absent_days'] }}</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Tardiness</p><p class="text-3xl font-extrabold text-amber-600">{{ $summary['tardiness_total'] }} min</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Undertime</p><p class="text-3xl font-extrabold text-violet-600">{{ $summary['undertime_total'] }} min</p></article>
        </div>

        <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Day</th>
                        <th class="px-3 py-2">Time In</th>
                        <th class="px-3 py-2">Time Out</th>
                        <th class="px-3 py-2">Tardiness</th>
                        <th class="px-3 py-2">Undertime</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($records as $record)
                        <tr>
                            <td class="px-3 py-2">{{ $record['date'] }}</td>
                            <td class="px-3 py-2">{{ $record['day'] }}</td>
                            <td class="px-3 py-2">{{ $record['time_in'] }}</td>
                            <td class="px-3 py-2">{{ $record['time_out'] }}</td>
                            <td class="px-3 py-2">{{ $record['tardiness_minutes'] ? $record['tardiness_minutes'].' min' : '-' }}</td>
                            <td class="px-3 py-2">{{ $record['undertime_minutes'] ? $record['undertime_minutes'].' min' : '-' }}</td>
                            <td class="px-3 py-2">{{ $record['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </article>
    </main>
</body>
</html>
