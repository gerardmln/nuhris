<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Credentials | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased">
    <main class="mx-auto max-w-7xl space-y-5 px-4 py-6 sm:px-6">
        <div>
            <h1 class="text-3xl font-bold text-[#1f2b5d]">Credential Verification</h1>
            <p class="text-sm text-slate-500">Manage and verify employee credentials.</p>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Credentials</p><p class="text-3xl font-extrabold">{{ $stats['total'] }}</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Pending Review</p><p class="text-3xl font-extrabold">{{ $stats['pending'] }}</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Verified</p><p class="text-3xl font-extrabold">{{ $stats['verified'] }}</p></article>
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Expiring Soon</p><p class="text-3xl font-extrabold">{{ $stats['expiring_soon'] }}</p></article>
        </div>

        <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white shadow-sm">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Credential</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Expiry Date</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($credentialRows as $row)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold">{{ $row['employee']->full_name }}</p>
                                <p class="text-xs text-slate-500">{{ $row['employee']->email }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $row['credential'] }}</td>
                            <td class="px-4 py-3">{{ $row['type'] }}</td>
                            <td class="px-4 py-3">{{ $row['expiry_date'] }}</td>
                            <td class="px-4 py-3">{{ $row['status'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No credential rows available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </article>
    </main>
</body>
</html>
