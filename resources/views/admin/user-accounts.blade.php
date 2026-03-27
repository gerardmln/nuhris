@extends('admin.layout')

@section('title', 'User Management')
@section('page_title', 'User Management')
@section('page_subtitle', 'Manage user accounts')

@section('content')
    <div class="flex flex-wrap items-center gap-2">
        <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-72" placeholder="Search by name, email, or ID...">
        <select class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option>All Roles</option>
            <option>Admin</option>
            <option>HR Personnel</option>
            <option>Faculty</option>
            <option>ASP</option>
            <option>Security</option>
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
                @foreach ([
                    ['Maria Santos', 'Faculty', 'College of Computing', 'Active', 'Feb 15, 2026 9:30 AM'],
                    ['Juan Dela Cruz', 'Faculty', 'College of Engineering', 'Active', 'Feb 15, 2026 8:45 AM'],
                    ['Ana Reyes', 'Faculty', 'College of Business', 'Active', 'Feb 14, 2026 4:20 PM'],
                    ['Carlos Garcia', 'Faculty', 'College of Education', 'Active', 'Feb 15, 2026 7:00 AM'],
                    ['Lisa Mendoza', 'HR Personnel', 'Human Resources', 'Active', 'Feb 10, 2026 1:30 AM'],
                ] as $user)
                    <tr>
                        <td class="px-4 py-4 font-semibold text-[#24358a]">{{ $user[0] }}</td>
                        <td class="px-4 py-4">{{ $user[1] }}</td>
                        <td class="px-4 py-4">{{ $user[2] }}</td>
                        <td class="px-4 py-4"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $user[3] }}</span></td>
                        <td class="px-4 py-4">{{ $user[4] }}</td>
                        <td class="px-4 py-4">...</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </article>

    <div class="flex items-center justify-between text-xs text-slate-500">
        <p>Showing 5 of 5 users</p>
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