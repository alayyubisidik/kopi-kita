@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Back link --}}
    <a href="{{ route('customer.menu') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mb-6">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Menu
    </a>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Cart</h1>

    @if(empty($cart))
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <i data-lucide="shopping-cart" class="h-16 w-16 text-gray-200 mx-auto mb-4"></i>
            <p class="text-gray-500 font-medium mb-1">Cart kamu masih kosong.</p>
            <p class="text-gray-400 text-sm mb-6">Yuk pilih menu favoritmu!</p>
            <a href="{{ route('customer.menu') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-md hover:bg-blue-700 transition-colors font-semibold text-sm">
                <i data-lucide="utensils" class="h-4 w-4"></i>
                Lihat Menu
            </a>
        </div>
    @else
        <div class="space-y-4 mb-6">
            @foreach($cart as $item)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900">{{ $item['product_name'] }}</p>

                            @if(!empty($item['options']))
                                <div class="mt-1 space-y-0.5">
                                    @foreach($item['options'] as $option)
                                        <p class="text-xs text-gray-500">
                                            {{ $option['option_group_name'] }}: {{ $option['option_name'] }}
                                            @if($option['additional_price'] > 0)
                                                <span class="text-gray-400">(+Rp {{ number_format($option['additional_price'], 0, ',', '.') }})</span>
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                            @endif

                            @if(!empty($item['note']))
                                <p class="text-xs text-gray-400 mt-1 italic">Catatan: {{ $item['note'] }}</p>
                            @endif

                            <p class="text-sm text-gray-500 mt-2">
                                Harga dasar: Rp {{ number_format($item['product_price'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-3 shrink-0">
                            <p class="font-bold text-blue-600 text-base">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>

                            {{-- Quantity controls --}}
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.update', $item['cart_item_key']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                    <button type="submit"
                                        @if($item['quantity'] <= 1) disabled @endif
                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 disabled:opacity-40 disabled:cursor-not-allowed">
                                        <i data-lucide="minus" class="h-3.5 w-3.5"></i>
                                    </button>
                                </form>

                                <span class="text-sm font-semibold text-gray-900 w-6 text-center">{{ $item['quantity'] }}</span>

                                <form action="{{ route('cart.update', $item['cart_item_key']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600">
                                        <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Remove --}}
                            <form action="{{ route('cart.destroy', $item['cart_item_key']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-500 hover:text-red-700 transition-colors">
                                    <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Cart Total --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 mb-6">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-700">Total</span>
                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('customer.menu') }}"
                class="flex-1 flex items-center justify-center gap-2 border border-blue-600 text-blue-600 px-5 py-3 rounded-md hover:bg-blue-50 transition-colors font-semibold text-sm">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Tambah Item
            </a>

            <a href="{{ route('checkout.index') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-md hover:bg-blue-700 transition-colors font-semibold text-sm">
                <i data-lucide="credit-card" class="h-4 w-4"></i>
                Checkout
            </a>
        </div>

        {{-- Clear Cart --}}
        <div class="mt-4 text-center">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition-colors">
                    Kosongkan Cart
                </button>
            </form>
        </div>
    @endif

</div>
@endsection
