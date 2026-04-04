@extends('employee.layout')

@section('title', 'Account')
@section('page_title', 'Account')

@section('content')
    @if (session('success'))
        <div class="rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    <article class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-sm">
        <div class="h-20 bg-[#003a78]"></div>
        <div class="flex flex-wrap items-end gap-4 px-6 pb-6">
            <div class="-mt-10 grid h-24 w-24 place-content-center rounded-2xl border-4 border-white bg-slate-200 text-2xl font-bold text-slate-700">{{ str(auth()->user()->name)->explode(' ')->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->join('') }}</div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ auth()->user()->name }}</p>
                <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </article>

    <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
        <h2 class="text-3xl font-bold text-slate-900">Profile Information</h2>

        <form class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3" method="POST" action="{{ route('employee.account.update') }}">
            @csrf

            <input type="hidden" name="name" value="{{ auth()->user()->name }}">

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Employee Type</label>
                <select name="employee_type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Select type</option>
                    @foreach ($employeeTypes as $type)
                        <option value="{{ $type }}" @selected($employee && str_contains(strtolower($employee->employment_type ?? ''), strtolower($type)))>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Employee ID</label>
                <input name="employee_id" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" value="{{ $employee->employee_id ?? '' }}" placeholder="e.g., NU-2025-001">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Department</label>
                <select name="department_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Select department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(($employee->department_id ?? null) === $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Phone</label>
                <input name="phone" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" value="{{ $employee->phone ?? '' }}" placeholder="e.g., 09171234567">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Position</label>
                <input name="position" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" value="{{ $employee->position ?? '' }}" placeholder="e.g., Instructor I">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Date Hired</label>
                <input name="hire_date" type="date" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" value="{{ optional($employee?->hire_date)->format('Y-m-d') }}">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
                <input name="address" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" value="{{ $employee->address ?? '' }}" placeholder="Home address">
            </div>

            <div class="lg:col-span-3">
                <button type="submit" class="float-right rounded-xl bg-[#003a78] px-6 py-2 text-sm font-semibold text-white hover:bg-[#002f61]">Save Changes</button>
            </div>
        </form>
    </article>
@endsection