@extends('customer.layouts.customer')

@section('title', 'Menu Katalog — Kopi Kita')
@section('meta_description', 'Temukan kopi favoritmu di Kopi Kita. Pilihan menu signature, kopi, non-kopi, dan makanan ringan.')
@section('page-title', 'Menu Katalog')

@section('content')
<div class="flex flex-col w-full pb-6">

    {{-- Search Bar --}}
    <div class="w-full mb-space-md">
        <form action="{{ route('customer.menu') }}" method="GET" class="relative flex items-center">
            @if($categoryId)
                <input type="hidden" name="category" value="{{ $categoryId }}">
            @endif
            <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">search</span>
            <input
                id="menu-search-input"
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari menu favorit kamu..."
                class="w-full h-11 pl-11 pr-10 bg-surface-container-lowest text-on-surface placeholder:text-outline font-body-md text-body-md rounded-lg shadow-sm focus:outline-none focus:bg-surface-bright transition-all"
                style="box-shadow: 0 1px 4px rgba(124, 92, 62, 0.08);"
                autocomplete="off">
            @if($search)
                <a href="{{ route('customer.menu', ['category' => $categoryId]) }}"
                   class="absolute right-3 w-6 h-6 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center hover:opacity-80">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </a>
            @endif
        </form>
    </div>

    {{-- Category Pills --}}
    <div class="w-full mb-space-md -mx-space-md px-space-md overflow-x-auto no-scrollbar">
        <div class="flex items-center gap-2 min-w-max pb-1">
            <a href="{{ route('customer.menu', ['search' => $search]) }}"
               class="px-4 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 shadow-sm
                      {{ !$categoryId ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-primary hover:bg-surface-container' }}">
                Semua
            </a>
            @foreach($categories as $category)
                <a href="{{ route('customer.menu', ['category' => $category->id, 'search' => $search]) }}"
                   class="px-4 py-1.5 rounded-full font-label-md text-label-md transition-all duration-200 shadow-sm
                          {{ $categoryId == $category->id ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-primary hover:bg-surface-container' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Section Header --}}
    <div class="flex items-center justify-between mb-space-sm">
        <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-secondary text-[18px]">coffee</span>
            <h2 class="font-headline-sm text-headline-sm text-on-surface tracking-tight">
                @if($search || $categoryId)
                    Hasil Pencarian
                @else
                    Pilihan Terpopuler
                @endif
            </h2>
        </div>
        <span class="font-label-sm text-label-sm text-outline">
            {{ $productsCount }} Menu Tersedia
        </span>
    </div>

    {{-- Product Grid --}}
    @if($products->isEmpty())
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-outline mb-3">
                <span class="material-symbols-outlined text-[32px]">emoji_food_beverage</span>
            </div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-1">Menu Tidak Ditemukan</h3>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-xs mb-4">
                Coba cari dengan kata kunci lain seperti "kopi", "matcha", atau "croissant".
            </p>
            @if($search || $categoryId)
                <a href="{{ route('customer.menu') }}"
                   class="h-9 px-4 rounded-lg bg-surface-container-high text-primary font-label-md text-label-md hover:bg-surface-container-highest transition-colors">
                    Tampilkan Semua Menu
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 gap-space-sm w-full">
            @foreach($products as $product)
                <div class="product-card flex flex-col justify-between bg-surface-container-lowest rounded-xl p-2.5 shadow-sm transition-transform duration-200 hover:-translate-y-0.5"
                     data-category="{{ $product->category?->slug }}"
                     data-title="{{ strtolower($product->name) }}"
                     style="box-shadow: 0 4px 14px -2px rgba(124, 92, 62, 0.08);">

                    <div>
                        {{-- Product Image --}}
                        <div class="relative w-full aspect-square rounded-lg overflow-hidden bg-surface-container mb-2.5">
                            @if($product->hasMedia('product-images'))
                                <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-[48px] opacity-40">coffee</span>
                                </div>
                            @endif
                        </div>

                        {{-- Product Meta --}}
                        <div class="flex flex-col px-0.5 mb-2">
                            <h3 class="font-label-lg text-label-lg text-on-surface line-clamp-1 leading-snug">
                                {{ $product->name }}
                            </h3>
                            @if($product->category)
                                <span class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Price + CTA --}}
                    <div class="flex flex-col gap-2 pt-1 px-0.5 w-full">
                        <span class="font-bold text-primary font-headline-sm text-body-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('customer.menu.show', $product->slug) }}"
                           class="add-to-cart-btn w-full h-9 rounded-lg bg-primary text-on-primary font-label-sm text-label-sm flex items-center justify-center gap-1 active:scale-95 transition-all shadow-sm hover:opacity-90"
                           data-name="{{ $product->name }}"
                           data-price="{{ $product->price }}">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            <span>Tambah</span>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
