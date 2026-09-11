<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Reset Password – Kopi Kita</title>
    <meta name="description" content="Atur ulang password akun Admin & POS Kopi Kita.">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { min-height: max(884px, 100dvh); background-color: #fff8f5; }
        ::-webkit-scrollbar { display: none; }
        .kk-input:focus { outline: none; background-color: #ffffff; box-shadow: 0 0 0 2px #7c5c3e; }
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
                            <span class="material-symbols-outlined text-primary" style="font-size:32px;">lock_reset</span>
                        </div>
                        <h1 class="text-headline-lg font-headline-lg text-primary tracking-tight">Reset Password</h1>
                        <div class="mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-label-md font-label-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            Kopi Kita · Admin & POS
                        </div>
                        <p class="mt-2 text-on-surface-variant text-body-sm">
                            Masukkan password baru Anda di bawah ini.
                        </p>
                    </div>

                    {{-- Form --}}
                    <form id="resetForm" method="POST" action="{{ route('password.store') }}" class="flex flex-col gap-space-md">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- Email --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-label-lg font-label-lg text-on-surface">Email</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined text-on-surface-variant absolute left-3.5 pointer-events-none" style="font-size:20px;">mail</span>
                                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                    class="kk-input w-full h-12 pl-11 pr-4 bg-surface-container-low rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 border-0 transition-all duration-200" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-error text-body-sm" />
                        </div>

                        {{-- Password --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="password" class="text-label-lg font-label-lg text-on-surface">Password Baru</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined text-on-surface-variant absolute left-3.5 pointer-events-none" style="font-size:20px;">lock</span>
                                <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="••••••••"
                                    class="kk-input w-full h-12 pl-11 pr-11 bg-surface-container-low rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 border-0 transition-all duration-200" />
                                <button type="button" onclick="togglePwd('password','eyeNew')" aria-label="Toggle password" class="w-10 h-10 absolute right-1 flex items-center justify-center rounded-md text-on-surface-variant hover:text-primary transition-colors duration-200">
                                    <span class="material-symbols-outlined" id="eyeNew" style="font-size:20px;">visibility</span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-error text-body-sm" />
                        </div>

                        {{-- Confirm Password --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="password_confirmation" class="text-label-lg font-label-lg text-on-surface">Konfirmasi Password</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined text-on-surface-variant absolute left-3.5 pointer-events-none" style="font-size:20px;">lock_open</span>
                                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••"
                                    class="kk-input w-full h-12 pl-11 pr-11 bg-surface-container-low rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 border-0 transition-all duration-200" />
                                <button type="button" onclick="togglePwd('password_confirmation','eyeConfirm')" aria-label="Toggle password" class="w-10 h-10 absolute right-1 flex items-center justify-center rounded-md text-on-surface-variant hover:text-primary transition-colors duration-200">
                                    <span class="material-symbols-outlined" id="eyeConfirm" style="font-size:20px;">visibility</span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="text-error text-body-sm" />
                        </div>

                        {{-- Submit --}}
                        <button id="submitBtn" type="submit"
                            class="w-full h-12 mt-1 bg-primary-container hover:bg-primary active:scale-[0.98] text-on-primary text-label-lg font-label-lg rounded-lg shadow-md shadow-primary-container/25 flex items-center justify-center gap-2 transition-all duration-200">
                            <span id="submitBtnText">Simpan Password Baru</span>
                        </button>
                    </form>

                    {{-- Footer --}}
                    <div class="px-space-sm flex flex-col items-center text-center">
                        <p class="text-body-sm text-on-surface-variant/70 leading-relaxed">© {{ date('Y') }} Kopi Kita. All rights reserved.</p>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (!input || !icon) return;
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
        }
        document.getElementById('resetForm').addEventListener('submit', function () {
            const btn  = document.getElementById('submitBtn');
            const text = document.getElementById('submitBtnText');
            if (!btn || !text) return;
            btn.disabled = true;
            text.innerHTML = '<span class="material-symbols-outlined spin" style="font-size:20px;">sync</span> Menyimpan...';
        });
    </script>

</body>
</html>

