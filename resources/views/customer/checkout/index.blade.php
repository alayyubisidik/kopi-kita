@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mb-6">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Cart
    </a>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="space-y-6">

            {{-- Customer Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Informasi Pemesan</h2>

                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pemesan <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="customer_name"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        required
                        maxlength="255"
                        placeholder="Masukkan nama kamu"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('customer_name') border-red-500 @enderror"
                    >
                    @error('customer_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                <div class="space-y-4">
                    @foreach($cart as $item)
                        <div class="flex flex-col sm:flex-row sm:items-start gap-2 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 text-sm">{{ $item['product_name'] }}</p>

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

                                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item['quantity'] }}</p>
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="font-semibold text-blue-600 text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="font-semibold text-gray-700">Total</span>
                    <span class="text-xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <p class="mt-3 text-xs text-gray-400 text-right">
                    <a href="{{ route('cart.index') }}" class="text-blue-500 hover:text-blue-700 underline">Ubah pesanan</a>
                </p>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                <h2 class="text-base font-semibold text-gray-900 mb-3">Metode Pembayaran</h2>
                <div class="flex items-center gap-3 rounded-md border border-blue-200 bg-blue-50 px-4 py-3">
                    <i data-lucide="credit-card" class="h-5 w-5 text-blue-600 shrink-0"></i>
                    <div>
                        <p class="text-sm font-medium text-blue-800">Pembayaran Online (Midtrans)</p>
                        <p class="text-xs text-blue-600 mt-0.5">Kamu akan diarahkan ke halaman pembayaran Midtrans untuk menyelesaikan transaksi.</p>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <button
                type="submit"
                id="checkout-submit-btn"
                class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-3.5 rounded-md hover:bg-blue-700 transition-colors font-semibold text-sm disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <i data-lucide="credit-card" class="h-4 w-4" id="btn-icon"></i>
                <span id="btn-label">Lanjut ke Pembayaran</span>
            </button>

        </div>
    </form>

</div>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function () {
        const btn = document.getElementById('checkout-submit-btn');
        const label = document.getElementById('btn-label');

        btn.disabled = true;
        label.textContent = 'Memproses...';
    });
</script>
@endsection
