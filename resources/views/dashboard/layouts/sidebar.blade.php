<!-- Sidebar (Desktop) -->
<aside class="hidden md:flex md:flex-col md:w-64 bg-gray-800 text-white">
    <!-- Logo -->
    <div class="p-4 border-b border-gray-700">
        <h1 class="text-2xl font-bold text-amber-400">{{ config('app.name') }}</h1>
        <p class="text-sm text-gray-400">Admin Dashboard</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard.index') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('dashboard.categories.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard.categories.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Categories
        </a>

        <a href="{{ route('dashboard.option-groups.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard.option-groups.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            Option Groups
        </a>

        <a href="{{ route('dashboard.options.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('dashboard.options.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Options
        </a>

        {{-- <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Products
        </a>

        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Orders
        </a>

        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded {{ request()->routeIs('admin.reports') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Reports
        </a> --}}
    </nav>

    <!-- User Section -->
    <div class="p-4 border-t border-gray-700">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400">Admin</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar -->
<div x-show="sidebarOpen" class="fixed inset-0 z-50 md:hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" @click="sidebarOpen = false"></div>
    <div class="relative bg-gray-800 w-64 h-full">
        <div class="p-4 border-b border-gray-700">
            <h1 class="text-2xl font-bold text-amber-400">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-400">Admin Dashboard</p>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('dashboard.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Dashboard</a>
            <a href="{{ route('dashboard.categories.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Categories</a>
            <a href="{{ route('dashboard.option-groups.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Option Groups</a>
            <a href="{{ route('dashboard.options.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Options</a>
            {{-- <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Orders</a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">Reports</a> --}}
        </nav>
    </div>
</div>