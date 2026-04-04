@extends('employee.layout')

@section('title', 'Upload Credential')
@section('page_title', 'Credentials')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-600">Upload and manage your credentials. HR will review and verify submissions.</p>
        <a href="{{ route('employee.credentials') }}" class="rounded-xl bg-[#242b34] px-5 py-2 text-sm font-semibold text-white hover:bg-[#1b222b]">Cancel</a>
    </div>

    @if (session('error'))
        <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
        <h2 class="text-3xl font-bold text-slate-900">Profile Information</h2>

        <form class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3" method="POST" action="{{ route('employee.credentials.upload.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Credential Type</label>
                <select name="credential_type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="">Select type</option>
                    <option value="resume">Resume</option>
                    <option value="prc">PRC License</option>
                    <option value="seminars">Seminar / Training</option>
                    <option value="degrees">Academic Degree</option>
                    <option value="ranking">Ranking File</option>
                </select>
                @error('credential_type')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Title</label>
                <input name="title" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., PRC License 2025" required>
                @error('title')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Department</label>
                <select name="department_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="">Select department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected($employee && $employee->department && $employee->department->id === $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Expiration Date</label>
                <input name="expires_at" type="date" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <input name="description" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Additional details">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">File Upload</label>
                <label class="block cursor-pointer rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3 py-5 text-center text-sm text-slate-500 hover:bg-slate-100">
                    Click to upload (PDF, Image, DOC)
                    <input name="credential_file" type="file" class="hidden">
                </label>
                @error('credential_file')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="lg:col-span-3">
                <button type="submit" class="float-right rounded-xl bg-[#003a78] px-6 py-2 text-sm font-semibold text-white hover:bg-[#002f61]">Submit Credential</button>
            </div>
        </form>
    </article>
@endsection