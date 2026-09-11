@extends('dashboard.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- ── Page Header / Breadcrumb ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-1 text-xs font-semibold" style="color:#4f453c;">
                <span style="color:#624528;">Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <a href="{{ route('dashboard.products.index') }}" style="color:#4f453c;" class="hover:underline">Manajemen Produk</a>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <span style="color:#7a582f;">Edit Produk</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color:#221a13;">Edit Produk</h1>
            <p class="text-sm" style="color:#4f453c;">Perbarui informasi dan pengaturan produk menu.</p>
        </div>

        <div class="self-start md:self-auto">
            <a href="{{ route('dashboard.products.index') }}"
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
            <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Left Column - Basic Info --}}
                    <div class="flex flex-col gap-5">
                        <h2 class="text-xs font-bold uppercase tracking-wider pb-2" style="color:#7a582f;border-bottom:1px solid rgba(129,117,107,0.12);">
                            Informasi Dasar
                        </h2>

                        {{-- Nama Produk --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="name" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">
                                Nama Produk <span style="color:#ba1a1a;">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                placeholder="contoh: Kopi Susu Gula Aren"
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

                        {{-- Kategori --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="category_id" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">
                                Kategori <span style="color:#ba1a1a;">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="w-full h-11 appearance-none pl-4 pr-9 rounded-xl text-sm focus:outline-none transition-all cursor-pointer @error('category_id') ring-2 ring-red-400 @enderror"
                                    style="background:#fbebdf;color:#221a13;border:none;"
                                    onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                    onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-[18px]" style="color:#81756b;">expand_more</span>
                            </div>
                            @error('category_id')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="price" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">
                                Harga (Rp) <span style="color:#ba1a1a;">*</span>
                            </label>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                min="0"
                                step="1"
                                value="{{ old('price', (int) $product->price) }}"
                                placeholder="0"
                                class="w-full h-11 px-4 rounded-xl text-sm transition-all focus:outline-none @error('price') ring-2 ring-red-400 @enderror"
                                style="background:#fbebdf;color:#221a13;border:none;"
                                onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                                required
                            >
                            @error('price')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="description" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">
                                Deskripsi <span class="font-normal normal-case" style="color:#81756b;">(opsional)</span>
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Deskripsi singkat produk ini..."
                                class="w-full px-4 py-3 rounded-xl text-sm transition-all focus:outline-none resize-none @error('description') ring-2 ring-red-400 @enderror"
                                style="background:#fbebdf;color:#221a13;border:none;"
                                onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                            >{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="flex flex-col gap-1.5" x-data="{ imagePreview: @js($product->hasMedia('product-images') ? $product->image_url : null) }">
                            <label class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Gambar Produk</label>

                            <div class="relative overflow-hidden rounded-xl px-6 py-10" style="border:2px dashed #e3d2c2;background:#fbebdf;">

                                {{-- Preview --}}
                                <div x-show="imagePreview" class="absolute inset-0 z-10 h-full w-full bg-white p-1" style="display:{{ $product->hasMedia('product-images') ? 'block' : 'none' }};">
                                    <img :src="imagePreview" class="h-full w-full object-contain rounded-lg">
                                    <button
                                        type="button"
                                        @click="imagePreview = null; $refs.productImageInput.value = ''"
                                        class="absolute right-2 top-2 w-7 h-7 flex items-center justify-center rounded-full transition-all"
                                        style="background:#f5e5d9;color:#624528;"
                                        onmouseover="this.style.background='#624528';this.style.color='#fff'"
                                        onmouseout="this.style.background='#f5e5d9';this.style.color='#624528'"
                                        title="Ganti gambar"
                                    >
                                        <span class="material-symbols-outlined" style="font-size:16px;">edit</span>
                                    </button>
                                </div>

                                {{-- Upload UI --}}
                                <label x-show="!imagePreview" for="image" class="flex cursor-pointer flex-col items-center justify-center text-center" style="display:{{ $product->hasMedia('product-images') ? 'none' : 'flex' }};">
                                    <span class="material-symbols-outlined mb-2" style="font-size:40px;color:#624528;">cloud_upload</span>
                                    <span class="text-sm font-bold" style="color:#4f453c;">Klik untuk upload</span>
                                    <span class="mt-1 text-xs" style="color:#81756b;">JPG, PNG, WEBP maksimal 2MB</span>
                                    <input
                                        id="image" name="image" type="file" accept="image/*" class="hidden"
                                        x-ref="productImageInput"
                                        @change="
                                            const file = $event.target.files[0];
                                            if (file) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => { imagePreview = e.target.result; };
                                                reader.readAsDataURL(file);
                                            }
                                        "
                                    >
                                </label>
                            </div>
                            <p class="text-xs" style="color:#81756b;">Kosongkan untuk mempertahankan gambar saat ini.</p>
                            @error('image')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Column - Settings & Customization --}}
                    <div class="flex flex-col gap-5">
                        <h2 class="text-xs font-bold uppercase tracking-wider pb-2" style="color:#7a582f;border-bottom:1px solid rgba(129,117,107,0.12);">
                            Pengaturan & Kustomisasi
                        </h2>

                        {{-- Toggle Tersedia --}}
                        <div class="flex items-center gap-3">
                            @php $isAvailable = old('is_available', $product->is_available); @endphp
                            <input type="hidden" name="is_available" value="0">
                            <label for="is_available"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 cursor-pointer flex-shrink-0"
                                style="background:{{ $isAvailable ? '#624528' : '#d3c4b8' }};">
                                <input
                                    type="checkbox"
                                    id="is_available"
                                    name="is_available"
                                    value="1"
                                    {{ $isAvailable ? 'checked' : '' }}
                                    class="sr-only"
                                    onchange="
                                        this.parentElement.style.background = this.checked ? '#624528' : '#d3c4b8';
                                        this.nextElementSibling.style.transform = this.checked ? 'translateX(1.5rem)' : 'translateX(0.25rem)';
                                    "
                                >
                                <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition-transform duration-300"
                                      style="transform: {{ $isAvailable ? 'translateX(1.5rem)' : 'translateX(0.25rem)' }};"></span>
                            </label>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold" style="color:#221a13;">Tersedia</span>
                                <span class="text-xs" style="color:#81756b;">Produk dapat dipesan oleh pelanggan.</span>
                            </div>
                        </div>

                        {{-- Toggle Customizable --}}
                        <div class="flex items-center gap-3">
                            @php $isCustomizable = old('is_customizable', $product->is_customizable); @endphp
                            <input type="hidden" name="is_customizable" value="0">
                            <label for="is_customizable"
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 cursor-pointer flex-shrink-0"
                                style="background:{{ $isCustomizable ? '#624528' : '#d3c4b8' }};">
                                <input
                                    type="checkbox"
                                    id="is_customizable"
                                    name="is_customizable"
                                    value="1"
                                    {{ $isCustomizable ? 'checked' : '' }}
                                    class="sr-only"
                                    onchange="
                                        this.parentElement.style.background = this.checked ? '#624528' : '#d3c4b8';
                                        this.nextElementSibling.style.transform = this.checked ? 'translateX(1.5rem)' : 'translateX(0.25rem)';
                                        toggleCustomization();
                                    "
                                >
                                <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition-transform duration-300"
                                      style="transform: {{ $isCustomizable ? 'translateX(1.5rem)' : 'translateX(0.25rem)' }};"></span>
                            </label>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold" style="color:#221a13;">Dapat Dikustomisasi</span>
                                <span class="text-xs" style="color:#81756b;">Memiliki opsi seperti Ukuran, Gula, dll.</span>
                            </div>
                        </div>

                        {{-- Option Groups --}}
                        @php
                            $selectedGroups = old('option_groups', $product->optionGroups->pluck('id')->toArray());
                        @endphp

                        <div id="customization_section"
                             class="rounded-xl p-4 {{ old('is_customizable', $product->is_customizable) ? '' : 'hidden' }}"
                             style="background:#fbebdf;">
                            <h3 class="text-xs font-bold uppercase tracking-wider mb-3" style="color:#4f453c;">Pilih Grup Opsi</h3>

                            @if($optionGroups->isEmpty())
                                <p class="text-sm italic" style="color:#81756b;">Belum ada grup opsi. Buat terlebih dahulu.</p>
                            @else
                                <div class="flex flex-col gap-1 max-h-60 overflow-y-auto pr-1">
                                    @foreach($optionGroups as $group)
                                        <label for="group_{{ $group->id }}"
                                            class="flex items-center justify-between p-2.5 rounded-lg cursor-pointer transition-colors"
                                            style="background:#fff;"
                                            onmouseover="this.style.background='#f5e5d9'" onmouseout="this.style.background='#fff'">
                                            <div class="flex items-center gap-2">
                                                <input id="group_{{ $group->id }}" name="option_groups[]" type="checkbox" value="{{ $group->id }}"
                                                       class="h-4 w-4 rounded"
                                                       style="accent-color:#624528;"
                                                       {{ in_array($group->id, $selectedGroups) ? 'checked' : '' }}>
                                                <span class="text-sm font-medium" style="color:#221a13;">{{ $group->name }}</span>
                                            </div>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md" style="background:#f5e5d9;color:#7a582f;">
                                                {{ ucfirst($group->selection_type) }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('option_groups')
                                    <p class="text-xs font-medium mt-2" style="color:#ba1a1a;">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 flex items-center justify-end gap-3" style="border-top:1px solid rgba(129,117,107,0.12);background:#fbebdf33;">
                    <a href="{{ route('dashboard.products.index') }}"
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
                        Update Produk
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function toggleCustomization() {
        const checkbox = document.getElementById('is_customizable');
        const section = document.getElementById('customization_section');

        if (checkbox.checked) {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
            // Tidak menghapus centang saat edit, agar tidak hilang sebelum disimpan
        }
    }

    // Panggil saat load halaman untuk set state awal
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomization();

        // Tampilkan nama file yang dipilih pada input gambar
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                const label = imageInput.previousElementSibling;
                if (this.files && this.files[0]) {
                    label.querySelector('span.font-semibold').textContent = this.files[0].name;
                }
            });
        }
    });
</script>
@endpush
@endsection