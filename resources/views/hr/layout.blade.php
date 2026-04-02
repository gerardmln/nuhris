<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'HR' }} | {{ config('app.name', 'NU HRIS') }}</title>
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
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ ($activeNav ?? '') === 'dashboard' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'dashboard')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('employees.index') }}" class="{{ ($activeNav ?? '') === 'employees' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'employees')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Employees
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('credentials.index') }}" class="{{ ($activeNav ?? '') === 'credentials' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'credentials')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Credentials
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('timekeeping.index') }}" class="{{ ($activeNav ?? '') === 'timekeeping' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'timekeeping')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Time Keeping
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('leave.index') }}" class="{{ ($activeNav ?? '') === 'leave' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'leave')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Leave Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('announcements.index') }}" class="{{ ($activeNav ?? '') === 'announcements' ? 'flex items-center gap-2 rounded-xl bg-[#ffdc00] px-4 py-2 font-semibold text-slate-900 shadow-sm' : 'block rounded-xl bg-indigo-900/70 px-4 py-2 hover:bg-indigo-900' }}">
                            @if (($activeNav ?? '') === 'announcements')
                                <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            @endif
                            Announcements
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-8 border-t border-white/20 px-5 py-5 lg:mt-auto">
                <div class="mb-4">
                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'HR User' }}</p>
                    <p class="text-xs text-blue-100">{{ auth()->user()->email ?? 'user' }}</p>
                </div>

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-white/20 px-4 py-2 text-left text-sm font-medium hover:bg-white/10">
                            Sign out
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-[30px] font-bold leading-none text-[#1f2b5d]">{{ $pageHeading ?? ($pageTitle ?? 'HR') }}</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    @include('partials.header-actions')
                </div>
            </header>

            <section class="space-y-5 px-5 py-5 sm:px-6 sm:py-6">
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')
</body>
</html>