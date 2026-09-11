@extends('dashboard.layouts.app')

@section('title', 'Manajemen Option Group')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col w-full gap-6">

    {{-- ── Page Header / Breadcrumb ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-1 text-xs font-semibold" style="color:#4f453c;">
                <span style="color:#624528;">Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <span style="color:#7a582f;">Manajemen Option Group</span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-extrabold tracking-tight" style="color:#221a13;">Daftar Option Group</h1>
            </div>
            <p class="text-sm" style="color:#4f453c;">Kelola grup opsi kustomisasi produk menu Kopi Kita secara terpusat.</p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 self-start md:self-auto">
            <a href="{{ route('dashboard.option-groups.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md"
               style="background:#624528;color:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.30);"
               onmouseover="this.style.background='#7a582f'" onmouseout="this.style.background='#624528'">
                <span class="material-symbols-outlined" style="font-size:20px;">add_circle</span>
                Tambah Option Group
            </a>
        </div>
    </div>


    {{-- ── Filter & Search Bar ── --}}
    <div class="rounded-2xl p-4" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.08);">
        <form method="GET" class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <div class="relative min-w-[220px] flex-1 max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px]" style="color:#81756b;">search</span>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari option group..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl text-sm transition-all focus:outline-none"
                    style="background:#fbebdf;color:#221a13;border:none;"
                    onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                    onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                >
            </div>

            {{-- Status Filter --}}
            <div class="relative">
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="h-11 appearance-none pl-4 pr-9 rounded-xl text-sm focus:outline-none transition-all cursor-pointer"
                    style="background:#fbebdf;color:#221a13;border:none;"
                    onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                    onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                >
                    <option value="" {{ $status->toString() === '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $status->toString() === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ $status->toString() === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <span class="material-symbols-outlined pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-[18px]" style="color:#81756b;">expand_more</span>
            </div>

            {{-- Selection Type Filter --}}
            <div class="relative">
                <select
                    name="selection_type"
                    onchange="this.form.submit()"
                    class="h-11 appearance-none pl-4 pr-9 rounded-xl text-sm focus:outline-none transition-all cursor-pointer"
                    style="background:#fbebdf;color:#221a13;border:none;"
                    onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                    onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                >
                    <option value="" {{ $selectionType->toString() === '' ? 'selected' : '' }}>Semua Tipe</option>
                    <option value="single" {{ $selectionType->toString() === 'single' ? 'selected' : '' }}>Single</option>
                    <option value="multiple" {{ $selectionType->toString() === 'multiple' ? 'selected' : '' }}>Multiple</option>
                </select>
                <span class="material-symbols-outlined pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-[18px]" style="color:#81756b;">expand_more</span>
            </div>

            {{-- Tombol Cari --}}
            <button type="submit"
                class="h-11 px-5 rounded-xl text-sm font-semibold transition-all"
                style="background:#624528;color:#fff;"
                onmouseover="this.style.background='#7a582f'" onmouseout="this.style.background='#624528'">
                Cari
            </button>

            {{-- Reset --}}
            @if($search->isNotEmpty() || $status->isNotEmpty() || $selectionType->isNotEmpty())
                <a href="{{ route('dashboard.option-groups.index') }}"
                   class="h-11 px-4 rounded-xl text-sm font-semibold flex items-center gap-1.5 transition-all"
                   style="background:#fbebdf;color:#4f453c;"
                   onmouseover="this.style.background='#f5e5d9'" onmouseout="this.style.background='#fbebdf'">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                    Reset
                </a>
            @endif

        </form>
    </div>

    {{-- ── Data Table ── --}}
    <div class="rounded-2xl overflow-hidden" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                {{-- Head --}}
                <thead>
                    <tr style="background:#f5e5d9;">
                        <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Nama</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider" style="color:#4f453c;">Tipe Seleksi</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-center" style="color:#4f453c;">Status</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-center" style="color:#4f453c;">Wajib</th>
                        <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-right" style="color:#4f453c;">Aksi</th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody>
                    @forelse($optionGroups as $optionGroup)
                        <tr class="group transition-colors" style="border-top:1px solid rgba(129,117,107,0.12);"
                            onmouseover="this.style.background='rgba(251,235,223,0.5)'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Nama --}}
                            <td class="py-4 px-6">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm font-semibold" style="color:#221a13;">{{ $optionGroup->name }}</span>
                                    <span class="text-xs" style="color:#81756b;">{{ $optionGroup->options_count }} Option &mdash; {{ $optionGroup->products_count }} Produk</span>
                                </div>
                            </td>

                            {{-- Tipe Seleksi --}}
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[12px] font-semibold"
                                    style="background:{{ $optionGroup->selection_type === 'single' ? '#fbebdf' : '#f0e6fb' }};color:{{ $optionGroup->selection_type === 'single' ? '#7a582f' : '#5b3a91' }};">
                                    {{ $optionGroup->selection_type === 'single' ? 'Single' : 'Multiple' }}
                                </span>
                                @if($optionGroup->selection_type === 'multiple')
                                    <div class="text-xs mt-1" style="color:#81756b;">
                                        @if($optionGroup->min_selection)
                                            Min: {{ $optionGroup->min_selection }}
                                        @endif
                                        @if($optionGroup->max_selection)
                                            Max: {{ $optionGroup->max_selection }}
                                        @endif
                                    </div>
                                @endif
                            </td>

                            {{-- Toggle Status --}}
                            <td class="py-4 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <form method="POST" action="{{ route('dashboard.option-groups.toggle-active', $optionGroup) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 focus:outline-none"
                                            style="background:{{ $optionGroup->is_active ? '#624528' : '#d3c4b8' }};"
                                            title="{{ $optionGroup->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-300 {{ $optionGroup->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                    @if($optionGroup->is_active)
                                        <span class="text-[10px] font-bold uppercase tracking-wide" style="color:#624528;">Aktif</span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-wide" style="color:#81756b;">Nonaktif</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Toggle Wajib --}}
                            <td class="py-4 px-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <form method="POST" action="{{ route('dashboard.option-groups.toggle-required', $optionGroup) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 focus:outline-none"
                                            style="background:{{ $optionGroup->is_required ? '#624528' : '#d3c4b8' }};"
                                            title="{{ $optionGroup->is_required ? 'Jadikan Tidak Wajib' : 'Jadikan Wajib' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-300 {{ $optionGroup->is_required ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                    @if($optionGroup->is_required)
                                        <span class="text-[10px] font-bold uppercase tracking-wide" style="color:#624528;">Wajib</span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-wide" style="color:#81756b;">Opsional</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-1">
                                    {{-- Kelola --}}
                                    <a href="{{ route('dashboard.option-groups.manage', $optionGroup) }}"
                                       class="p-2 rounded-lg transition-colors"
                                       style="color:#4f453c;"
                                       onmouseover="this.style.background='#fbebdf'" onmouseout="this.style.background='transparent'"
                                       title="Kelola Opsi">
                                        <span class="material-symbols-outlined" style="font-size:20px;">tune</span>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('dashboard.option-groups.edit', $optionGroup) }}"
                                       class="p-2 rounded-lg transition-colors"
                                       style="color:#624528;"
                                       onmouseover="this.style.background='#fbebdf'" onmouseout="this.style.background='transparent'"
                                       title="Edit Option Group">
                                        <span class="material-symbols-outlined" style="font-size:20px;">edit</span>
                                    </a>

                                    {{-- Hapus --}}
                                    <form method="POST" action="{{ route('dashboard.option-groups.destroy', $optionGroup) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="p-2 rounded-lg transition-colors delete-btn"
                                            style="color:#ba1a1a;"
                                            onmouseover="this.style.background='#ffdad6'" onmouseout="this.style.background='transparent'"
                                            title="Hapus Option Group">
                                            <span class="material-symbols-outlined" style="font-size:20px;">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background:#fbebdf;">
                                        <span class="material-symbols-outlined" style="font-size:28px;color:#81756b;">tune</span>
                                    </div>
                                    <p class="text-sm font-semibold" style="color:#4f453c;">Tidak ada option group ditemukan.</p>
                                    <a href="{{ route('dashboard.option-groups.create') }}"
                                       class="text-sm font-semibold underline" style="color:#624528;">
                                        Tambah option group pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($optionGroups->hasPages())
            <div class="px-6 py-4" style="border-top:1px solid rgba(129,117,107,0.12);">
                {{ $optionGroups->links() }}
            </div>
        @endif
    </div>

</div>
@endsection