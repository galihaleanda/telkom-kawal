@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Users" />

{{-- Flash Success Toast --}}
@if (session('success'))
    <x-ui.toast variant="success" title="Berhasil!" message="{{ session('success') }}" />
@endif

<div class="flex flex-col gap-4 px-4 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

    <!-- KIRI -->
    <a href="{{ route('users.create') }}">
    <x-ui.button size="sm" variant="primary">
        Tambah User
    </x-ui.button>
    </a>

    <!-- KANAN -->
    <div class="flex flex-wrap items-center gap-3">
        
        <select name="role" onchange="this.form.submit()" class="inline-flex items-center gap-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
        </select>

        <button
            type="button"
            onclick="window.location.href='{{ route('users.index') }}'"
            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
        >
            Lihat Semua
        </button>

        <div class="relative">
            <button type="submit" class="absolute -translate-y-1/2 right-4 top-1/2">
                <!-- icon -->
            </button>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-4 pr-4 text-sm xl:w-[300px]" />
        </div>

    </div>

</div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1102px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                User
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                NIK
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Jenis Kelamin
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Posisi
                            </p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Role
                            </p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                Aksi
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="px-5 py-4 sm:px-6" colspan="1">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 overflow-hidden rounded-full">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $user->name }}</span>
                                        <span class="block text-gray-500 text-theme-xs dark:text-gray-400">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->nik }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->jenis_kelamin }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $user->posisi }}</p>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-theme-xs font-medium {{ $user->role === 'admin' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : 'bg-gray-100 text-gray-700 dark:bg-white/5 dark:text-gray-400' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            {{-- Aksi --}}
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex justify-center gap-2">
                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-100 hover:border-blue-300 transition-colors dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-500/20"
                                    >
                                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 1 1 2.828 2.828l-.793.793-2.828-2.828.793-.793ZM11.379 5.793 3 14.172V17h2.828l8.38-8.379-2.83-2.828Z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    {{-- Hapus --}}
                                    <button
                                        type="button"
                                        @click="$dispatch('open-delete-modal', { id: {{ $user->id }}, name: '{{ addslashes($user->name) }}' })"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 hover:border-red-300 transition-colors dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20"
                                    >
                                        <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.75 1.25a.625.625 0 0 0-.625.625v.625H4.375a.625.625 0 1 0 0 1.25h.677l.698 11.17A1.875 1.875 0 0 0 7.623 16.875h4.754a1.875 1.875 0 0 0 1.873-1.955l.698-11.17h.677a.625.625 0 1 0 0-1.25H11.875V1.875A.625.625 0 0 0 11.25 1.25h-2.5Zm-.625 1.875V1.875h3.75V3.125H8.125ZM6.302 4.375H13.698l-.69 11.044a.625.625 0 0 1-.624.581H7.616a.625.625 0 0 1-.624-.581L6.302 4.375ZM8.125 7.5a.625.625 0 0 1 .625.625v5a.625.625 0 1 1-1.25 0v-5a.625.625 0 0 1 .625-.625Zm3.75 0a.625.625 0 0 1 .625.625v5a.625.625 0 1 1-1.25 0v-5a.625.625 0 0 1 .625-.625Z"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

{{-- Modal Konfirmasi Hapus --}}
<div
    x-data="{
        open: false,
        userId: null,
        userName: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.userId = e.detail.id;
                this.userName = e.detail.name;
                this.open = true;
            });
        }
    }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[99999] flex items-center justify-center p-4"
>
    {{-- Backdrop --}}
    <div
        @click="open = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Dialog --}}
    <div
        @click.stop
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900"
    >
        {{-- Ikon warning --}}
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-red-500">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" fill="currentColor" class="text-red-500" />
            </svg>
        </div>

        <h3 class="mb-1 text-center text-base font-semibold text-gray-800 dark:text-white/90">
            Hapus User
        </h3>
        <p class="mb-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Yakin ingin menghapus <strong x-text="userName" class="text-gray-700 dark:text-gray-200"></strong>?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex gap-3">
            <button
                type="button"
                @click="open = false"
                class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                Batal
            </button>

            {{-- Form DELETE --}}
            <form
                :action="'{{ url('users') }}/' + userId"
                method="POST"
                class="flex-1"
            >
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600 active:bg-red-700 transition-colors"
                >
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
