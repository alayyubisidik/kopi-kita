<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Login – Kopi Kita</title>
    <meta name="description" content="Masuk ke portal Admin & POS Kopi Kita untuk mengelola pesanan, inventaris, dan racikan kopi.">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            min-height: max(884px, 100dvh);
            background-color: #fff8f5;
        }
        .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        ::-webkit-scrollbar { display: none; }

        .kk-input:focus {
            outline: none;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px #7c5c3e;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .spin { animation: spin 1s linear infinite; display: inline-block; }

        .warm-glow {
            position: absolute;
            top: -1.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 16rem;
            height: 16rem;
            background: rgba(254, 207, 157, 0.3);
            border-radius: 9999px;
            filter: blur(48px);
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-sans text-body-md flex flex-col min-h-screen antialiased">

    <main class="flex flex-col relative w-full max-w-max-mobile-width mx-auto px-space-md py-space-2xl flex-1 justify-center">
        <div class="w-full flex flex-col items-center justify-center">
            <div class="relative w-full max-w-max-mobile-width flex flex-col items-center">

                {{-- Decorative warm aura glow --}}
                <div class="warm-glow"></div>

                {{-- Main Card --}}
                <div class="w-full bg-surface-container-lowest rounded-xl p-space-lg shadow-xl shadow-primary-container/10 flex flex-col gap-space-lg relative overflow-hidden z-10">

                    {{-- Branding --}}
                    <div class="flex flex-col items-center text-center pt-space-xs">

                        {{-- Coffee icon badge with steam animation --}}
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-surface-container mb-space-sm shadow-md shadow-primary-container/10">
                            <svg class="absolute -top-3 w-8 h-8 text-secondary opacity-75"
                                 fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"
                                 viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 10C7 8 8 7 8 5M12 11C12 9 13 8 13 4M17 10C17 8 18 7 18 6">
                                    <animateTransform attributeName="transform" dur="3s" repeatCount="indefinite"
                                                      type="translate" values="0,0; 0,-3; 0,0"/>
                                    <animate attributeName="opacity" dur="3s" repeatCount="indefinite"
                                             values="0.4; 0.9; 0.4"/>
                                </path>
                            </svg>
                            <span class="material-symbols-outlined text-primary" style="font-size:32px;">local_cafe</span>
                        </div>

                        <h1 class="text-headline-lg font-headline-lg text-primary tracking-tight">Kopi Kita</h1>

                        <div class="mt-1 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-label-md font-label-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            Admin &amp; POS Portal
                        </div>

                        <p class="mt-2 text-on-surface-variant text-body-sm">
                            Masuk untuk mengelola pesanan kasir, inventaris, dan racikan kopi hari ini.
                        </p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="px-3 py-2 rounded-lg bg-surface-container text-on-surface-variant text-body-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Login Form --}}
                    <form id="loginForm" method="POST" action="{{ route('login') }}" class="flex flex-col gap-space-md">
                        @csrf

                        {{-- Email --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-label-lg font-label-lg text-on-surface">
                                Email Admin
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined text-on-surface-variant absolute left-3.5 pointer-events-none transition-colors duration-200"
                                      style="font-size:20px;">mail</span>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="admin@kopikita.id"
                                    class="kk-input w-full h-12 pl-11 pr-4 bg-surface-container-low rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 border-0 transition-all duration-200"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-error text-body-sm" />
                        </div>

                        {{-- Password --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="password" class="text-label-lg font-label-lg text-on-surface">
                                Password
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined text-on-surface-variant absolute left-3.5 pointer-events-none"
                                      style="font-size:20px;">lock</span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="kk-input w-full h-12 pl-11 pr-11 bg-surface-container-low rounded-lg text-body-md text-on-surface placeholder:text-on-surface-variant/50 border-0 transition-all duration-200"
                                />
                                <button
                                    type="button"
                                    id="togglePasswordBtn"
                                    onclick="togglePasswordVisibility()"
                                    aria-label="Tampilkan atau sembunyikan password"
                                    class="w-10 h-10 absolute right-1 flex items-center justify-center rounded-md text-on-surface-variant hover:text-primary transition-colors duration-200">
                                    <span class="material-symbols-outlined" id="eyeIcon" style="font-size:20px;">visibility</span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-error text-body-sm" />
                        </div>

                        {{-- Options row --}}
                        <div class="flex items-center justify-between pt-0.5 pb-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer gap-2">
                                <input id="remember_me" type="checkbox" name="remember"
                                       class="rounded border-outline-variant text-primary focus:ring-primary/30 w-4 h-4">
                                <span class="text-label-md text-on-surface-variant">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-label-md font-label-md text-primary hover:text-secondary underline decoration-secondary/30 transition-colors">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit button --}}
                        <button
                            id="loginBtn"
                            type="submit"
                            class="w-full h-12 mt-1 bg-primary-container hover:bg-primary active:scale-[0.98] text-on-primary text-label-lg font-label-lg rounded-lg shadow-md shadow-primary-container/25 flex items-center justify-center gap-2 transition-all duration-200">
                            <span id="loginBtnText">Masuk</span>
                        </button>
                    </form>

                    {{-- Footer --}}
                    <div class="px-space-sm flex flex-col items-center text-center">
                        <p class="text-body-sm text-on-surface-variant/70 leading-relaxed">
                            © {{ date('Y') }} Kopi Kita. All rights reserved.
                        </p>
                    </div>

                </div>{{-- /card --}}
            </div>
        </div>
    </main>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eyeIcon');
            if (!input || !icon) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn  = document.getElementById('loginBtn');
            const text = document.getElementById('loginBtnText');
            if (!btn || !text) return;
            btn.disabled = true;
            text.innerHTML = '<span class="material-symbols-outlined spin" style="font-size:20px;">sync</span> Menghubungkan...';
        });
    </script>

</body>
</html>
