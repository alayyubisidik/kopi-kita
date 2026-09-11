{{-- Sidebar Desktop --}}
<aside class="hidden md:flex md:flex-col md:w-64 fixed left-0 top-0 h-full z-50 justify-between py-6"
       style="background-color: #fff1e7; box-shadow: 0 4px 14px -2px rgba(124,92,62,0.10);">

    <div class="flex flex-col gap-6">
        {{-- Logo --}}
        <div class="px-6 flex items-center gap-3">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Kopi Kita" class="h-14 w-14 object-contain">
            <div class="flex flex-col">
                <span class="text-lg font-bold tracking-tight" style="color: #492f14;">{{ config('app.name', 'Kopi Kita') }}</span>
                <span class="text-[10px] font-bold uppercase tracking-widest" style="color: #7a582f;">Point of Sale</span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex flex-col gap-1 px-3">

            @php
                $navLinkBase = 'flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-150';
                $navActive = 'background-color: #624528; color: #fff;';
                $navInactive = 'color: #4f453c;';
            @endphp

            <a href="{{ route('dashboard.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.index') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.index') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('dashboard.products.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.products.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.products.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">coffee</span>
                <span>Produk / Menu</span>
            </a>

            <a href="{{ route('dashboard.categories.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.categories.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.categories.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">category</span>
                <span>Kategori</span>
            </a>

            <a href="{{ route('dashboard.option-groups.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.option-groups.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.option-groups.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">tune</span>
                <span>Option Groups</span>
            </a>

            <a href="{{ route('dashboard.orders.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.orders.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.orders.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">receipt_long</span>
                <span>Pesanan / Orders</span>
            </a>

            <a href="{{ route('dashboard.offline-orders.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.offline-orders.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.offline-orders.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">point_of_sale</span>
                <span>Offline Order</span>
            </a>

            {{-- Reports Dropdown --}}
            <div x-data="{ open: {{ request()->routeIs('dashboard.reports.*') ? 'true' : 'false' }} }" class="flex flex-col gap-1">
                <button @click="open = !open"
                        class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 w-full opacity-80 hover:opacity-100"
                        style="color: #4f453c;">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined" style="font-size:20px;">analytics</span>
                        <span>Laporan</span>
                    </div>
                    <span class="material-symbols-outlined transition-transform duration-200" style="font-size:16px;" :class="{ 'rotate-180': open }">expand_more</span>
                </button>
                <div x-show="open" x-cloak class="flex flex-col gap-0.5 ml-4 pl-4" style="border-left: 2px solid #ffeadc;">
                    <a href="{{ route('dashboard.reports.sales') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ request()->routeIs('dashboard.reports.sales') ? 'font-semibold' : 'opacity-70 hover:opacity-100' }}"
                       style="{{ request()->routeIs('dashboard.reports.sales') ? 'color:#624528;background-color:#ffeadc;' : 'color:#4f453c;' }}">
                        <span class="material-symbols-outlined" style="font-size:16px;">bar_chart</span> Penjualan
                    </a>
                    <a href="{{ route('dashboard.reports.products') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ request()->routeIs('dashboard.reports.products') ? 'font-semibold' : 'opacity-70 hover:opacity-100' }}"
                       style="{{ request()->routeIs('dashboard.reports.products') ? 'color:#624528;background-color:#ffeadc;' : 'color:#4f453c;' }}">
                        <span class="material-symbols-outlined" style="font-size:16px;">inventory_2</span> Produk
                    </a>
                    <a href="{{ route('dashboard.reports.payments') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ request()->routeIs('dashboard.reports.payments') ? 'font-semibold' : 'opacity-70 hover:opacity-100' }}"
                       style="{{ request()->routeIs('dashboard.reports.payments') ? 'color:#624528;background-color:#ffeadc;' : 'color:#4f453c;' }}">
                        <span class="material-symbols-outlined" style="font-size:16px;">payments</span> Pembayaran
                    </a>
                    <a href="{{ route('dashboard.reports.order-types') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 {{ request()->routeIs('dashboard.reports.order-types') ? 'font-semibold' : 'opacity-70 hover:opacity-100' }}"
                       style="{{ request()->routeIs('dashboard.reports.order-types') ? 'color:#624528;background-color:#ffeadc;' : 'color:#4f453c;' }}">
                        <span class="material-symbols-outlined" style="font-size:16px;">swap_horiz</span> Tipe Order
                    </a>
                </div>
            </div>

            <a href="{{ route('dashboard.activity-log.index') }}"
               class="{{ $navLinkBase }} {{ request()->routeIs('dashboard.activity-log.*') ? 'font-semibold' : 'hover:opacity-100 opacity-80' }}"
               style="{{ request()->routeIs('dashboard.activity-log.*') ? 'background-color: #624528; color: #fff;' : 'color: #4f453c;' }}">
                <span class="material-symbols-outlined" style="font-size:20px;">history</span>
                <span>Activity Log</span>
            </a>

        </nav>
    </div>

    {{-- User & Logout --}}
    <div class="px-4 flex flex-col gap-3">
     
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 cursor-pointer"
                    style="color: #ba1a1a; background-color: rgba(255,218,214,0.4);"
                    onmouseover="this.style.backgroundColor='#ffdad6'" onmouseout="this.style.backgroundColor='rgba(255,218,214,0.4)'">
                <span class="material-symbols-outlined" style="font-size:20px;">logout</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Overlay Sidebar --}}
<div x-show="sidebarOpen" class="fixed inset-0 z-50 md:hidden" style="display: none;">
    <div class="fixed inset-0" style="background-color: rgba(0,0,0,0.4);" @click="sidebarOpen = false"></div>
    <div class="relative w-64 h-full flex flex-col justify-between py-6"
         style="background-color: #fff1e7; box-shadow: 4px 0 20px rgba(124,92,62,0.15);">
        <div class="flex flex-col gap-6">
            <div class="px-6 flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Kopi Kita" class="h-10 w-10 object-contain">
                <div>
                    <span class="text-lg font-bold tracking-tight" style="color: #492f14;">{{ config('app.name', 'Kopi Kita') }}</span>
                    <p class="text-[10px] font-bold uppercase tracking-widest" style="color: #7a582f;">Point of Sale</p>
                </div>
            </div>
            <nav class="flex flex-col gap-1 px-3">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">dashboard</span> Dashboard</a>
                <a href="{{ route('dashboard.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">coffee</span> Produk / Menu</a>
                <a href="{{ route('dashboard.categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">category</span> Kategori</a>
                <a href="{{ route('dashboard.option-groups.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">tune</span> Option Groups</a>
                <a href="{{ route('dashboard.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">receipt_long</span> Pesanan</a>
                <a href="{{ route('dashboard.offline-orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">point_of_sale</span> Offline Order</a>
                <a href="{{ route('dashboard.reports.sales') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">analytics</span> Laporan</a>
                <a href="{{ route('dashboard.activity-log.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium" style="color: #4f453c;"><span class="material-symbols-outlined" style="font-size:20px;">history</span> Activity Log</a>
            </nav>
        </div>
        <div class="px-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold cursor-pointer" style="color: #ba1a1a; background-color: rgba(255,218,214,0.4);">
                    <span class="material-symbols-outlined" style="font-size:20px;">logout</span> Keluar
                </button>
            </form>
        </div>
    </div>
</div>
