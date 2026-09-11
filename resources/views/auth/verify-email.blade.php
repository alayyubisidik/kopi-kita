<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Verifikasi Email – Kopi Kita</title>
    <meta name="description" content="Verifikasi alamat email akun Kopi Kita Anda.">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { min-height: max(884px, 100dvh); background-color: #fff8f5; }
        ::-webkit-scrollbar { display: none; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; display: inline-block; }
        .warm-glow {
            position: absolute; top: -1.5rem; left: 50%; transform: translateX(-50%);
            width: 16rem; height: 16rem; background: rgba(254, 207, 157, 0.3);
            border-radius: 9999px; filter: blur(48px); pointer-events: none; z-index: 0;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-sans text-body-md flex flex-col min-h-screen antialiased">

    <main class="flex flex-col relative w-full max-w-max-mobile-width mx-auto px-space-md py-space-2xl flex-1 justify-center">
        <div class="w-full flex flex-col items-center justify-center">
            <div class="relative w-full max-w-max-mobile-width flex flex-col items-center">

                <div class="warm-glow"></div>

                <div class="w-full bg-surface-container-lowest rounded-xl p-space-lg shadow-xl shadow-primary-container/10 flex flex-col gap-space-lg relative overflow-hidden z-10">

                    {{-- Branding --}}
                    <div class="flex flex-col items-center text-center pt-space-xs">
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-surface-container mb-space-sm shadow-md shadow-primary-container/10">
                            <svg class="absolute -top-3 w-8 h-8 text-secondary opacity-75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 10C7 8 8 7 8 5M12 11C12 9 13 8 13 4M17 10C17 8 18 7 18 6">
                                    <animateTransform attributeName="transform" dur="3s" repeatCount="indefinite" type="translate" values="0,0; 0,-3; 0,0"/>
                                    <animate attributeName="opacity" dur="3s" repeatCount="indefinite" values="0.4; 0.9; 0.4"/>
                                </path>
                            </svg>
                            <span class="material-symbols-outlined text-primary" style="font-size:32px;">mark_email_unread</span>
                        </div>
                        <h1 class="text-headline-lg font-headline-lg text-primary tracking-tight">Verifikasi Email</h1>
                        <div class="mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-label-md font-label-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            Kopi Kita · Admin & POS
                        </div>
                        <p class="mt-2 text-on-surface-variant text-body-sm">
                            Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirimkan.
                        </p>
                    </div>

                    {{-- Verification sent status --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="px-3 py-2 rounded-lg bg-surface-container text-on-surface-variant text-body-sm flex items-start gap-2">
                            <span class="material-symbols-outlined text-secondary shrink-0" style="font-size:18px;">check_circle</span>
                            <span>Tautan verifikasi baru telah dikirimkan ke alamat email Anda.</span>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex flex-col gap-space-sm">

                        {{-- Resend --}}
                        <form id="resendForm" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button id="resendBtn" type="submit"
                                class="w-full h-12 bg-primary-container hover:bg-primary active:scale-[0.98] text-on-primary text-label-lg font-label-lg rounded-lg shadow-md shadow-primary-container/25 flex items-center justify-center gap-2 transition-all duration-200">
                                <span class="material-symbols-outlined" style="font-size:20px;">send</span>
                                <span id="resendBtnText">Kirim Ulang Email Verifikasi</span>
                            </button>
                        </form>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full h-11 text-on-surface-variant hover:text-primary text-label-md font-label-md flex items-center justify-center gap-1.5 transition-colors duration-200">
                                <span class="material-symbols-outlined" style="font-size:18px;">logout</span>
                                Keluar
                            </button>
                        </form>
                    </div>

                    {{-- Footer --}}
                    <div class="px-space-sm flex flex-col items-center text-center">
                        <p class="text-body-sm text-on-surface-variant/70 leading-relaxed">© {{ date('Y') }} Kopi Kita. All rights reserved.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('resendForm').addEventListener('submit', function () {
            const btn  = document.getElementById('resendBtn');
            const text = document.getElementById('resendBtnText');
            if (!btn || !text) return;
            btn.disabled = true;
            text.innerHTML = '<span class="material-symbols-outlined spin" style="font-size:20px;">sync</span> Mengirim...';
        });
    </script>

</body>
</html>
