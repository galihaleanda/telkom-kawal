@extends('layouts.app')

@section('content')

{{-- Breadcrumb --}}
<x-common.page-breadcrumb pageTitle="Edit User" />

{{-- Validation Error Toast --}}
@if ($errors->any())
    <x-ui.toast variant="error" title="Validasi Gagal">
        <ul class="mt-1 space-y-0.5 text-xs text-gray-500 dark:text-gray-400 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.toast>
@endif

{{-- Form Card --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Edit User</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui data user <strong class="text-gray-700 dark:text-gray-200">{{ $user->name }}</strong>.</p>
            </div>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" id="form-edit-user">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Nama Lengkap --}}
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Lengkap
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a4.167 4.167 0 1 0 0 8.333A4.167 4.167 0 0 0 10 2.5ZM7.083 6.667a2.917 2.917 0 1 1 5.834 0 2.917 2.917 0 0 1-5.834 0ZM10 12.5c-3.315 0-6.25 1.756-6.25 3.75v.417a.625.625 0 1 0 1.25 0V16.25c0-.983 2.13-2.5 5-2.5s5 1.517 5 2.5v.417a.625.625 0 1 0 1.25 0V16.25c0-1.994-2.935-3.75-6.25-3.75Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Contoh: Budi Santoso"
                            autocomplete="off"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:text-white/90 dark:placeholder:text-white/30
                                {{ $errors->has('name') ? 'border-error-300 dark:border-error-700' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                        />
                    </div>
                    @error('name')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Email
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 5a1.5 1.5 0 0 1 1.5-1.5h12A1.5 1.5 0 0 1 17.5 5v10a1.5 1.5 0 0 1-1.5 1.5H4A1.5 1.5 0 0 1 2.5 15V5Zm1.5-.25a.25.25 0 0 0-.25.25v.612l6.25 4.375 6.25-4.375V5a.25.25 0 0 0-.25-.25H4ZM16.25 7.238l-5.778 4.045a.75.75 0 0 1-.944 0L3.75 7.238V15c0 .138.112.25.25.25h12a.25.25 0 0 0 .25-.25V7.238Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="contoh@telkom.co.id"
                            autocomplete="off"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:text-white/90 dark:placeholder:text-white/30
                                {{ $errors->has('email') ? 'border-error-300 dark:border-error-700' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                        />
                    </div>
                    @error('email')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- NIK --}}
                <div class="flex flex-col gap-1.5">
                    <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        NIK
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.167 3.75A1.667 1.667 0 0 0 2.5 5.417v9.166A1.667 1.667 0 0 0 4.167 16.25h11.666A1.667 1.667 0 0 0 17.5 14.583V5.417A1.667 1.667 0 0 0 15.833 3.75H4.167Zm-2.917 1.667A2.917 2.917 0 0 1 4.167 2.5h11.666A2.917 2.917 0 0 1 18.75 5.417v9.166a2.917 2.917 0 0 1-2.917 2.917H4.167a2.917 2.917 0 0 1-2.917-2.917V5.417ZM5.833 8.125a.625.625 0 0 1 .625-.625h1.875a.625.625 0 1 1 0 1.25H6.458a.625.625 0 0 1-.625-.625Zm0 3.75a.625.625 0 0 1 .625-.625h6.25a.625.625 0 1 1 0 1.25h-6.25a.625.625 0 0 1-.625-.625Zm6.667-3.75a.625.625 0 0 1 .625-.625h.833a.625.625 0 1 1 0 1.25h-.833a.625.625 0 0 1-.625-.625Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            value="{{ old('nik', $user->nik) }}"
                            placeholder="6 digit NIK"
                            maxlength="10"
                            autocomplete="off"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:text-white/90 dark:placeholder:text-white/30
                                {{ $errors->has('nik') ? 'border-error-300 dark:border-error-700' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                        />
                    </div>
                    @error('nik')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Posisi --}}
                <div class="flex flex-col gap-1.5">
                    <label for="posisi" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Posisi / Jabatan
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.875 2.5A1.875 1.875 0 0 0 5 4.375v.625H3.75A2.5 2.5 0 0 0 1.25 7.5v8.75a2.5 2.5 0 0 0 2.5 2.5h12.5a2.5 2.5 0 0 0 2.5-2.5V7.5a2.5 2.5 0 0 0-2.5-2.5H15V4.375A1.875 1.875 0 0 0 13.125 2.5h-6.25ZM15 6.25h1.25a1.25 1.25 0 0 1 1.25 1.25v2.5H2.5V7.5a1.25 1.25 0 0 1 1.25-1.25H5v.625a.625.625 0 1 0 1.25 0V6.25h7.5v.625a.625.625 0 1 0 1.25 0V6.25Zm2.5 5H2.5v5a1.25 1.25 0 0 0 1.25 1.25h12.5A1.25 1.25 0 0 0 17.5 16.25v-5ZM6.25 4.375A.625.625 0 0 1 6.875 3.75h6.25a.625.625 0 0 1 .625.625V5h-7.5v-.625Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="posisi"
                            name="posisi"
                            value="{{ old('posisi', $user->posisi) }}"
                            placeholder="Contoh: Staff IT, Manager"
                            autocomplete="off"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent pl-10 pr-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:text-white/90 dark:placeholder:text-white/30
                                {{ $errors->has('posisi') ? 'border-error-300 dark:border-error-700' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                        />
                    </div>
                    @error('posisi')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="flex flex-col gap-1.5" x-data="{ selected: '{{ old('jenis_kelamin', $user->jenis_kelamin) }}' }">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Jenis Kelamin
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="jenis_kelamin"
                            name="jenis_kelamin"
                            x-model="selected"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm focus:ring-3 focus:outline-hidden dark:placeholder:text-white/30
                                {{ $errors->has('jenis_kelamin') ? 'border-error-300 dark:border-error-700 text-gray-800 dark:text-white/90' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                            :class="selected ? 'text-gray-800 dark:text-white/90' : 'text-gray-400 dark:text-gray-500'"
                        >
                            <option value="" disabled>Pilih jenis kelamin</option>
                            <option value="Pria" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.792 7.396 10 12.604l5.208-5.208" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('jenis_kelamin')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1.5" x-data="{ selected: '{{ old('role', $user->role) }}' }">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Role
                        <span class="text-error-500 ml-0.5">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="role"
                            name="role"
                            x-model="selected"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm focus:ring-3 focus:outline-hidden dark:placeholder:text-white/30
                                {{ $errors->has('role') ? 'border-error-300 dark:border-error-700 text-gray-800 dark:text-white/90' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                            :class="selected ? 'text-gray-800 dark:text-white/90' : 'text-gray-400 dark:text-gray-500'"
                        >
                            <option value="" disabled>Pilih role</option>
                            <option value="admin" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="viewer" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>Viewer</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.792 7.396 10 12.604l5.208-5.208" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @error('role')
                        <p class="flex items-center gap-1 text-xs text-error-500">
                            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10 2.5a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15ZM1.25 10a8.75 8.75 0 1 1 17.5 0 8.75 8.75 0 0 1-17.5 0Zm8.75-3.125a.625.625 0 0 1 .625.625v3.75a.625.625 0 1 1-1.25 0V7.5a.625.625 0 0 1 .625-.625Zm0 7.5a.938.938 0 1 0 0-1.875.938.938 0 0 0 0 1.875Z" fill="currentColor"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>{{-- end grid --}}

            {{-- Divider --}}
            <div class="my-6 border-t border-gray-100 dark:border-gray-800"></div>

            {{-- Action Buttons --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('users.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-200"
                >
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.604 4.792 7.396 10l5.208 5.208" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Batal
                </a>
                <button
                    type="submit"
                    form="form-edit-user"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 active:bg-brand-700 transition-colors duration-200 disabled:opacity-60"
                >
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.707 5.293a1 1 0 0 1 0 1.414l-8 8a1 1 0 0 1-1.414 0l-4-4a1 1 0 0 1 1.414-1.414L8 12.586l7.293-7.293a1 1 0 0 1 1.414 0Z" fill="currentColor"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
