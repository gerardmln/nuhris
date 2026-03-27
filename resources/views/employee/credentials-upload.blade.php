@extends('employee.layout')

@section('title', 'Upload Credential')
@section('page_title', 'Credentials')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-600">Upload and manage your credentials. HR will review and verify submissions.</p>
        <a href="{{ route('employee.credentials') }}" class="rounded-xl bg-[#242b34] px-5 py-2 text-sm font-semibold text-white hover:bg-[#1b222b]">Cancel</a>
    </div>

    <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
        <h2 class="text-3xl font-bold text-slate-900">Profile Information</h2>

        <form class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-3" method="POST" action="#">
            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Credential Type</label>
                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option>Select type</option>
                    <option>Resume</option>
                    <option>PRC License</option>
                    <option>Seminar / Training</option>
                    <option>Academic Degree</option>
                    <option>Ranking File</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Title</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="e.g., PRC License 2025">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Department</label>
                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option>Select department</option>
                    <option>Faculty</option>
                    <option>Security</option>
                    <option>ASP</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Expiration Date</label>
                <input type="date" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Additional details">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">File Upload</label>
                <label class="block cursor-pointer rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3 py-5 text-center text-sm text-slate-500 hover:bg-slate-100">
                    Click to upload (PDF, Image, DOC)
                    <input type="file" class="hidden">
                </label>
            </div>

            <div class="lg:col-span-3">
                <button type="submit" class="float-right rounded-xl bg-[#003a78] px-6 py-2 text-sm font-semibold text-white hover:bg-[#002f61]">Submit Credential</button>
            </div>
        </form>
    </article>
@endsection