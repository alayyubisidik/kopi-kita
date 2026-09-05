<!-- Topbar -->
<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = true" class="md:hidden p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Title -->
        <div>
            <h2 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            @hasSection('breadcrumb')
                <p class="text-sm text-gray-600">@yield('breadcrumb')</p>
            @endif
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:text-red-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</header>