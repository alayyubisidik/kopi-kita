@extends('dashboard.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- ── Page Header / Breadcrumb ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-1 text-xs font-semibold" style="color:#4f453c;">
                <span style="color:#624528;">Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <a href="{{ route('dashboard.categories.index') }}" style="color:#4f453c;" class="hover:underline">Manajemen Kategori</a>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <span style="color:#7a582f;">Tambah Kategori</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color:#221a13;">Tambah Kategori</h1>
            <p class="text-sm" style="color:#4f453c;">Buat kategori baru untuk mengelompokkan produk menu.</p>
        </div>

        <div class="self-start md:self-auto">
            <a href="{{ route('dashboard.categories.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all"
               style="background:#fbebdf;color:#4f453c;"
               onmouseover="this.style.background='#f5e5d9'" onmouseout="this.style.background='#fbebdf'">
                <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── Form Card ── --}}
    <div>
        <div class="rounded-2xl overflow-hidden" style="background:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.10);">
            <form method="POST" action="{{ route('dashboard.categories.store') }}" x-data="{ name: '' }" novalidate>
                @csrf

                <div class="p-6 flex flex-col gap-5">

                    {{-- Nama Kategori --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="name" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Nama Kategori</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            x-model="name"
                            placeholder="contoh: Espresso Based"
                            class="w-full h-11 px-4 rounded-xl text-sm transition-all focus:outline-none @error('name') ring-2 ring-red-400 @enderror"
                            style="background:#fbebdf;color:#221a13;border:none;"
                            onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                            onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                            required
                        >
                        @error('name')
                            <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="slug" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Slug</label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            x-model="name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                            placeholder="auto-generated dari nama"
                            class="w-full h-11 px-4 rounded-xl text-sm transition-all focus:outline-none @error('slug') ring-2 ring-red-400 @enderror"
                            style="background:#fbebdf;color:#221a13;border:none;"
                            onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                            onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                            required
                        >
                        @error('slug')
                            <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                        <p class="text-xs" style="color:#81756b;">Otomatis diisi dari nama. Bisa diedit manual jika perlu.</p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="description" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Deskripsi <span class="font-normal normal-case" style="color:#81756b;">(opsional)</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Deskripsi singkat kategori ini..."
                            class="w-full px-4 py-3 rounded-xl text-sm transition-all focus:outline-none resize-none @error('description') ring-2 ring-red-400 @enderror"
                            style="background:#fbebdf;color:#221a13;border:none;"
                            onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                            onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3">
                        @php $isActive = old('is_active', true); @endphp
                        <label for="is_active"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 cursor-pointer"
                            style="background:{{ $isActive ? '#624528' : '#d3c4b8' }};">
                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ $isActive ? 'checked' : '' }}
                                class="sr-only"
                                onchange="
                                    this.parentElement.style.background = this.checked ? '#624528' : '#d3c4b8';
                                    this.nextElementSibling.style.transform = this.checked ? 'translateX(1.5rem)' : 'translateX(0.25rem)';
                                "
                            >
                            <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition-transform duration-300"
                                  style="transform: {{ $isActive ? 'translateX(1.5rem)' : 'translateX(0.25rem)' }};"></span>
                        </label>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold" style="color:#221a13;">Aktifkan Kategori</span>
                            <span class="text-xs" style="color:#81756b;">Kategori aktif akan tampil di POS dan aplikasi pelanggan.</span>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 flex items-center justify-end gap-3" style="border-top:1px solid rgba(129,117,107,0.12);background:#fbebdf33;">
                    <a href="{{ route('dashboard.categories.index') }}"
                       class="h-10 px-5 rounded-xl text-sm font-semibold flex items-center transition-all"
                       style="background:#fbebdf;color:#4f453c;"
                       onmouseover="this.style.background='#f5e5d9'" onmouseout="this.style.background='#fbebdf'">
                        Batal
                    </a>
                    <button type="submit"
                        class="h-10 px-6 rounded-xl text-sm font-semibold transition-all flex items-center gap-2"
                        style="background:#624528;color:#fff;box-shadow:0 4px 14px -2px rgba(124,92,62,0.25);"
                        onmouseover="this.style.background='#7a582f'" onmouseout="this.style.background='#624528'">
                        <span class="material-symbols-outlined" style="font-size:18px;">save</span>
                        Simpan Kategori
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
