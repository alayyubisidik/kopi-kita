{{-- Topbar --}}
<header class="sticky top-0 z-40"
        style="background-color: rgba(255,248,245,0.88); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); box-shadow: 0 1px 8px rgba(124,92,62,0.07);">
    <div class="h-16 w-full px-4 sm:px-6 flex items-center justify-between">

        {{-- Mobile menu button --}}
        <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg transition-colors"
                style="color: #624528;"
                onmouseover="this.style.backgroundColor='#ffeadc'" onmouseout="this.style.backgroundColor='transparent'">
            <span class="material-symbols-outlined" style="font-size:24px;">menu</span>
        </button>

        {{-- Page Title (mobile) --}}
        <div class="md:hidden flex-1 px-3">
            <h2 class="text-base font-semibold truncate" style="color: #221a13;">@yield('title', 'Dashboard')</h2>
        </div>

        {{-- Spacer desktop --}}
        <div class="hidden md:flex flex-1"></div>

        {{-- User info --}}
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col text-right">
                <p class="text-sm font-semibold leading-tight" style="color: #221a13;">{{ auth()->user()->name }}</p>
            </div>
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0"
                 style="background-color: #624528;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</header>
