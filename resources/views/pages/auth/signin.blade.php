@extends('layouts.fullscreen-layout')

@section('content')
<div class="relative z-1 min-h-screen flex items-center justify-center bg-[#fafaf8] dark:bg-[#111110] p-6">

    {{-- Card --}}
    <div class="relative w-full max-w-sm rounded-2xl border border-[#e4e2dd] dark:border-[#2a2a28] bg-white dark:bg-[#1c1c1a] p-10 text-center overflow-hidden">

        {{-- Top accent line --}}
        <div class="absolute top-0 left-10 right-10 h-[2px] bg-[#1a1a1a] dark:bg-white rounded-b-sm"></div>


        {{-- Heading --}}
        <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.12em] text-[#999] dark:text-[#555]">Selamat datang</p>
        <h1 class="mb-1.5 font-serif text-[28px] font-normal leading-tight tracking-tight text-[#1a1a1a] dark:text-white">
            Masuk ke akun<br>Anda
        </h1>
        <p class="mb-8 text-sm font-light text-[#aaa] dark:text-[#555]">
            Gunakan akun Google untuk melanjutkan
        </p>

        {{-- Divider --}}
        <div class="mb-8 h-px bg-[#eceae6] dark:bg-[#2a2a28]"></div>

        {{-- Google Button --}}
        <form method="GET" action="{{ url('auth/google') }}" id="googleForm">

    {{-- Turnstile --}}
    <div class="cf-turnstile mb-4"
         data-sitekey="{{ config('services.turnstile.site_key') }}"
         data-callback="onTurnstileSuccess">
    </div>

    {{-- Button --}}
        <button type="submit" id="googleBtn" disabled
        class="group flex w-full items-center justify-center gap-2.5 rounded-xl border border-[#e4e2dd] dark:border-[#2a2a28] bg-white dark:bg-[#242422] px-5 py-3.5 text-sm font-medium text-[#1a1a1a] dark:text-[#e0e0de] transition-all duration-150 hover:bg-[#fafaf8] dark:hover:bg-[#2c2c2a] hover:border-[#c8c6c1] dark:hover:border-[#3a3a38] hover:-translate-y-px">

        <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
            <path d="M18.75 10.19c0-.72-.06-1.25-.19-1.79H10.18v3.25h4.92c-.1.81-.64 2.02-1.83 2.84l2.83 2.14C17.78 15.1 18.75 12.86 18.75 10.19z" fill="#4285F4"/>
            <path d="M10.18 18.75c2.41 0 4.43-.78 5.91-2.12l-2.82-2.13c-.75.52-1.76.88-3.09.88-2.36 0-4.37-1.53-5.08-3.63L2.2 13.84C3.67 16.79 6.69 18.75 10.18 18.75z" fill="#34A853"/>
            <path d="M5.1 11.73a5.54 5.54 0 0 1 0-3.46L2.33 6.07A9.09 9.09 0 0 0 1.25 10c0 1.41.35 2.74.96 3.93L5.1 11.73z" fill="#FBBC05"/>
            <path d="M10.18 4.63c1.68 0 2.81.71 3.46 1.3l2.52-2.41C14.6 2.12 12.59 1.25 10.18 1.25c-3.49 0-6.51 1.96-7.96 4.82L5.1 8.27C5.81 6.15 7.82 4.63 10.18 4.63z" fill="#EB4335"/>
        </svg>

        Lanjutkan dengan Google
        </button>
    </form>

        {{-- Footer --}}
        <p class="mt-8 text-xs font-light leading-relaxed text-[#bbb] dark:text-[#444]">
            Dengan masuk, Anda menyetujui
            <a href="#" class="text-[#888] dark:text-[#666] underline underline-offset-2 hover:text-[#1a1a1a] dark:hover:text-white transition-colors">Syarat Layanan</a>
            dan
            <a href="#" class="text-[#888] dark:text-[#666] underline underline-offset-2 hover:text-[#1a1a1a] dark:hover:text-white transition-colors">Kebijakan Privasi</a> kami.
        </p>
    </div>

    <script>
    function onTurnstileSuccess(token) {
        document.getElementById('googleBtn').disabled = false;
    }

    </script>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

</div>
@endsection