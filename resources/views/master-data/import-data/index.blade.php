@extends('layouts.app')
@section('content')

<x-common.page-breadcrumb pageTitle="Import Data" />

{{-- Toast --}}
@if (session('success'))
    <x-ui.toast variant="success" title="Import Berhasil!">
        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 leading-relaxed">{{ session('success') }}</p>
    </x-ui.toast>
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

{{-- ===== STATISTIK RINGKASAN ===== --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    @php
        $statItems = [
            ['label' => 'Witel',        'count' => $stats['witel'],        'color' => 'violet',  'href' => route('witels.index'),        'icon' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21'],
            ['label' => 'Branch',       'count' => $stats['branch'],       'color' => 'blue',    'href' => route('branches.index'),      'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z'],
            ['label' => 'Datel',        'count' => $stats['datel'],        'color' => 'cyan',    'href' => route('datels.index'),        'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z'],
            ['label' => 'Service Area', 'count' => $stats['service_area'], 'color' => 'emerald', 'href' => route('service-areas.index'), 'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0z'],
            ['label' => 'PIC',          'count' => $stats['pic'],          'color' => 'indigo',  'href' => route('pics.index'),          'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
            ['label' => 'Sektor',       'count' => $stats['sektor'],       'color' => 'amber',   'href' => route('sektors.index'),       'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25zM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25z'],
            ['label' => 'STO',          'count' => $stats['sto'],          'color' => 'rose',    'href' => route('stos.index'),          'icon' => 'M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0z'],
        ];
        $colorMap = [
            'violet'  => ['bg' => 'bg-violet-50 dark:bg-violet-500/10',  'icon' => 'text-violet-600 dark:text-violet-400',  'num' => 'text-violet-700 dark:text-violet-300'],
            'blue'    => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',      'icon' => 'text-blue-600 dark:text-blue-400',      'num' => 'text-blue-700 dark:text-blue-300'],
            'cyan'    => ['bg' => 'bg-cyan-50 dark:bg-cyan-500/10',      'icon' => 'text-cyan-600 dark:text-cyan-400',      'num' => 'text-cyan-700 dark:text-cyan-300'],
            'emerald' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10','icon' => 'text-emerald-600 dark:text-emerald-400','num' => 'text-emerald-700 dark:text-emerald-300'],
            'indigo'  => ['bg' => 'bg-indigo-50 dark:bg-indigo-500/10',  'icon' => 'text-indigo-600 dark:text-indigo-400',  'num' => 'text-indigo-700 dark:text-indigo-300'],
            'amber'   => ['bg' => 'bg-amber-50 dark:bg-amber-500/10',    'icon' => 'text-amber-600 dark:text-amber-400',    'num' => 'text-amber-700 dark:text-amber-300'],
            'rose'    => ['bg' => 'bg-rose-50 dark:bg-rose-500/10',      'icon' => 'text-rose-600 dark:text-rose-400',      'num' => 'text-rose-700 dark:text-rose-300'],
        ];
    @endphp

    @foreach($statItems as $item)
        @php $c = $colorMap[$item['color']]; @endphp
        <a href="{{ $item['href'] }}"
           class="group flex flex-col gap-2 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-4 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg {{ $c['bg'] }}">
                    <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                </div>
                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold {{ $c['num'] }}">{{ number_format($item['count']) }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $item['label'] }}</p>
            </div>
        </a>
    @endforeach
</div>

{{-- ===== MAIN CONTENT: IMPORT + INFO ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- ===== LEFT: UPLOAD AREA (3/5) ===== --}}
    <div class="lg:col-span-3 flex flex-col gap-5">

        {{-- Upload Card --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] overflow-hidden"
            x-data="{
                isDragging: false,
                fileName: null,
                fileSize: null,
                isLoading: false,
                handleDrop(e) {
                    this.isDragging = false;
                    const file = e.dataTransfer.files[0];
                    if (file && this.setFile(file)) {
                        // Assign file ke input secara programmatik (DataTransfer API)
                        // agar file ikut ter-submit saat form dikirim
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        this.$refs.fileInput.files = dt.files;
                    }
                },
                handleChange(e) {
                    const file = e.target.files[0];
                    if (file) this.setFile(file);
                },
                setFile(file) {
                    if (!file.name.match(/\.(xlsx|xls|csv)$/i)) {
                        alert('Format tidak valid. Gunakan .xlsx, .xls, atau .csv');
                        return false;
                    }
                    this.fileName = file.name;
                    this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
                    return true;
                },
                clearFile() {
                    this.fileName = null;
                    this.fileSize = null;
                    this.$refs.fileInput.value = '';
                },
                handleSubmit(e) {
                    if (!this.$refs.fileInput.files || this.$refs.fileInput.files.length === 0) {
                        e.preventDefault();
                        alert('Pilih file Excel terlebih dahulu.');
                        return;
                    }
                    this.isLoading = true;
                }
            }"
        >
            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-500/5 dark:to-teal-500/5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Import Data Wilayah</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">1 file Excel → mengisi Witel, Branch, Datel, Service Area, Sektor & STO sekaligus</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <form
                    method="POST"
                    action="{{ route('import-data.import') }}"
                    enctype="multipart/form-data"
                    @submit="handleSubmit($event)"
                >
                    @csrf
                    <input x-ref="fileInput" type="file" name="file" accept=".xlsx,.xls,.csv" class="hidden" @change="handleChange($event)" />

                    {{-- Dropzone --}}
                    <div
                        @drop.prevent="handleDrop($event)"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @click="if (!fileName) $refs.fileInput.click()"
                        :class="isDragging
                            ? 'border-emerald-400 bg-emerald-50 dark:border-emerald-400 dark:bg-emerald-500/10 scale-[1.01]'
                            : fileName
                                ? 'border-emerald-300 bg-emerald-50/40 dark:border-emerald-500/40 dark:bg-emerald-500/5 cursor-default'
                                : 'border-gray-200 bg-gray-50/50 dark:border-gray-700 dark:bg-gray-800/30 cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/30 dark:hover:border-emerald-500/30 dark:hover:bg-emerald-500/5'"
                        class="rounded-xl border-2 border-dashed p-8 transition-all duration-200"
                    >
                        {{-- Empty state --}}
                        <div x-show="!fileName" class="flex flex-col items-center text-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
                                <span x-show="!isDragging">Drag & Drop file Excel di sini</span>
                                <span x-show="isDragging" x-cloak class="text-emerald-600 dark:text-emerald-400">Lepas file di sini...</span>
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mb-3">atau klik untuk browse file</p>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="rounded-md bg-gray-100 dark:bg-gray-800 px-2 py-0.5 font-mono">.xlsx</span>
                                <span class="rounded-md bg-gray-100 dark:bg-gray-800 px-2 py-0.5 font-mono">.xls</span>
                                <span class="rounded-md bg-gray-100 dark:bg-gray-800 px-2 py-0.5 font-mono">.csv</span>
                                <span class="text-gray-300 dark:text-gray-600">·</span>
                                <span>maks 20 MB</span>
                            </div>
                        </div>

                        {{-- File selected state --}}
                        <div x-show="fileName" x-cloak class="flex items-center gap-4">
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
                                <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate" x-text="fileName"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="fileSize"></p>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    File siap diimport
                                </p>
                            </div>
                            <button type="button" @click.stop="clearFile()"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        :disabled="!fileName || isLoading"
                        :class="(fileName && !isLoading)
                            ? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg shadow-emerald-500/20 cursor-pointer'
                            : 'bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 cursor-not-allowed'"
                        class="mt-4 w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-200"
                    >
                        <template x-if="!isLoading">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                        </template>
                        <template x-if="isLoading">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </template>
                        <span x-text="isLoading ? 'Sedang memproses...' : 'Upload & Import Semua Data'"></span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Apa yang akan diisi --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Data yang akan diisi otomatis
            </h4>
            @php
                $fills = [
                    ['num'=>'1','label'=>'Witel',       'col'=>'Witel',              'color'=>'violet'],
                    ['num'=>'2','label'=>'Branch',      'col'=>'BRANCH',             'color'=>'blue'],
                    ['num'=>'3','label'=>'Datel',       'col'=>'DATEL',              'color'=>'cyan'],
                    ['num'=>'4','label'=>'Service Area','col'=>'SERVICE AREA, SA Code','color'=>'emerald'],
                    ['num'=>'5','label'=>'PIC',         'col'=>'HSA (nama PIC)',      'color'=>'indigo'],
                    ['num'=>'6','label'=>'Sektor',      'col'=>'SEKTOR',             'color'=>'amber'],
                    ['num'=>'7','label'=>'STO',         'col'=>'STO, STO Full',      'color'=>'rose'],
                ];
                $fillColors = [
                    'violet'  => ['dot'=>'bg-violet-500',  'badge'=>'bg-violet-50 text-violet-700 dark:bg-violet-500/15 dark:text-violet-300'],
                    'blue'    => ['dot'=>'bg-blue-500',    'badge'=>'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300'],
                    'cyan'    => ['dot'=>'bg-cyan-500',    'badge'=>'bg-cyan-50 text-cyan-700 dark:bg-cyan-500/15 dark:text-cyan-300'],
                    'emerald' => ['dot'=>'bg-emerald-500', 'badge'=>'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300'],
                    'indigo'  => ['dot'=>'bg-indigo-500',  'badge'=>'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300'],
                    'amber'   => ['dot'=>'bg-amber-500',   'badge'=>'bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300'],
                    'rose'    => ['dot'=>'bg-rose-500',    'badge'=>'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300'],
                ];
            @endphp
            <div class="space-y-2.5">
                @foreach($fills as $f)
                    @php $fc = $fillColors[$f['color']]; @endphp
                    <div class="flex items-center gap-3">
                        <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full text-white text-[10px] font-bold {{ $fc['dot'] }}">{{ $f['num'] }}</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-24">{{ $f['label'] }}</span>
                        <span class="flex-1 border-t border-dashed border-gray-200 dark:border-gray-700"></span>
                        <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-mono font-medium {{ $fc['badge'] }}">{{ $f['col'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== RIGHT: INFO PANEL (2/5) ===== --}}
    <div class="lg:col-span-2 flex flex-col gap-4">

        {{-- Hierarki --}}
        <div class="rounded-xl border border-blue-100 dark:border-blue-500/20 bg-blue-50/50 dark:bg-blue-500/5 p-5">
            <h4 class="text-sm font-semibold text-blue-700 dark:text-blue-300 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                Hierarki Relasi Data
            </h4>
            <div class="space-y-1">
                @php
                    $hier = [
                        ['Witel', 'violet'],['Branch', 'blue'],['Datel', 'cyan'],
                        ['Service Area', 'emerald'],['Sektor', 'amber'],['STO', 'rose'],
                    ];
                @endphp
                @foreach($hier as $i => [$name, $color])
                    <div class="flex items-center gap-2">
                        @if($i > 0)<div class="ml-3 w-px h-4 bg-blue-200 dark:bg-blue-500/30"></div>@endif
                    </div>
                    <div class="flex items-center gap-2 {{ $i > 0 ? '-mt-2' : '' }}">
                        @if($i > 0)<span class="ml-3 text-blue-300 dark:text-blue-600 text-xs">└</span>@endif
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if($color === 'violet') bg-violet-100 text-violet-700 dark:bg-violet-500/20 dark:text-violet-300
                            @elseif($color === 'blue') bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300
                            @elseif($color === 'cyan') bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300
                            @elseif($color === 'emerald') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300
                            @elseif($color === 'amber') bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300
                            @else bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300
                            @endif">{{ $name }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tips --}}
        <div class="rounded-xl border border-amber-100 dark:border-amber-500/20 bg-amber-50/50 dark:bg-amber-500/5 p-5">
            <h4 class="text-sm font-semibold text-amber-700 dark:text-amber-400 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Tips Import
            </h4>
            <ul class="space-y-2.5 text-xs text-amber-700/80 dark:text-amber-400/80">
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Data duplikat otomatis dilewati. Import aman dilakukan berkali-kali.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Baris 1 wajib berisi nama kolom (header). Data dimulai dari baris ke-2.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Kolom tidak perlu berurutan — sistem mengenali berdasarkan nama header.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    File <code class="bg-amber-100 dark:bg-amber-500/20 px-1 rounded font-mono">data-master.xlsx</code> bisa langsung digunakan.
                </li>
            </ul>
        </div>

        {{-- Format kolom ringkas --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-5">
            <h4 class="text-sm font-semibold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Kolom yang Digunakan
            </h4>
            <div class="flex flex-wrap gap-1.5">
                @foreach(['Witel','BRANCH','DATEL','SERVICE AREA','SA Code','HSA','SEKTOR','STO','STO Full'] as $col)
                    <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-800 px-2.5 py-1 text-xs font-mono font-medium text-gray-700 dark:text-gray-300">{{ $col }}</span>
                @endforeach
            </div>
            <p class="mt-3 text-xs text-gray-400 dark:text-gray-500">Kolom <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded font-mono">HSA</code> = nama PIC Service Area. Kolom lain diabaikan.</p>
        </div>
    </div>
</div>

@endsection
