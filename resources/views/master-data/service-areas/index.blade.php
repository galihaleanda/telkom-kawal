@extends('layouts.app')
@section('content')
<x-common.page-breadcrumb pageTitle="Service Area" />
@if (session('success'))
    <x-ui.toast variant="success" title="Berhasil!" message="{{ session('success') }}" />
@endif
@if (session('error'))
    <x-ui.toast variant="error" title="Gagal!" message="{{ session('error') }}" />
@endif
@if ($errors->any())
    <x-ui.toast variant="error" title="Validasi Gagal">
        <ul class="mt-1 space-y-0.5 text-xs list-disc list-inside text-gray-500 dark:text-gray-400">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </x-ui.toast>
@endif

<div class="mb-4 flex items-center justify-between">
    <div></div>
    <a href="{{ route('service-areas.create') }}"><x-ui.button size="xs" variant="primary">+ Tambah Service Area</x-ui.button></a>
</div>

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-5 py-3 text-left sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">#</p></th>
                    <th class="px-5 py-3 text-left sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">SA Code</p></th>
                    <th class="px-5 py-3 text-left sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Service Area</p></th>
                    <th class="px-5 py-3 text-left sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Datel</p></th>
                    <th class="px-5 py-3 text-left sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Branch</p></th>
                    <th class="px-5 py-3 text-center sm:px-6"><p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p></th>
                </tr>
            </thead>
            <tbody>
                @forelse($serviceAreas as $sa)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4 sm:px-6"><p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $serviceAreas->firstItem() + $loop->index }}</p></td>
                        <td class="px-5 py-4 sm:px-6">
                            @if($sa->sa_code)
                                <span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-theme-xs font-mono font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ $sa->sa_code }}</span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 sm:px-6"><p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">{{ $sa->name }}</p></td>
                        <td class="px-5 py-4 sm:px-6"><span class="inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-theme-xs font-medium text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">{{ $sa->datel?->name ?? '-' }}</span></td>
                        <td class="px-5 py-4 sm:px-6"><span class="inline-flex rounded-full bg-purple-50 px-2 py-0.5 text-theme-xs font-medium text-purple-700 dark:bg-purple-500/15 dark:text-purple-400">{{ $sa->datel?->branch?->name ?? '-' }}</span></td>
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('service-areas.edit', $sa) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-100 transition-colors dark:border-blue-500/30 dark:bg-blue-500/10 dark:text-blue-400">
                                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 1 1 2.828 2.828l-.793.793-2.828-2.828.793-.793ZM11.379 5.793 3 14.172V17h2.828l8.38-8.379-2.83-2.828Z"/></svg>Edit
                                </a>
                                <button type="button" @click="$dispatch('open-delete-modal', { id: {{ $sa->id }}, name: '{{ addslashes($sa->name) }}' })"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 transition-colors dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-400">
                                    <svg width="13" height="13" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.75 1.25a.625.625 0 0 0-.625.625v.625H4.375a.625.625 0 1 0 0 1.25h.677l.698 11.17A1.875 1.875 0 0 0 7.623 16.875h4.754a1.875 1.875 0 0 0 1.873-1.955l.698-11.17h.677a.625.625 0 1 0 0-1.25H11.875V1.875A.625.625 0 0 0 11.25 1.25h-2.5Zm-.625 1.875V1.875h3.75V3.125H8.125ZM6.302 4.375H13.698l-.69 11.044a.625.625 0 0 1-.624.581H7.616a.625.625 0 0 1-.624-.581L6.302 4.375ZM8.125 7.5a.625.625 0 0 1 .625.625v5a.625.625 0 1 1-1.25 0v-5a.625.625 0 0 1 .625-.625Zm3.75 0a.625.625 0 0 1 .625.625v5a.625.625 0 1 1-1.25 0v-5a.625.625 0 0 1 .625-.625Z"/></svg>Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-sm text-gray-400 dark:text-gray-500">Belum ada data Service Area.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($serviceAreas->hasPages())
    <div class="border-t border-gray-100 dark:border-gray-800 px-5 py-3">{{ $serviceAreas->links() }}</div>
    @endif
</div>

@include('master-data._partials.delete-modal', ['route' => 'service-areas'])
@endsection
