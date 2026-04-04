<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | {{ config('app.name', 'NU HRIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#eceef1] text-slate-900 antialiased overflow-x-hidden overflow-y-auto">
    @php
        $name = auth()->user()->name ?? 'Martinez, Ian Isaac';
        $sections = [
            [
                'label' => 'Dashboard',
                'route' => 'admin.dashboard',
                'match' => 'admin.dashboard',
            ],
            [
                'label' => 'User & Role Management',
                'route' => 'admin.users.accounts',
                'match' => 'admin.users.*',
                'children' => [
                    ['label' => 'User Accounts', 'route' => 'admin.users.accounts', 'match' => 'admin.users.accounts'],
                    ['label' => 'Role Assignment', 'route' => 'admin.users.role-assignment', 'match' => 'admin.users.role-assignment'],
                    ['label' => 'RBAC Permissions', 'route' => 'admin.users.rbac', 'match' => 'admin.users.rbac'],
                ],
            ],
            [
                'label' => 'Policy & Configuration',
                'route' => 'admin.policy.cutoff',
                'match' => 'admin.policy.*',
                'children' => [
                    ['label' => 'Cut-off & Schedules', 'route' => 'admin.policy.cutoff', 'match' => 'admin.policy.cutoff'],
                    ['label' => 'Leave Rules', 'route' => 'admin.policy.leave', 'match' => 'admin.policy.leave'],
                    ['label' => 'Compliance Rules', 'route' => 'admin.policy.compliance', 'match' => 'admin.policy.compliance'],
                    ['label' => 'Notification Templates', 'route' => 'admin.policy.templates', 'match' => 'admin.policy.templates'],
                ],
            ],
            [
                'label' => 'Integration & Governance',
                'route' => 'admin.integration.api',
                'match' => 'admin.integration.*',
                'children' => [
                    ['label' => 'API Integrations', 'route' => 'admin.integration.api', 'match' => 'admin.integration.api'],
                    ['label' => 'Audit Logs', 'route' => 'admin.integration.audit', 'match' => 'admin.integration.audit'],
                    ['label' => 'Data Validation', 'route' => 'admin.integration.validation', 'match' => 'admin.integration.validation'],
                    ['label' => 'Backup & Security', 'route' => 'admin.integration.backup', 'match' => 'admin.integration.backup'],
                ],
            ],
            [
                'label' => 'Report & Oversight',
                'route' => 'admin.reports',
                'match' => 'admin.reports',
            ],
        ];
    @endphp

    <div class="min-h-screen lg:flex">
        <aside class="flex w-full flex-col bg-[#f6f7f9] lg:sticky lg:top-0 lg:h-screen lg:w-64 lg:shrink-0">
            <div class="border-b border-slate-300 px-6 py-5">
                <p class="text-[32px] font-extrabold leading-none text-[#083b72]">NU HRIS</p>
                <p class="text-sm text-slate-500">Admin</p>
            </div>

            <nav class="flex-1 space-y-3 overflow-y-auto px-4 py-4" id="admin-sidebar-nav">
                @foreach ($sections as $section)
                    @php($active = request()->routeIs($section['match']))
                    <div class="admin-section" data-has-children="{{ ! empty($section['children']) ? 'true' : 'false' }}">
                        @if (! empty($section['children']))
                            <button type="button" class="admin-section-toggle flex w-full items-center justify-between rounded-xl px-4 py-2 text-left text-[15px] font-medium transition {{ $active ? 'bg-[#ffda00] text-[#0b2f62] shadow-sm' : 'bg-[#0a3f79] text-blue-100 hover:bg-[#093468]' }}" data-expanded="{{ $active ? 'true' : 'false' }}" aria-expanded="{{ $active ? 'true' : 'false' }}">
                                <span>{{ $section['label'] }}</span>
                                <svg class="h-4 w-4 transition-transform {{ $active ? 'rotate-180' : '' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M5.25 7.5 10 12.25 14.75 7.5" />
                                </svg>
                            </button>

                            <div class="admin-section-children ml-3 mt-2 space-y-2 border-l border-slate-300 pl-3 {{ $active ? '' : 'hidden' }}">
                                @foreach ($section['children'] as $child)
                                    @php($childActive = request()->routeIs($child['match']))
                                    <a href="{{ route($child['route']) }}" class="block rounded-xl px-4 py-2 text-sm transition {{ $childActive ? 'bg-[#ffda00] text-[#0b2f62] shadow-sm' : 'bg-[#0a3f79] text-blue-100 hover:bg-[#093468]' }}">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ route($section['route']) }}" class="block rounded-xl px-4 py-2 text-[15px] font-medium transition {{ $active ? 'bg-[#ffda00] text-[#0b2f62] shadow-sm' : 'bg-[#0a3f79] text-blue-100 hover:bg-[#093468]' }}">
                                {{ $section['label'] }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </nav>

            <div class="mt-auto border-t border-slate-300 px-5 py-4">
                <p class="text-sm font-semibold text-[#0a3f79]">{{ $name }}</p>
                <p class="text-xs text-slate-500">user</p>
            </div>
        </aside>

        <main class="min-h-screen flex-1">
            <header class="border-b border-slate-300 bg-[#0a3f79] px-8 py-4 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-[36px] font-bold leading-none text-white">Admin Dashboard</h1>
                        <p class="text-sm text-blue-100">National University HRIS</p>
                    </div>
                    <div class="flex items-center gap-2 text-white">
                        <div class="relative">
                            <button id="admin-bell-toggle" type="button" class="rounded-full p-2 hover:bg-white/10" aria-label="Notifications" aria-expanded="false" aria-controls="admin-notification-panel">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"></path>
                                    <path d="M10 20a2 2 0 0 0 4 0"></path>
                                </svg>
                            </button>

                            <div id="admin-notification-panel" class="absolute right-0 z-50 mt-2 hidden w-72 rounded-xl border border-slate-200 bg-white p-3 text-slate-900 shadow-xl">
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-2xl font-semibold leading-none text-[#232f83]">Notifications</h3>
                                    <button type="button" class="text-xs font-medium text-red-600 hover:underline">Mark all as read</button>
                                </div>

                                <div class="space-y-3">
                                    <article>
                                        <p class="text-xl font-medium leading-tight">PRC License Expiring</p>
                                        <p class="text-xs text-slate-500">5 faculty members have licenses expiring in 30 days</p>
                                        <p class="text-xs text-slate-400">5 min ago</p>
                                    </article>

                                    <article>
                                        <p class="text-xl font-medium leading-tight">New User Registration</p>
                                        <p class="text-xs text-slate-500">John Smith has been added to the system</p>
                                        <p class="text-xs text-slate-400">1 hour ago</p>
                                    </article>

                                    <article>
                                        <p class="text-xl font-medium leading-tight">Compliance Alert</p>
                                        <p class="text-xs text-slate-500">CHED compliance report due in 7 days</p>
                                        <p class="text-xs text-slate-400">2 hours ago</p>
                                    </article>

                                    <article>
                                        <p class="text-xl font-medium leading-tight">Backup Complete</p>
                                        <p class="text-xs text-slate-500">System backup completed successfully</p>
                                        <p class="text-xs text-slate-400">3 hours ago</p>
                                    </article>
                                </div>
                            </div>
                        </div>

                        <details class="group relative">
                            <summary class="flex cursor-pointer list-none items-center gap-1 rounded-full px-1 py-1 hover:bg-white/10">
                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <circle cx="12" cy="8" r="4"></circle>
                                    <path d="M4 20c1.5-4 5-6 8-6s6.5 2 8 6"></path>
                                </svg>
                                <svg class="h-4 w-4 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M5.25 7.5 10 12.25 14.75 7.5" />
                                </svg>
                            </summary>

                            <div class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white text-slate-900 shadow-xl">
                                <div class="border-b border-slate-200 px-4 py-3">
                                    <p class="text-sm font-semibold">{{ $name }}</p>
                                    <p class="text-xs text-slate-500">Admin user</p>
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
                                        <button type="button" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">
                                            Sign out
                                        </button>
                                    </div>
                                @endauth
                            </div>
                        </details>
                    </div>
                </div>
            </header>

            <section class="space-y-4 px-4 py-4 sm:px-6">
                <div>
                    <h2 class="text-[36px] font-bold leading-none text-[#24358a]">@yield('page_title')</h2>
                    @hasSection('page_subtitle')
                        <p class="text-sm text-slate-500">@yield('page_subtitle')</p>
                    @endif
                </div>
                @if (session('success'))
                    <div class="rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        (() => {
            const nav = document.getElementById('admin-sidebar-nav');
            if (!nav) return;

            const sections = Array.from(nav.querySelectorAll('.admin-section'));
            const collapsible = sections.filter((section) => section.dataset.hasChildren === 'true');

            const closeAllExcept = (targetSection) => {
                collapsible.forEach((section) => {
                    if (section === targetSection) return;

                    const toggle = section.querySelector('.admin-section-toggle');
                    const children = section.querySelector('.admin-section-children');
                    const icon = toggle?.querySelector('svg');
                    if (!toggle || !children) return;

                    children.classList.add('hidden');
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.dataset.expanded = 'false';
                    icon?.classList.remove('rotate-180');
                });
            };

            collapsible.forEach((section) => {
                const toggle = section.querySelector('.admin-section-toggle');
                const children = section.querySelector('.admin-section-children');
                const icon = toggle?.querySelector('svg');
                if (!toggle || !children) return;

                toggle.addEventListener('click', () => {
                    const isOpen = toggle.dataset.expanded === 'true';

                    if (isOpen) {
                        children.classList.add('hidden');
                        toggle.setAttribute('aria-expanded', 'false');
                        toggle.dataset.expanded = 'false';
                        icon?.classList.remove('rotate-180');
                        return;
                    }

                    closeAllExcept(section);
                    children.classList.remove('hidden');
                    toggle.setAttribute('aria-expanded', 'true');
                    toggle.dataset.expanded = 'true';
                    icon?.classList.add('rotate-180');
                });
            });
        })();

        (() => {
            const bellToggle = document.getElementById('admin-bell-toggle');
            const panel = document.getElementById('admin-notification-panel');
            if (!bellToggle || !panel) return;

            const closePanel = () => {
                panel.classList.add('hidden');
                bellToggle.setAttribute('aria-expanded', 'false');
            };

            const openPanel = () => {
                panel.classList.remove('hidden');
                bellToggle.setAttribute('aria-expanded', 'true');
            };

            bellToggle.addEventListener('click', (event) => {
                event.stopPropagation();
                if (panel.classList.contains('hidden')) {
                    openPanel();
                } else {
                    closePanel();
                }
            });

            panel.addEventListener('click', (event) => {
                event.stopPropagation();
            });

            document.addEventListener('click', () => {
                closePanel();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closePanel();
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>