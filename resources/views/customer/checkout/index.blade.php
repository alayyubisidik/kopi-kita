@extends('customer.layouts.customer')

@section('title', 'Checkout — Kopi Kita')
@section('meta_description', 'Selesaikan pemesanan kamu di Kopi Kita.')
@section('page-title', 'Checkout')

{{-- Sembunyikan bottom nav di halaman checkout --}}
@section('hide-bottom-nav')@endsection

@push('head-scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@section('content')

<div class="flex flex-col w-full pb-8">

    {{-- Back Link & Title Header --}}
    <div class="flex flex-col gap-space-2xs pt-space-sm mb-space-md">
        <a class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-surface-container-low text-primary-container font-label-md text-label-md active:scale-95 transition-transform hover:bg-surface-container self-start"
           href="{{ route('cart.index') }}">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Keranjang</span>
        </a>
        <div class="flex items-baseline justify-between mt-1">
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Checkout</h1>
        </div>
    </div>

    {{-- Main Cards Stack --}}
    <form id="checkout-form" novalidate class="flex flex-col gap-space-md">
        @csrf

        {{-- CARD 1: Informasi Pemesan --}}
        <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-[0_4px_16px_-2px_rgba(124,92,62,0.08)] transition-all">
            <div class="flex items-center gap-2.5 mb-space-md">
                <div class="w-7 h-7 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">badge</span>
                </div>
                <h2 class="font-headline-sm text-headline-sm text-on-surface">Informasi Pemesan</h2>
            </div>

            <div class="flex flex-col gap-space-sm">
                {{-- Input Nama --}}
                <div class="flex flex-col gap-1.5">
                    <label class="font-label-md text-label-md text-on-surface-variant flex items-center gap-0.5" for="customer_name">
                        <span>Nama Pemesan</span>
                        <span class="text-error font-bold">*</span>
                    </label>
                    <div class="relative flex items-center">
                        <input
                            class="w-full h-12 px-space-md bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-lg shadow-[inset_0_0_0_1px_rgba(211,196,185,0.8)] focus:shadow-[0_0_0_3px_rgba(124,92,62,0.2),inset_0_0_0_1.5px_#7C5C3E] focus:outline-none transition-all pr-10"
                            id="customer_name"
                            name="customer_name"
                            placeholder="Masukkan nama lengkap"
                            type="text"
                            maxlength="255"
                            required
                        >
                        <span class="material-symbols-outlined absolute right-3 text-secondary text-[20px] pointer-events-none">person_outline</span>
                    </div>
                    <p id="customer_name_error" class="text-xs text-error hidden mt-0.5"></p>
                </div>
            </div>
        </section>

        {{-- CARD 2: Ringkasan Pesanan --}}
        <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-[0_4px_16px_-2px_rgba(124,92,62,0.08)]">
            <div class="flex items-center justify-between mb-space-md">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                    </div>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Ringkasan Pesanan</h2>
                </div>
                <a class="font-label-md text-label-md text-primary hover:underline inline-flex items-center gap-0.5"
                   href="{{ route('cart.index') }}">
                    <span>Ubah pesanan</span>
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                </a>
            </div>

            {{-- Item List --}}
            <div class="flex flex-col gap-3">
                @foreach($cart as $item)
                <div class="flex items-start justify-between gap-3 p-2 rounded-lg bg-surface-container-low/40">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        @if(!empty($item['product_image']))
                            <img class="w-12 h-12 rounded-lg object-cover flex-shrink-0 shadow-sm"
                                 src="{{ $item['product_image'] }}"
                                 alt="{{ $item['product_name'] }}">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-surface-container flex-shrink-0 shadow-sm flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant text-[24px]">coffee</span>
                            </div>
                        @endif
                        <div class="flex flex-col flex-1 min-w-0">
                            <span class="font-label-lg text-label-lg text-on-surface">{{ $item['quantity'] }}x {{ $item['product_name'] }}</span>
                            @if(!empty($item['options']))
                                <span class="font-body-sm text-body-sm text-on-surface-variant">
                                    {{ collect($item['options'])->map(fn($o) => $o['option_name'])->implode(', ') }}
                                </span>
                            @endif
                            @if(!empty($item['note']))
                                <span class="font-body-sm text-body-sm text-on-surface-variant italic">Catatan: {{ $item['note'] }}</span>
                            @endif
                        </div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface flex-shrink-0 pt-0.5">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Price Breakdown --}}
            <div class="mt-4 pt-3 flex flex-col gap-1.5 bg-surface-container-low/30 rounded-lg p-3">
                <div class="flex items-center justify-between text-on-surface-variant font-body-sm text-body-sm">
                    <span>Jumlah Item</span>
                    <span class="font-label-md text-label-md text-on-surface">{{ collect($cart)->sum('quantity') }} item</span>
                </div>
                <div class="h-px w-full bg-surface-variant/70 my-1"></div>
                <div class="flex items-center justify-between">
                    <span class="font-headline-sm text-headline-sm text-on-surface">Total Pembayaran</span>
                    <span class="font-numeric-pos text-numeric-pos text-primary-container">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </section>

        {{-- CARD 3: Metode Pembayaran --}}
        <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-[0_4px_16px_-2px_rgba(124,92,62,0.08)]">
            <div class="flex items-center gap-2.5 mb-space-md">
                <div class="w-7 h-7 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">credit_card</span>
                </div>
                <h2 class="font-headline-sm text-headline-sm text-on-surface">Metode Pembayaran</h2>
            </div>
            <div class="flex items-center gap-3 rounded-lg border border-outline-variant bg-surface-container-low px-4 py-3">
                <span class="material-symbols-outlined text-primary text-[22px] flex-shrink-0" style="font-variation-settings: 'FILL' 1;">payments</span>
                <div>
                    <p class="font-label-lg text-label-lg text-on-surface">Pembayaran Online (Midtrans)</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Kamu akan diarahkan ke halaman pembayaran Midtrans untuk menyelesaikan transaksi.</p>
                </div>
            </div>
        </section>

        {{-- CTA Button --}}
        <div class="mt-2 flex flex-col gap-2">
            <button
                type="submit"
                id="checkout-submit-btn"
                class="w-full h-12 bg-primary-container active:bg-primary text-on-primary font-label-lg text-label-lg rounded-lg shadow-[0_4px_16px_rgba(98,69,40,0.25)] active:scale-[0.98] transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <span id="btn-icon-wrapper">
                    <span class="material-symbols-outlined text-[20px]">credit_card</span>
                </span>
                <span id="btn-label">Lanjut ke Pembayaran &bull; Rp {{ number_format($total, 0, ',', '.') }}</span>
            </button>
            {{-- Secure Note --}}
            <p class="text-center font-body-sm text-body-sm text-on-surface-variant flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[14px]">lock</span>
                Transaksi aman &amp; terenkripsi
            </p>
        </div>

    </form>
</div>

{{-- Loading Overlay --}}
<div id="loading-overlay" class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center bg-surface/95 backdrop-blur-sm">
    <div class="w-16 h-16 rounded-full border-4 border-surface-container-high border-t-primary animate-spin mb-4"></div>
    <h2 class="font-headline-sm text-headline-sm text-on-surface">Memproses Pesanan...</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">Mohon tunggu, jangan tutup halaman ini.</p>
</div>

@endsection

@push('scripts')
<script>
    const form = document.getElementById('checkout-form');
    const btn = document.getElementById('checkout-submit-btn');
    const btnLabel = document.getElementById('btn-label');
    const btnIconWrapper = document.getElementById('btn-icon-wrapper');
    const customerNameInput = document.getElementById('customer_name');
    const customerNameError = document.getElementById('customer_name_error');
    const loadingOverlay = document.getElementById('loading-overlay');

    function showLoading() {
        loadingOverlay.classList.remove('hidden');
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        customerNameError.classList.add('hidden');
        customerNameError.textContent = '';

        const customerName = customerNameInput.value.trim();

        if (!customerName) {
            customerNameError.textContent = 'Nama pemesan wajib diisi.';
            customerNameError.classList.remove('hidden');
            customerNameInput.focus();
            return;
        }

        btn.disabled = true;
        btnLabel.textContent = 'Menghubungkan Midtrans...';
        btnIconWrapper.innerHTML = '<span class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span>';

        fetch('{{ route('checkout.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ customer_name: customerName }),
        })
        .then(function (response) {
            return response.json().then(function (data) {
                return { status: response.status, data: data };
            });
        })
        .then(function (result) {
            if (result.status !== 200) {
                btn.disabled = false;
                btnLabel.textContent = 'Lanjut ke Pembayaran';
                btnIconWrapper.innerHTML = '<span class="material-symbols-outlined text-[20px]">credit_card</span>';

                if (result.data.redirect) {
                    window.location.href = result.data.redirect;
                    return;
                }

                if (result.data.errors && result.data.errors.customer_name) {
                    customerNameError.textContent = result.data.errors.customer_name[0];
                    customerNameError.classList.remove('hidden');
                    return;
                }

                alert(result.data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                return;
            }

            const snapToken = result.data.snap_token;
            const orderId = result.data.order_id;

            btnLabel.textContent = 'Membuka Snap Window';
            btnIconWrapper.innerHTML = '<span class="material-symbols-outlined text-[20px]">check_circle</span>';

            // Fix: user-scalable=no blocks touch events inside Snap iframe on mobile.
            // Temporarily remove it while Snap is open, then restore.
            const vpMeta = document.querySelector('meta[name="viewport"]');
            const vpOriginal = vpMeta.content;
            vpMeta.content = 'width=device-width, initial-scale=1.0, viewport-fit=cover';

            function restoreViewport() {
                vpMeta.content = vpOriginal;
            }

            function resetBtn() {
                btn.disabled = false;
                btnLabel.textContent = 'Lanjut ke Pembayaran';
                btnIconWrapper.innerHTML = '<span class="material-symbols-outlined text-[20px]">credit_card</span>';
            }

            window.snap.pay(snapToken, {
                onSuccess: function (snapResult) {
                    restoreViewport();
                    showLoading();
                    fetch('{{ route('cart.clear') }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                    }).finally(function () {
                        window.location.href = '{{ route('payment.success') }}?order_id=' + orderId + '&transaction_status=settlement';
                    });
                },
                onPending: function (result) {
                    restoreViewport();
                    resetBtn();
                },
                onError: function (result) {
                    restoreViewport();
                    resetBtn();
                },
                onClose: function () {
                    restoreViewport();
                    resetBtn();
                },
            });
        })
        .catch(function () {
            btn.disabled = false;
            btnLabel.textContent = 'Lanjut ke Pembayaran';
            btnIconWrapper.innerHTML = '<span class="material-symbols-outlined text-[20px]">credit_card</span>';
            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
        });
    });
</script>
@endpush
