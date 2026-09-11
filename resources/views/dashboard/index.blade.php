@extends('dashboard.layouts.app')

@section('title', 'Ringkasan Bisnis')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="pt-2">
        <nav class="flex items-center gap-1 text-xs font-medium mb-1" style="color: #4f453c;">
            <span style="color: #624528;">Dashboard</span>
            <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
            <span class="font-semibold" style="color: #624528;">Ringkasan Bisnis</span>
        </nav>
        <h1 class="text-3xl font-extrabold tracking-tight" style="color: #221a13;">Ringkasan Bisnis</h1>
        <p class="text-sm mt-0.5" style="color: #4f453c;">Pantau performa penjualan Kopi Kita</p>
    </div>

    {{-- 5 KPI Cards (today-based, no filter dependency) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <a href="{{ route('dashboard.reports.sales') }}"
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 sm:col-span-2 lg:col-span-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Total Pendapatan All Time</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">Rp {{ number_format($totalRevenueAllTime, 0, ',', '.') }}</p>
                    <p class="text-xs mt-1" style="color:#81756b;">Semua transaksi sukses</p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:rgba(253,207,156,0.4);color:#624528;">
                    <span class="material-symbols-outlined text-[24px]">savings</span>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.reports.sales') }}"
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Pendapatan Hari Ini</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
                    <p class="text-xs mt-1" style="color:#81756b;">Revenue hari ini</p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:#f5e5d9;color:#7a582f;">
                    <span class="material-symbols-outlined text-[24px]">trending_up</span>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.orders.index') }}"
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Pesanan Hari Ini</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">
                        {{ $totalOrdersToday }} <span class="text-xl font-semibold" style="color:#81756b;">Trx</span>
                    </p>
                    <p class="text-xs mt-1" style="color:#81756b;">Semua pesanan hari ini</p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:rgba(253,207,156,0.4);color:#624528;">
                    <span class="material-symbols-outlined text-[24px]">shopping_bag</span>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.reports.products') }}"
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Produk Terjual</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">
                        {{ $totalItemsSoldToday }} <span class="text-xl font-semibold" style="color:#81756b;">Item</span>
                    </p>
                    <p class="text-xs mt-1" style="color:#81756b;">Item terjual hari ini</p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:#f5e5d9;color:#7a582f;">
                    <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                </div>
            </div>
        </a>

        @php $totalToday = $onlineOrdersToday + $offlineOrdersToday; @endphp

        <a href="{{ route('dashboard.orders.index') }}?search=&order_type=online&payment_method=&payment_status="
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Online</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">
                        {{ $onlineOrdersToday }} <span class="text-xl font-semibold" style="color:#81756b;">Pesanan</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:rgba(253,207,156,0.4);color:#624528;">
                    <span class="material-symbols-outlined text-[24px]">public</span>
                </div>
            </div>
            @if($totalToday > 0)
            <div class="mt-4">
                <div class="flex justify-between text-[11px] font-semibold mb-1.5" style="color:#221a13;">
                    <span>Porsi Kanal</span>
                    <span style="color:#624528;font-weight:700;">{{ round($onlineOrdersToday/$totalToday*100) }}%</span>
                </div>
                <div class="w-full h-1.5 rounded-full overflow-hidden" style="background:#fbebdf;">
                    <div class="h-full rounded-full" style="background:#624528;width:{{ round($onlineOrdersToday/$totalToday*100) }}%;"></div>
                </div>
            </div>
            @endif
        </a>

        <a href="{{ route('dashboard.orders.index') }}?search=&order_type=offline&payment_method=&payment_status="
           class="rounded-2xl p-5 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1"
           style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Offline</span>
                    <p class="text-3xl font-extrabold tracking-tight mt-1" style="color:#221a13;">
                        {{ $offlineOrdersToday }} <span class="text-xl font-semibold" style="color:#81756b;">Pesanan</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:#f5e5d9;color:#7a582f;">
                    <span class="material-symbols-outlined text-[24px]">storefront</span>
                </div>
            </div>
            @if($totalToday > 0)
            <div class="mt-4">
                <div class="flex justify-between text-[11px] font-semibold mb-1.5" style="color:#221a13;">
                    <span>Porsi Kanal</span>
                    <span style="color:#7a582f;font-weight:700;">{{ round($offlineOrdersToday/$totalToday*100) }}%</span>
                </div>
                <div class="w-full h-1.5 rounded-full overflow-hidden" style="background:#fbebdf;">
                    <div class="h-full rounded-full" style="background:#fdcf9c;width:{{ round($offlineOrdersToday/$totalToday*100) }}%;"></div>
                </div>
            </div>
            @endif
        </a>

    </div>

    {{-- Charts --}}
    <div class="rounded-2xl p-6" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
        {{-- Chart header: title + inline filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div>
                <h2 class="text-lg font-semibold" style="color:#221a13;">Tren Penjualan</h2>
                <p class="text-xs mt-0.5" style="color:#4f453c;">Revenue &amp; transaksi berdasarkan periode yang dipilih</p>
            </div>
            {{-- Inline filter (JS only — no page reload) --}}
            <div class="flex flex-wrap items-center gap-2" id="chart-filter">
                <select id="chart-period" class="h-9 text-sm px-3 rounded-xl border focus:outline-none transition" style="border-color:rgba(129,117,107,0.4);background:#fff;color:#221a13;">
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="last_7_days" selected>7 Hari Terakhir</option>
                    <option value="last_30_days">30 Hari Terakhir</option>
                    <option value="this_month">Bulan Ini</option>
                    <option value="last_month">Bulan Lalu</option>
                    <option value="custom">Rentang Kustom</option>
                </select>
                <div id="chart-custom-range" class="hidden gap-2 items-center flex">
                    <input type="date" id="chart-start" class="h-9 text-sm px-3 rounded-xl border" style="border-color:rgba(129,117,107,0.4);color:#221a13;">
                    <span style="color:#81756b;">&ndash;</span>
                    <input type="date" id="chart-end" class="h-9 text-sm px-3 rounded-xl border" style="border-color:rgba(129,117,107,0.4);color:#221a13;">
                </div>
                <button id="chart-apply" class="h-9 px-5 rounded-xl text-sm font-semibold text-white transition hover:opacity-90 flex items-center gap-1.5" style="background:#624528;">
                    <span class="material-symbols-outlined" style="font-size:16px;">refresh</span>
                    Terapkan
                </button>
            </div>
        </div>
        {{-- Two sub-charts stacked --}}
        <div class="flex flex-col gap-6">
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#81756b;">Revenue (Rp)</p>
                <canvas id="revenueChart" height="110"></canvas>
            </div>
            <div>
                <p class="text-xs font-semibold mb-2" style="color:#81756b;">Jumlah Transaksi</p>
                <canvas id="transactionChart" height="90"></canvas>
            </div>
        </div>
    </div>



    {{-- Katalog & Availability --}}
    <div class="rounded-2xl p-6" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
        <div class="flex items-center gap-2 mb-5">
            <span class="material-symbols-outlined text-[20px]" style="color:#7a582f;">storefront</span>
            <h2 class="text-lg font-semibold" style="color:#221a13;">Katalog &amp; Availability</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-xl p-4" style="border:1px solid #ffeadc;background:#fff8f5;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Produk</p>
                    <a href="{{ route('dashboard.products.index') }}" class="text-[11px] font-semibold" style="color:#624528;">Kelola</a>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Total</span><span class="font-bold" style="color:#221a13;">{{ $totalProducts }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Tersedia</span><span class="font-bold" style="color:#624528;">{{ $availableProducts }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Tidak Tersedia</span><span class="font-bold" style="{{ $unavailableProducts>0?'color:#ba1a1a;':'color:#81756b;' }}">{{ $unavailableProducts }}</span></div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="border:1px solid #ffeadc;background:#fff8f5;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Kategori</p>
                    <a href="{{ route('dashboard.categories.index') }}" class="text-[11px] font-semibold" style="color:#624528;">Kelola</a>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Total</span><span class="font-bold" style="color:#221a13;">{{ $totalCategories }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Aktif</span><span class="font-bold" style="color:#624528;">{{ $activeCategories }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Tidak Aktif</span><span class="font-bold" style="{{ $inactiveCategories>0?'color:#ba1a1a;':'color:#81756b;' }}">{{ $inactiveCategories }}</span></div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="border:1px solid #ffeadc;background:#fff8f5;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Option Group</p>
                    <a href="{{ route('dashboard.option-groups.index') }}" class="text-[11px] font-semibold" style="color:#624528;">Kelola</a>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Total</span><span class="font-bold" style="color:#221a13;">{{ $totalOptionGroups }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Aktif</span><span class="font-bold" style="color:#624528;">{{ $activeOptionGroups }}</span></div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="border:1px solid #ffeadc;background:#fff8f5;">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Options</p>
                    <a href="{{ route('dashboard.option-groups.index') }}" class="text-[11px] font-semibold" style="color:#624528;">Kelola</a>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Total</span><span class="font-bold" style="color:#221a13;">{{ $totalOptions }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Tersedia</span><span class="font-bold" style="color:#624528;">{{ $availableOptions }}</span></div>
                    <div class="flex justify-between text-sm"><span style="color:#4f453c;">Tidak Tersedia</span><span class="font-bold" style="{{ $unavailableOptions>0?'color:#ba1a1a;':'color:#81756b;' }}">{{ $unavailableOptions }}</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="rounded-2xl p-6" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
        <h2 class="text-lg font-semibold mb-5" style="color:#221a13;">Quick Actions</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3">
            <a href="{{ route('dashboard.offline-orders.create') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">add_circle</span><span>Buat Pesanan</span></a>
            <a href="{{ route('dashboard.offline-orders.index') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">receipt</span><span>Pesanan Offline</span></a>
            <a href="{{ route('dashboard.products.create') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">add_shopping_cart</span><span>Tambah Produk</span></a>
            <a href="{{ route('dashboard.categories.create') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">create_new_folder</span><span>Tambah Kategori</span></a>
            <a href="{{ route('dashboard.orders.index') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">receipt_long</span><span>Lihat Pesanan</span></a>
            <a href="{{ route('dashboard.reports.sales') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">bar_chart</span><span>Laporan Penjualan</span></a>
            <a href="{{ route('dashboard.reports.payments') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">payments</span><span>Laporan Pembayaran</span></a>
            <a href="{{ route('dashboard.products.index') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">coffee</span><span>Kelola Produk</span></a>
            <a href="{{ route('dashboard.categories.index') }}" class="flex flex-col items-center gap-2.5 p-4 rounded-xl text-center text-sm font-semibold transition-all duration-150 hover:-translate-y-0.5" style="border:1px solid #ffeadc;color:#221a13;" onmouseover="this.style.backgroundColor='#fff1e7';this.style.borderColor='#624528'" onmouseout="this.style.backgroundColor='transparent';this.style.borderColor='#ffeadc'"><span class="material-symbols-outlined text-[28px]" style="color:#624528;">category</span><span>Kelola Kategori</span></a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
    const chartDataUrl = '{{ route('dashboard.chart-data') }}';

    // ── Chart instances ──────────────────────────────────────────────
    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json($salesChartData['labels']),
            datasets: [{
                label: 'Revenue (Rp)',
                data: @json($salesChartData['revenues']),
                borderColor: '#624528',
                backgroundColor: 'rgba(98,69,40,0.08)',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#624528',
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(129,117,107,0.08)' }, ticks: { color: '#81756b', font: { family: 'Plus Jakarta Sans', size: 11 } } },
                x: { grid: { display: false }, ticks: { color: '#81756b', font: { family: 'Plus Jakarta Sans', size: 11 } } }
            }
        }
    });

    const transactionChart = new Chart(document.getElementById('transactionChart'), {
        type: 'bar',
        data: {
            labels: @json($salesChartData['labels']),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: @json($salesChartData['transactions']),
                backgroundColor: 'rgba(98,69,40,0.15)',
                borderColor: '#624528',
                borderWidth: 1.5,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, color: '#81756b', font: { family: 'Plus Jakarta Sans', size: 11 } }, grid: { color: 'rgba(129,117,107,0.08)' } },
                x: { grid: { display: false }, ticks: { color: '#81756b', font: { family: 'Plus Jakarta Sans', size: 11 } } }
            }
        }
    });

    // ── Chart filter: show/hide custom date range ─────────────────────
    const chartPeriodSelect = document.getElementById('chart-period');
    const chartCustomRange  = document.getElementById('chart-custom-range');

    chartPeriodSelect.addEventListener('change', function () {
        const isCustom = this.value === 'custom';
        chartCustomRange.classList.toggle('hidden', !isCustom);
        chartCustomRange.classList.toggle('flex', isCustom);
    });

    // ── Fetch & update charts on Apply ───────────────────────────────
    document.getElementById('chart-apply').addEventListener('click', async function () {
        const period = chartPeriodSelect.value;
        const btn    = this;

        let url = chartDataUrl + '?period=' + encodeURIComponent(period);
        if (period === 'custom') {
            const start = document.getElementById('chart-start').value;
            const end   = document.getElementById('chart-end').value;
            if (!start || !end) { alert('Pilih tanggal mulai dan akhir.'); return; }
            url += '&start_date=' + encodeURIComponent(start) + '&end_date=' + encodeURIComponent(end);
        }

        btn.disabled = true;
        btn.style.opacity = '0.6';

        try {
            const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();

            revenueChart.data.labels                  = data.labels;
            revenueChart.data.datasets[0].data        = data.revenues;
            revenueChart.update();

            transactionChart.data.labels              = data.labels;
            transactionChart.data.datasets[0].data   = data.transactions;
            transactionChart.update();
        } catch (e) {
            console.error('Gagal mengambil data chart:', e);
        } finally {
            btn.disabled = false;
            btn.style.opacity = '1';
        }
    });
</script>
@endpush
