<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased overflow-x-hidden overflow-y-auto">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full bg-[#00386f] text-white lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:shrink-0">
            <div class="border-b border-white/20 px-6 py-5">
                <p class="text-2xl font-extrabold tracking-wide">NU HRIS</p>
                <p class="text-sm text-blue-100">Human Resources</p>
            </div>

            <nav class="px-4 py-4">
                <ul class="space-y-2 text-[15px]">
                    <li><a href="{{ route('dashboard') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Dashboard</a></li>
                    <li><a href="{{ route('employees.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Employees</a></li>
                    <li><a href="{{ route('credentials.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Credentials</a></li>
                    <li><a href="{{ route('timekeeping.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Time Keeping</a></li>
                    <li><a href="{{ route('leave.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Leave Management</a></li>
                    <li><a href="{{ route('announcements.index') }}" class="block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900">Announcements</a></li>
                </ul>
            </nav>

            <div class="mt-8 border-t border-white/20 px-5 py-5 lg:mt-auto">
                <div class="mb-4">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Martinez, Ian Isaac' }}</p>
                    <p class="text-xs text-blue-100">{{ auth()->user()->email ?? 'user' }}</p>
                </div>
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">Notifications</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-4 px-5 py-5 sm:px-6 sm:py-6">
                <div>
                    <h2 class="text-3xl font-bold text-[#1f2b5d]">Notifications</h2>
                    <p class="text-sm text-slate-500">All caught up!</p>
                </div>

                <article class="rounded-xl border border-slate-300 bg-white shadow-sm">
                    <div class="flex min-h-[320px] flex-col items-center justify-center px-6 py-10 text-center">
                        <svg class="h-14 w-14 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
                            <path d="M10 20a2 2 0 0 0 4 0"></path>
                        </svg>
                        <h3 class="mt-4 text-4xl font-bold text-slate-400">No Notifications Yet</h3>
                    </div>
                </article>
            </section>
        </main>
    </div>
</body>
</html>
