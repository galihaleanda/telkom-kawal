@extends('layouts.app')
@section('content')
<x-common.page-breadcrumb pageTitle="Tambah PIC" />
@if ($errors->any())
    <x-ui.toast variant="error" title="Validasi Gagal">
        <ul class="mt-1 space-y-0.5 text-xs list-disc list-inside text-gray-500 dark:text-gray-400">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </x-ui.toast>
@endif
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Tambah PIC Baru</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Isi data di bawah untuk menambah PIC (Person In Charge).</p>
    </div>
    <div class="p-6">
        <form action="{{ route('pics.store') }}" method="POST" id="form-create">
            @csrf
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Nama PIC <span class="text-error-500 ml-0.5">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso"
                           class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('name') ? 'border-error-300 dark:border-error-700' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}" />
                    @error('name')<p class="text-xs text-error-500">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col gap-1.5" x-data="{ selected: '{{ old('service_area_id') }}' }">
                    <label for="service_area_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Service Area <span class="text-error-500 ml-0.5">*</span></label>
                    <div class="relative">
                        <select id="service_area_id" name="service_area_id" x-model="selected"
                                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border bg-transparent px-4 py-2.5 pr-10 text-sm focus:ring-3 focus:outline-hidden dark:placeholder:text-white/30 {{ $errors->has('service_area_id') ? 'border-error-300 dark:border-error-700 text-gray-800 dark:text-white/90' : 'border-gray-300 dark:border-gray-700 dark:bg-gray-900' }}"
                                :class="selected ? 'text-gray-800 dark:text-white/90' : 'text-gray-400 dark:text-gray-500'">
                            <option value="" disabled>Pilih Service Area</option>
                            @foreach($serviceAreas as $sa)
                                <option value="{{ $sa->id }}" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ old('service_area_id') == $sa->id ? 'selected' : '' }}>
                                    {{ $sa->name }} — {{ $sa->datel?->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-400"><svg width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M4.792 7.396 10 12.604l5.208-5.208" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    </div>
                    @error('service_area_id')<p class="text-xs text-error-500">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="my-6 border-t border-gray-100 dark:border-gray-800"></div>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('pics.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">Batal</a>
                <button type="submit" form="form-create" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
