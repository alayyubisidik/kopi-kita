@extends('dashboard.layouts.app')

@section('title', 'Edit Option Group')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- ── Page Header / Breadcrumb ── --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-1 text-xs font-semibold" style="color:#4f453c;">
                <span style="color:#624528;">Dashboard</span>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <a href="{{ route('dashboard.option-groups.index') }}" style="color:#4f453c;" class="hover:underline">Manajemen Option Group</a>
                <span class="material-symbols-outlined" style="font-size:14px;color:#81756b;">chevron_right</span>
                <span style="color:#7a582f;">Edit Option Group</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color:#221a13;">Edit Option Group</h1>
            <p class="text-sm" style="color:#4f453c;">Perbarui informasi option group "{{ $optionGroup->name }}".</p>
        </div>

        <div class="self-start md:self-auto">
            <a href="{{ route('dashboard.option-groups.index') }}"
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
            <form novalidate method="POST" action="{{ route('dashboard.option-groups.update', $optionGroup) }}" x-data="{ selectionType: '{{ old('selection_type', $optionGroup->selection_type) }}' }">
                @csrf
                @method('PUT')

                <div class="p-6 flex flex-col gap-5">

                    {{-- Nama Option Group --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="name" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Nama Option Group</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $optionGroup->name) }}"
                            placeholder="contoh: Ukuran Cup"
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

                    {{-- Deskripsi --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="description" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Deskripsi <span class="font-normal normal-case" style="color:#81756b;">(opsional)</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Deskripsi singkat option group ini..."
                            class="w-full px-4 py-3 rounded-xl text-sm transition-all focus:outline-none resize-none @error('description') ring-2 ring-red-400 @enderror"
                            style="background:#fbebdf;color:#221a13;border:none;"
                            onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                            onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                        >{{ old('description', $optionGroup->description) }}</textarea>
                        @error('description')
                            <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe Seleksi --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="selection_type" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Tipe Seleksi</label>
                        <div class="relative">
                            <select
                                id="selection_type"
                                name="selection_type"
                                x-model="selectionType"
                                class="w-full h-11 appearance-none px-4 pr-9 rounded-xl text-sm transition-all focus:outline-none @error('selection_type') ring-2 ring-red-400 @enderror"
                                style="background:#fbebdf;color:#221a13;border:none;"
                                onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                                required
                            >
                                <option value="single">Single</option>
                                <option value="multiple">Multiple</option>
                            </select>
                            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[18px]" style="color:#81756b;">expand_more</span>
                        </div>
                        @error('selection_type')
                            <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Min / Max Seleksi (hanya untuk multiple) --}}
                    <div x-show="selectionType === 'multiple'" class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label for="min_selection" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Min Seleksi</label>
                            <input
                                type="number"
                                id="min_selection"
                                name="min_selection"
                                value="{{ old('min_selection', $optionGroup->min_selection) }}"
                                min="0"
                                class="w-full h-11 px-4 rounded-xl text-sm transition-all focus:outline-none @error('min_selection') ring-2 ring-red-400 @enderror"
                                style="background:#fbebdf;color:#221a13;border:none;"
                                onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                            >
                            @error('min_selection')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="max_selection" class="text-xs font-bold uppercase tracking-wider" style="color:#4f453c;">Max Seleksi</label>
                            <input
                                type="number"
                                id="max_selection"
                                name="max_selection"
                                value="{{ old('max_selection', $optionGroup->max_selection) }}"
                                min="0"
                                class="w-full h-11 px-4 rounded-xl text-sm transition-all focus:outline-none @error('max_selection') ring-2 ring-red-400 @enderror"
                                style="background:#fbebdf;color:#221a13;border:none;"
                                onfocus="this.style.background='#fff';this.style.boxShadow='0 0 0 2px #624528'"
                                onblur="this.style.background='#fbebdf';this.style.boxShadow='none'"
                            >
                            @error('max_selection')
                                <p class="text-xs font-medium" style="color:#ba1a1a;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="flex items-center gap-3 p-4 rounded-xl" style="background:#fbebdf;">
                        @php $isActive = old('is_active', $optionGroup->is_active); @endphp
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
                            <span class="text-sm font-semibold" style="color:#221a13;">Aktifkan Option Group</span>
                            <span class="text-xs" style="color:#81756b;">Option group aktif akan tampil di POS dan aplikasi pelanggan.</span>
                        </div>
                    </div>

                    {{-- Wajib Dipilih --}}
                    <div class="flex items-center gap-3 p-4 rounded-xl" style="background:#fbebdf;">
                        @php $isRequired = old('is_required', $optionGroup->is_required); @endphp
                        <label for="is_required"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-300 cursor-pointer"
                            style="background:{{ $isRequired ? '#624528' : '#d3c4b8' }};">
                            <input
                                type="checkbox"
                                id="is_required"
                                name="is_required"
                                value="1"
                                {{ $isRequired ? 'checked' : '' }}
                                class="sr-only"
                                onchange="
                                    this.parentElement.style.background = this.checked ? '#624528' : '#d3c4b8';
                                    this.nextElementSibling.style.transform = this.checked ? 'translateX(1.5rem)' : 'translateX(0.25rem)';
                                "
                            >
                            <span class="inline-block h-4 w-4 rounded-full bg-white shadow transition-transform duration-300"
                                  style="transform: {{ $isRequired ? 'translateX(1.5rem)' : 'translateX(0.25rem)' }};"></span>
                        </label>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold" style="color:#221a13;">Wajib Dipilih</span>
                            <span class="text-xs" style="color:#81756b;">Pelanggan harus memilih opsi ini sebelum menambahkan ke keranjang.</span>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 flex items-center justify-end gap-3" style="border-top:1px solid rgba(129,117,107,0.12);background:#fbebdf33;">
                    <a href="{{ route('dashboard.option-groups.index') }}"
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
                        Perbarui Option Group
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection