@extends('admin.layout')

@section('title', 'User Management')
@section('page_title', 'User Management')
@section('page_subtitle', 'Manage user accounts')

@section('content')
    <div class="flex flex-wrap items-center gap-2">
        <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-72" placeholder="Search by name, email, or ID...">
        <select class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option>All Roles</option>
            @foreach ($roles as $role)
                <option>{{ $role }}</option>
            @endforeach
        </select>
        <select class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option>All Status</option>
            <option>Active</option>
            <option>Inactive</option>
        </select>
        <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Import</button>
        <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Export</button>
    </div>

    <article class="overflow-x-auto rounded-xl border border-slate-300 bg-white shadow-sm">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-[#24358a]">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Department</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Last Login</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-[#24358a]">{{ $user['name'] }}</p>
                            <p class="text-xs text-slate-500">{{ $user['email'] }}</p>
                        </td>
                        <td class="px-4 py-4">{{ $user['role'] }}</td>
                        <td class="px-4 py-4">{{ $user['department'] }}</td>
                        <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $user['status'] }}</span></td>
                        <td class="px-4 py-4">{{ $user['last_login'] }}</td>
                        <td class="px-4 py-4">...</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </article>

    <div class="flex items-center justify-between text-xs text-slate-500">
        <p>Showing {{ $users->count() }} of {{ $users->count() }} users</p>
        <div class="flex gap-1">
            <button class="rounded border border-slate-300 px-3 py-1">Previous</button>
            <button class="rounded border border-slate-300 px-3 py-1">1</button>
            <button class="rounded border border-slate-300 px-3 py-1">2</button>
            <button class="rounded border border-slate-300 px-3 py-1">3</button>
            <button class="rounded border border-slate-300 px-3 py-1">4</button>
            <button class="rounded border border-slate-300 px-3 py-1">Next</button>
        </div>
    </div>
@endsection