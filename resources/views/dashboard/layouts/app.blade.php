<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kopi Kita') }} - Dashboard</title>
        <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

        <!-- Google Fonts: Plus Jakarta Sans & Material Symbols -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>/* Tailwind base styles preserved from original */</style>
        @endif

        <style>
            *, *::before, *::after { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
                line-height: 1;
                display: inline-block;
                vertical-align: middle;
            }
            /* Prevent Alpine.js x-show flash on page load */
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body style="background-color: #fff8f5; color: #221a13; margin: 0;">
        <div class="min-h-screen flex">
            @include('dashboard.layouts.sidebar')

            <!-- Main Content — offset by fixed sidebar on md+ -->
            <div class="flex-1 flex flex-col min-w-0 md:pl-64">
                <!-- Topbar -->
                @include('dashboard.layouts.topbar')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-4 sm:p-6" style="background-color: #fff8f5;">
                    @yield('content')
                </main>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('dashboard.layouts.scripts')
    @stack('scripts')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
    </body>
</html>
