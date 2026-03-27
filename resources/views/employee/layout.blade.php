<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Employee Portal') | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased overflow-x-hidden overflow-y-auto">
    @php
        $name = auth()->user()->name ?? 'Martinez, Ian Isaac';
        $email = auth()->user()->email ?? 'martinezian@gmail.com';
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'employee.dashboard', 'match' => 'employee.dashboard'],
            ['label' => 'Credentials', 'route' => 'employee.credentials', 'match' => 'employee.credentials*'],
            ['label' => 'Attendance & DTR', 'route' => 'employee.attendance', 'match' => 'employee.attendance'],
            ['label' => 'Leave Monitoring', 'route' => 'employee.leave', 'match' => 'employee.leave'],
            ['label' => 'Notifications', 'route' => 'employee.notifications', 'match' => 'employee.notifications'],
            ['label' => 'Account', 'route' => 'employee.account', 'match' => 'employee.account'],
        ];
    @endphp

    <div class="min-h-screen lg:flex">
        <aside class="flex w-full flex-col bg-blue-950 text-white lg:min-h-screen lg:w-72">
            <div class="border-b border-white/15 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="grid h-9 w-9 place-content-center rounded bg-yellow-400 text-sm font-black text-blue-950">N</div>
                    <div>
                        <p class="text-2xl font-extrabold leading-none">NU Lipa</p>
                        <p class="text-sm text-blue-100">HRIS Self-Service</p>
                    </div>
                </div>
            </div>

            <div class="border-b border-white/15 px-6 py-5">
                <p class="text-sm font-semibold">{{ $name }}</p>
                <p class="text-xs text-blue-100">{{ $email }}</p>
            </div>

            <nav class="px-4 py-4">
                <ul class="space-y-2 text-[15px] font-medium">
                    @foreach ($navItems as $item)
                        @php($active = request()->routeIs($item['match']))
                        <li>
                            @if ($active)
                                <a href="{{ route($item['route']) }}" class="block rounded-xl bg-yellow-400 px-4 py-2 font-semibold text-blue-950 transition hover:bg-yellow-300">
                                    {{ $item['label'] }}
                                </a>
                            @else
                                <a href="{{ route($item['route']) }}" class="block rounded-xl px-4 py-2 text-blue-100 transition hover:bg-white/10 hover:text-white">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="mt-auto border-t border-white/15 px-6 py-5">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg px-3 py-2 text-sm font-semibold text-blue-100 hover:bg-white/10 hover:text-white">Sign out</button>
                    </form>
                @else
                    <button type="button" class="rounded-lg px-3 py-2 text-sm font-semibold text-blue-100">Sign out</button>
                @endauth
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-white px-6 py-4 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-[30px] font-bold leading-none text-blue-900">@yield('page_title')</h1>
                        <p class="text-sm text-slate-500">National University HRIS</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('employee.notifications') }}" class="rounded-full border border-slate-300 p-2 text-slate-500 hover:bg-slate-100" aria-label="Notifications">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
                                <path d="M10 20a2 2 0 0 0 4 0"></path>
                            </svg>
                        </a>

                        <details class="group relative">
                            <summary class="flex cursor-pointer list-none items-center gap-1 rounded-full px-1 py-1 text-slate-600 hover:bg-slate-100">
                                <svg class="h-8 w-8 text-[#1f2b8b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M4 20c1.5-4 5-6 8-6s6.5 2 8 6"></path>
                                </svg>
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.25 7.5 10 12.25 14.75 7.5" />
                                </svg>
                            </summary>

                            <div class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xl">
                                <div class="border-b border-slate-200 px-4 py-3">
                                    <p class="text-sm font-semibold">{{ $name }}</p>
                                    <p class="text-xs text-slate-500">{{ $email }}</p>
                                </div>

                                @auth
                                    <form method="POST" action="{{ route('logout') }}" class="p-2">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">
                                            Sign out
                                        </button>
                                    </form>
                                @else
                                    <div class="p-2">
                                        <span class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700">Sign out</span>
                                    </div>
                                @endauth
                            </div>
                        </details>
                    </div>
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