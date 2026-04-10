{{-- 
    Shared Delete Confirmation Modal
    Usage: @include('master-data._partials.delete-modal', ['route' => 'witels'])
    The delete button must dispatch: $dispatch('open-delete-modal', { id: X, name: 'Y' })
--}}
<div
    x-data="{
        open: false,
        itemId: null,
        itemName: '',
        deleteRoute: '{{ $route }}',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.itemId   = e.detail.id;
                this.itemName = e.detail.name;
                this.open     = true;
            });
        }
    }"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[99999] flex items-center justify-center p-4"
>
    <div @click="open = false"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <div @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-900">

        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" class="text-red-500">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/>
            </svg>
        </div>

        <h3 class="mb-1 text-center text-base font-semibold text-gray-800 dark:text-white/90">Konfirmasi Hapus</h3>
        <p class="mb-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Yakin ingin menghapus <strong x-text="itemName" class="text-gray-700 dark:text-gray-200"></strong>?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex gap-3">
            <button @click="open = false"
                    class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                Batal
            </button>
            <form :action="'/' + deleteRoute + '/' + itemId" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-600 active:bg-red-700 transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
