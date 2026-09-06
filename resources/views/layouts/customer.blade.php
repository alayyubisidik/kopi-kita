<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kopi Kita') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex">
                    <a href="{{ route('customer.menu') }}" class="text-xl font-bold text-blue-600 flex items-center gap-2">
                        <i data-lucide="coffee" class="h-6 w-6"></i>
                        Kopi Kita
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <i data-lucide="shopping-cart" class="h-6 w-6"></i>
                        @php $cartCount = \App\Services\CartService::count(); @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-blue-600 rounded-full">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>
