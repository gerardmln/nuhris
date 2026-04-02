@php
    $isEdit = isset($employee);
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <label for="employee_id" class="mb-1 block text-sm font-semibold text-slate-700">Employee ID *</label>
        <input id="employee_id" name="employee_id" type="text" value="{{ old('employee_id', $employee->employee_id ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
        @error('employee_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Email *</label>
        <input id="email" name="email" type="email" value="{{ old('email', $employee->email ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="first_name" class="mb-1 block text-sm font-semibold text-slate-700">First Name *</label>
        <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $employee->first_name ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
        @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="last_name" class="mb-1 block text-sm font-semibold text-slate-700">Last Name *</label>
        <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $employee->last_name ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
        @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="phone" class="mb-1 block text-sm font-semibold text-slate-700">Phone</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $employee->phone ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="department_id" class="mb-1 block text-sm font-semibold text-slate-700">Department *</label>
        <select id="department_id" name="department_id" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
            <option value="">Select Department</option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="position" class="mb-1 block text-sm font-semibold text-slate-700">Position *</label>
        <input id="position" name="position" type="text" value="{{ old('position', $employee->position ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
        @error('position')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="employment_type" class="mb-1 block text-sm font-semibold text-slate-700">Employment Type</label>
        <input id="employment_type" name="employment_type" type="text" value="{{ old('employment_type', $employee->employment_type ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('employment_type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="ranking" class="mb-1 block text-sm font-semibold text-slate-700">Ranking</label>
        <input id="ranking" name="ranking" type="text" value="{{ old('ranking', $employee->ranking ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('ranking')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="status" class="mb-1 block text-sm font-semibold text-slate-700">Status *</label>
        <select id="status" name="status" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none" required>
            <option value="active" @selected(old('status', $employee->status ?? 'active') === 'active')>Active</option>
            <option value="on_leave" @selected(old('status', $employee->status ?? '') === 'on_leave')>On Leave</option>
            <option value="resigned" @selected(old('status', $employee->status ?? '') === 'resigned')>Resigned</option>
            <option value="terminated" @selected(old('status', $employee->status ?? '') === 'terminated')>Terminated</option>
        </select>
        @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="hire_date" class="mb-1 block text-sm font-semibold text-slate-700">Hire Date</label>
        <input id="hire_date" name="hire_date" type="date" value="{{ old('hire_date', isset($employee->hire_date) ? $employee->hire_date?->format('Y-m-d') : '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('hire_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="official_time_in" class="mb-1 block text-sm font-semibold text-slate-700">Official Time In</label>
        <input id="official_time_in" name="official_time_in" type="time" value="{{ old('official_time_in', isset($employee->official_time_in) ? $employee->official_time_in?->format('H:i') : '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('official_time_in')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="official_time_out" class="mb-1 block text-sm font-semibold text-slate-700">Official Time Out</label>
        <input id="official_time_out" name="official_time_out" type="time" value="{{ old('official_time_out', isset($employee->official_time_out) ? $employee->official_time_out?->format('H:i') : '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('official_time_out')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="resume_last_updated_at" class="mb-1 block text-sm font-semibold text-slate-700">Resume Last Updated</label>
        <input id="resume_last_updated_at" name="resume_last_updated_at" type="date" value="{{ old('resume_last_updated_at', isset($employee->resume_last_updated_at) ? $employee->resume_last_updated_at?->format('Y-m-d') : '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-blue-400 focus:outline-none">
        @error('resume_last_updated_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('employees.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
    <button type="submit" class="rounded-md bg-[#00386f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002f5d]">
        {{ $isEdit ? 'Update Employee' : 'Create Employee' }}
    </button>
</div>
