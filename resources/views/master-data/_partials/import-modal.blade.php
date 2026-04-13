{{--
    Import Modal Partial
    Props:
        - $route    : nama route untuk action import (misal 'witels.import')
        - $entity   : label nama entity (misal 'Witel')
        - $columns  : array string kolom yang diharapkan (misal ['Witel'])
--}}
<div
    x-data="{ showImportModal: false }"
    @keydown.escape.window="showImportModal = false"
>
    {{-- Trigger Button --}}
    <button
        type="button"
        id="btn-import-{{ Str::slug($entity) }}"
        @click="showImportModal = true"
        class="inline-flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 shadow-sm hover:bg-emerald-100 hover:border-emerald-300 transition-all duration-200 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
        </svg>
        Import Excel
    </button>

    {{-- Modal Overlay --}}
    <div
        x-show="showImportModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        x-cloak
        @click.self="showImportModal = false"
    >
        {{-- Modal Card --}}
        <div
            x-show="showImportModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg rounded-2xl bg-white shadow-2xl dark:bg-gray-900 dark:border dark:border-gray-700/50 overflow-hidden"
        >
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500/20">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Import Data {{ $entity }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Upload file Excel (.xlsx / .xls)</p>
                    </div>
                </div>
                <button
                    type="button"
                    @click="showImportModal = false"
                    class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors dark:hover:bg-gray-800 dark:hover:text-gray-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-6 py-5">
                {{-- Info kolom --}}
                <div class="mb-5 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 p-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 mb-1.5">Kolom yang diperlukan:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($columns as $col)
                                    <span class="inline-flex items-center rounded-md bg-blue-100 dark:bg-blue-500/20 px-2.5 py-0.5 text-xs font-mono font-medium text-blue-700 dark:text-blue-300">
                                        {{ $col }}
                                    </span>
                                @endforeach
                            </div>
                            <p class="mt-2 text-xs text-blue-600/70 dark:text-blue-400/70">Baris pertama digunakan sebagai header. Data duplikat akan otomatis dilewati.</p>
                        </div>
                    </div>
                </div>

                {{-- Dropzone Form --}}
                <form
                    method="POST"
                    action="{{ route($route) }}"
                    enctype="multipart/form-data"
                    id="form-import-{{ Str::slug($entity) }}"
                    x-data="{
                        isDragging: false,
                        fileName: null,
                        fileSize: null,
                        handleDrop(e) {
                            this.isDragging = false;
                            const file = e.dataTransfer.files[0];
                            if (file) this.setFile(file);
                        },
                        handleChange(e) {
                            const file = e.target.files[0];
                            if (file) this.setFile(file);
                        },
                        setFile(file) {
                            const allowed = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                             'application/vnd.ms-excel', 'text/csv'];
                            if (!allowed.includes(file.type) && !file.name.match(/\.(xlsx|xls|csv)$/i)) {
                                alert('Format file tidak valid. Gunakan .xlsx, .xls, atau .csv');
                                return;
                            }
                            this.fileName = file.name;
                            this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
                        },
                        clearFile() {
                            this.fileName = null;
                            this.fileSize = null;
                            this.$refs.fileInput.value = '';
                        }
                    }"
                >
                    @csrf

                    {{-- Hidden File Input --}}
                    <input
                        x-ref="fileInput"
                        type="file"
                        name="file"
                        accept=".xlsx,.xls,.csv"
                        class="hidden"
                        @change="handleChange($event)"
                    />

                    {{-- Dropzone Area --}}
                    <div
                        @drop.prevent="handleDrop($event)"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @click="if (!fileName) $refs.fileInput.click()"
                        :class="isDragging
                            ? 'border-emerald-400 bg-emerald-50 dark:border-emerald-500 dark:bg-emerald-500/10'
                            : fileName
                                ? 'border-emerald-300 bg-emerald-50/50 dark:border-emerald-500/40 dark:bg-emerald-500/5'
                                : 'border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50 cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 dark:hover:border-emerald-500/50'"
                        class="rounded-xl border-2 border-dashed p-6 transition-all duration-200"
                    >
                        {{-- Empty State --}}
                        <div x-show="!fileName" class="flex flex-col items-center text-center">
                            <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                <svg class="w-7 h-7 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span x-show="!isDragging">Drag & Drop file Excel di sini</span>
                                <span x-show="isDragging" x-cloak class="text-emerald-600 dark:text-emerald-400">Lepas file di sini...</span>
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">atau klik untuk browse</p>
                            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">.xlsx, .xls, .csv · maks 10 MB</p>
                        </div>

                        {{-- File Selected State --}}
                        <div x-show="fileName" x-cloak class="flex items-center gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
                                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-white truncate" x-text="fileName"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="fileSize"></p>
                            </div>
                            <button
                                type="button"
                                @click.stop="clearFile()"
                                class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors dark:hover:bg-red-500/10"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-4 flex items-center justify-end gap-3">
                        <button
                            type="button"
                            @click="showImportModal = false"
                            class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="!fileName"
                            :class="fileName
                                ? 'bg-emerald-600 hover:bg-emerald-700 text-white cursor-pointer shadow-sm shadow-emerald-500/20'
                                : 'bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600'"
                            class="inline-flex items-center gap-2 rounded-lg px-5 py-2 text-sm font-medium transition-all duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
