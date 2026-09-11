@extends('customer.layouts.customer')

@section('title', 'Keranjang — Kopi Kita')
@section('meta_description', 'Keranjang belanja Kopi Kita. Cek pesananmu sebelum checkout.')
@section('page-title', 'Keranjang')

@section('content')
<div class="flex flex-col w-full gap-space-md">

    {{-- Back + Title --}}
    <div class="flex items-center justify-between pt-space-sm">
        <a href="{{ route('customer.menu') }}"
           class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-surface-container-low text-primary-container font-label-md text-label-md active:scale-95 transition-transform hover:bg-surface-container">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Menu</span>
        </a>
    </div>

    <div class="flex flex-col gap-1">
        <div class="flex items-baseline justify-between">
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Keranjang Belanja</h1>
            @if(!empty($cart))
                <span class="font-label-md text-label-md text-primary font-semibold">
                    {{ collect($cart)->sum('quantity') }} Pesanan
                </span>
            @endif
        </div>
    </div>

    @if(empty($cart))
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-10 px-4 text-center bg-surface-container-lowest rounded-xl shadow-sm">
            <div class="w-20 h-20 rounded-full bg-surface-container-high flex items-center justify-center text-primary mb-3">
                <span class="material-symbols-outlined text-[40px]">coffee_maker</span>
            </div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface">Cangkirmu Masih Kosong</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1 max-w-[240px]">
                Aroma biji kopi pilihan hari ini sudah menanti. Yuk pilih seduhan favoritmu!
            </p>
            <a href="{{ route('customer.menu') }}"
               class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:bg-primary-container active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[18px]">local_cafe</span>
                Jelajahi Menu
            </a>
        </div>

    @else
        {{-- Cart Item List --}}
        <div class="flex flex-col gap-space-sm">
            @foreach($cart as $item)
                <div class="relative bg-surface-container-lowest rounded-xl p-space-sm shadow-[0_2px_12px_-2px_rgba(124,92,62,0.08)] flex flex-col gap-space-sm transition-all duration-300"
                     id="item-card-{{ $loop->index }}">

                    <div class="flex gap-space-sm items-start">
                        {{-- Product Image --}}
                        <div class="relative w-20 h-20 rounded-lg overflow-hidden bg-surface-container flex-shrink-0 shadow-sm">
                            @if(!empty($item['product_image']))
                                <img src="{{ $item['product_image'] }}"
                                     alt="{{ $item['product_name'] }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-[32px] opacity-40">coffee</span>
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="flex flex-col flex-1 min-w-0">
                            <h2 class="font-headline-sm text-headline-sm text-on-surface leading-snug truncate">
                                {{ $item['product_name'] }}
                            </h2>

                            {{-- Options --}}
                            @if(!empty($item['options']))
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 leading-snug">
                                    {{ collect($item['options'])->pluck('option_name')->join(', ') }}
                                </p>
                            @endif

                            {{-- Note --}}
                            @if(!empty($item['note']))
                                <div class="flex items-center gap-1 mt-1 text-on-surface-variant italic font-body-sm text-[12px] bg-surface-container-low px-2 py-0.5 rounded-md self-start">
                                    <span class="material-symbols-outlined text-[13px] text-primary not-italic">edit_note</span>
                                    <span class="truncate max-w-[170px]">"{{ $item['note'] }}"</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Price + Controls + Delete --}}
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Subtotal</span>
                            <span class="font-headline-sm text-headline-sm text-primary">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-space-sm">
                            {{-- Quantity Stepper --}}
                            <div class="flex items-center bg-surface-container-low rounded-full p-0.5 shadow-inner">
                                {{-- Decrement --}}
                                <form action="{{ route('cart.update', $item['cart_item_key']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                    <button type="submit"
                                            @if($item['quantity'] <= 1) disabled @endif
                                            aria-label="Kurangi Jumlah"
                                            class="w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-surface-container-high active:scale-95 transition-all disabled:opacity-40">
                                        <span class="material-symbols-outlined text-[18px]">remove</span>
                                    </button>
                                </form>

                                <span class="w-7 text-center font-label-lg text-label-lg text-on-surface">
                                    {{ $item['quantity'] }}
                                </span>

                                {{-- Increment --}}
                                <form action="{{ route('cart.update', $item['cart_item_key']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit"
                                            aria-label="Tambah Jumlah"
                                            class="w-8 h-8 rounded-full flex items-center justify-center text-primary hover:bg-surface-container-high active:scale-95 transition-all">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </form>
                            </div>

                            {{-- Delete --}}
                            <form action="{{ route('cart.destroy', $item['cart_item_key']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        aria-label="Hapus Item"
                                        class="inline-flex items-center gap-1 text-error hover:bg-error-container/40 px-2 py-1.5 rounded-lg active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">delete_outline</span>
                                    <span class="font-label-sm text-label-sm">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Cart Summary --}}
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-[0_4px_16px_-2px_rgba(124,92,62,0.07)] flex flex-col gap-space-sm">
            <div class="flex items-center justify-between">
                <span class="font-label-lg text-label-lg text-on-surface">Rincian Pembayaran</span>
                <span class="material-symbols-outlined text-on-surface-variant text-[18px]">receipt</span>
            </div>

            <div class="flex flex-col gap-2 pt-1">
                <div class="flex items-center justify-between">
                    <span class="font-body-md text-body-md text-on-surface-variant">Jumlah Item</span>
                    <span class="font-body-md text-body-md text-on-surface font-medium">
                        {{ collect($cart)->sum('quantity') }} Produk
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-body-md text-body-md text-on-surface-variant">Subtotal</span>
                    <span class="font-body-md text-body-md text-on-surface font-medium">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="w-full h-[1px] bg-surface-container-highest my-1"></div>

            <div class="flex items-baseline justify-between pt-0.5">
                <span class="font-headline-sm text-headline-sm text-on-surface">Total Pembayaran</span>
                <span class="font-numeric-pos text-numeric-pos text-primary">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-stretch gap-space-xs pt-1">
            <a href="{{ route('customer.menu') }}"
               class="flex-1 flex items-center justify-center gap-1.5 h-12 px-3 rounded-lg bg-surface-container-lowest text-primary hover:bg-surface-container-low active:scale-95 shadow-sm transition-all text-center">
                <span class="material-symbols-outlined text-[20px]">add_circle_outline</span>
                <span class="font-label-lg text-label-lg whitespace-nowrap">Tambah Item</span>
            </a>

            <a href="{{ route('checkout.index') }}"
               class="flex-[1.4] flex items-center justify-center gap-2 h-12 px-4 rounded-lg bg-primary text-on-primary hover:bg-primary-container active:scale-95 shadow-[0_4px_14px_rgba(98,69,40,0.3)] transition-all">
                <span class="material-symbols-outlined text-[20px]">credit_card</span>
                <span class="font-label-lg text-label-lg whitespace-nowrap">
                    Checkout (Rp {{ number_format($total, 0, ',', '.') }})
                </span>
            </a>
        </div>

        {{-- Clear Cart --}}
        <div class="flex justify-center pt-0.5 pb-2">
            <form action="{{ route('cart.clear') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin mengosongkan semua keranjang?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1 text-error hover:opacity-80 transition-opacity py-1 px-2 font-label-md text-label-md">
                    <span class="material-symbols-outlined text-[16px]">remove_shopping_cart</span>
                    <span>Kosongkan Keranjang</span>
                </button>
            </form>
        </div>

    @endif

</div>
@endsection
