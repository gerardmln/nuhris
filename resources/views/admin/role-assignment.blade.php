@extends('admin.layout')

@section('title', 'Role Assignment')
@section('page_title', 'Role Assignment')
@section('page_subtitle', 'Modify the user assigned roles')

@section('content')
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            ['Administrator', 'Full system access'],
            ['HR Personnel', 'HR records and compliance'],
            ['Faculty', 'Own records and leave'],
            ['ASP', 'Own records and leave'],
            ['Security', 'Own records and DTR'],
        ] as $role)
            <article class="rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
                <p class="font-semibold text-[#24358a]">{{ $role[0] }}</p>
                <p class="text-xs text-slate-500">{{ $role[1] }}</p>
            </article>
        @endforeach
    </div>

    <article class="space-y-4 rounded-xl border border-slate-300 bg-white p-4 shadow-sm">
        <h3 class="text-3xl font-bold text-[#24358a]">Assign User Roles</h3>
        <input type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-80" placeholder="Search for user by name or email...">

        <div class="space-y-2">
            @foreach ([['MS', 'Maria Santos', 'maria.santos@nu.edu.ph', 'Faculty'], ['JD', 'Juan Dela Cruz', 'juan.delacruz@nu.edu.ph', 'Faculty'], ['AR', 'Ana Reyes', 'ana.reyes@nu.edu.ph', 'Faculty'], ['CG', 'Carlos Garcia', 'carlos.garcia@nu.edu.ph', 'Faculty'], ['LM', 'Lisa Mendoza', 'lisa.mendoza@nu.edu.ph', 'HR Personnel']] as $u)
                <div class="flex items-center justify-between rounded-xl bg-[#cfe1f5] px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#083b72] text-xs font-semibold text-white">{{ $u[0] }}</span>
                        <div>
                            <p class="font-semibold text-[#24358a]">{{ $u[1] }}</p>
                            <p class="text-xs text-slate-500">{{ $u[2] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">{{ $u[3] }}</span>
                        <button class="assign-role-btn rounded-lg border border-blue-300 bg-white px-3 py-1 text-xs font-semibold text-blue-700" data-user="{{ $u[1] }}">Change Role</button>
                    </div>
                </div>
            @endforeach
        </div>
    </article>

    <div id="role-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 p-4">
        <div class="w-full max-w-2xl rounded-2xl border border-slate-300 bg-white p-5 shadow-xl">
            <div class="mb-3 flex items-start justify-between gap-4">
                <div>
                    <h4 class="text-4xl font-bold text-[#24358a]">Assign Role</h4>
                    <p class="text-sm text-slate-500">Change the role for <span id="modal-user">Maria Santos</span></p>
                </div>
                <button id="close-role-modal" class="text-2xl">x</button>
            </div>

            <div class="space-y-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                @foreach (['Administrator', 'HR Personnel', 'Faculty', 'ASP', 'Security'] as $r)
                    <label class="flex cursor-pointer items-start gap-3">
                        <input type="radio" name="assign_role" value="{{ $r }}" class="mt-1" @checked($r === 'Faculty')>
                        <span>
                            <span class="block font-semibold">{{ $r }}</span>
                            <span class="block text-sm text-slate-500">Role access configuration for {{ $r }}.</span>
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="mt-4 rounded-lg border border-amber-300 bg-amber-50 p-3 text-sm text-amber-800">
                Changing a user's role will update permissions. The user may need to log out and log back in.
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button id="cancel-role-modal" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Cancel</button>
                <button id="save-role-modal" class="rounded-lg bg-[#083b72] px-4 py-2 text-sm font-semibold text-white">Save Changes</button>
            </div>
        </div>
    </div>

    <div id="success-toast" class="fixed right-4 top-4 z-50 hidden rounded-xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-900 shadow-lg">
        Assigned Role Completely!
    </div>
@endsection

@push('scripts')
    <script>
        (() => {
            const modal = document.getElementById('role-modal');
            const modalUser = document.getElementById('modal-user');
            const toast = document.getElementById('success-toast');

            document.querySelectorAll('.assign-role-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    modalUser.textContent = button.dataset.user;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            document.getElementById('close-role-modal').addEventListener('click', closeModal);
            document.getElementById('cancel-role-modal').addEventListener('click', closeModal);

            document.getElementById('save-role-modal').addEventListener('click', () => {
                closeModal();
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 1700);
            });
        })();
    </script>
@endpush