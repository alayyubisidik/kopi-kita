@extends('customer.layouts.customer')

{{-- Sembunyikan bottom nav, ganti dengan sticky CTA --}}
@section('hide-bottom-nav')@endsection

@section('title', $product->name . ' — Kopi Kita')
@section('meta_description', $product->description ?? 'Detail menu ' . $product->name . ' di Kopi Kita.')
@section('page-title', 'Detail Produk')

@section('content')
<div class="flex flex-col w-full pb-32"
     x-data="{
         basePrice: {{ (float) $product->price }},
         selectedOptions: {},
         quantity: 1,
         note: '',
         maxNote: 100,

         init() {
             @foreach($product->optionGroups as $group)
             this.selectedOptions[{{ $group->id }}] = @if($group->selection_type === 'single') null @else [] @endif;
             @endforeach
         },

         toggleCheckbox(groupId, optionId, additionalPrice, name) {
             const selected = this.selectedOptions[groupId];
             const idx = selected.findIndex(o => o.id === optionId);
             if (idx === -1) {
                 selected.push({ id: optionId, price: additionalPrice, name: name });
             } else {
                 selected.splice(idx, 1);
             }
         },

         isChecked(groupId, optionId) {
             return this.selectedOptions[groupId].some(o => o.id === optionId);
         },

         setRadio(groupId, optionId, additionalPrice, name) {
             this.selectedOptions[groupId] = { id: optionId, price: additionalPrice, name: name };
         },

         isRadioSelected(groupId, optionId) {
             return this.selectedOptions[groupId] && this.selectedOptions[groupId].id === optionId;
         },

         additionalTotal() {
             let total = 0;
             for (const groupId in this.selectedOptions) {
                 const val = this.selectedOptions[groupId];
                 if (Array.isArray(val)) {
                     val.forEach(o => total += o.price);
                 } else if (val) {
                     total += val.price;
                 }
             }
             return total;
         },

         itemTotal() {
             return this.basePrice + this.additionalTotal();
         },

         grandTotal() {
             return this.itemTotal() * this.quantity;
         },

         formatRupiah(amount) {
             return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
         },

         increment() { if (this.quantity < 20) this.quantity++; },
         decrement() { if (this.quantity > 1) this.quantity--; },

         selectedOptionsList() {
             const list = [];
             for (const groupId in this.selectedOptions) {
                 const val = this.selectedOptions[groupId];
                 if (Array.isArray(val)) {
                     val.forEach(o => list.push(o));
                 } else if (val) {
                     list.push(val);
                 }
             }
             return list;
         },

         requiredGroups: @json($product->optionGroups->where('is_required', true)->pluck('id')),

         validateAndSubmit(e) {
             for (const groupId of this.requiredGroups) {
                 const val = this.selectedOptions[groupId];
                 const isEmpty = Array.isArray(val) ? val.length === 0 : val === null || val === undefined;
                 if (isEmpty) {
                     e.preventDefault();
                     alert('Silakan pilih semua pilihan yang wajib dipilih sebelum menambahkan ke keranjang.');
                     return;
                 }
             }
         }
     }">

    {{-- Back Button --}}
    <div class="pt-space-sm pb-space-xs flex items-center justify-between">
        <a href="{{ route('customer.menu') }}"
           class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full bg-surface-container-low text-primary-container font-label-md text-label-md active:scale-95 transition-transform hover:bg-surface-container">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Menu</span>
        </a>
    </div>

    <form action="{{ route('cart.store') }}" method="POST" x-on:submit="validateAndSubmit($event)">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" :value="quantity">
        <input type="hidden" name="note" :value="note">

        <div class="bg-surface-container-lowest rounded-xl shadow-[0_4px_20px_-2px_rgba(124,92,62,0.08)] overflow-hidden flex flex-col">

            {{-- Product Image --}}
            <div class="relative w-full aspect-[16/9] bg-surface-container-high overflow-hidden">
                @if($product->hasMedia('product-images'))
                    <img src="{{ $product->getFirstMediaUrl('product-images') }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined text-[64px] opacity-30">coffee</span>
                    </div>
                @endif
                {{-- Gradient overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                {{-- Unavailable overlay --}}
                @if(!$product->is_available)
                    <div class="absolute inset-0 bg-surface/70 flex items-center justify-center">
                        <span class="bg-inverse-surface text-inverse-on-surface px-4 py-2 rounded-full font-label-lg text-label-lg">
                            Tidak Tersedia
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-space-md flex flex-col gap-space-md">

                {{-- Product Info --}}
                <div class="flex flex-col gap-1">
                    @if($product->category)
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                    @endif
                    <h1 class="font-headline-md text-headline-md text-on-surface font-extrabold tracking-tight">
                        {{ $product->name }}
                    </h1>
                    @if($product->description)
                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                            {{ $product->description }}
                        </p>
                    @endif
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="font-headline-lg text-headline-lg text-primary-container font-extrabold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Unavailable Notice --}}
                @if(!$product->is_available)
                    <div class="p-3 bg-error-container text-on-error-container rounded-lg font-body-sm text-body-sm text-center">
                        Produk ini sedang tidak tersedia untuk dipesan.
                    </div>
                @endif

                {{-- Option Groups --}}
                @if($product->is_customizable && $product->optionGroups->isNotEmpty())
                    @foreach($product->optionGroups as $group)
                        <div class="h-[1px] bg-surface-container w-full"></div>

                        <div class="flex flex-col gap-space-xs">
                            {{-- Group Header --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-label-lg text-label-lg text-on-surface font-bold">
                                        {{ $group->name }}
                                    </span>
                                    @if($group->is_required)
                                        <span class="bg-secondary-container text-on-secondary-container font-label-sm text-label-sm px-2 py-0.5 rounded-full uppercase tracking-wider">Wajib</span>
                                    @else
                                        <span class="bg-surface-container text-on-surface-variant font-label-sm text-label-sm px-2 py-0.5 rounded-full">Opsional</span>
                                    @endif
                                </div>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">
                                    @if($group->selection_type === 'single')
                                        Pilih 1
                                    @elseif($group->min_selection > 0 && $group->max_selection)
                                        Pilih {{ $group->min_selection }}–{{ $group->max_selection }}
                                    @elseif($group->min_selection > 0)
                                        Min. {{ $group->min_selection }}
                                    @elseif($group->max_selection)
                                        Maks. {{ $group->max_selection }}
                                    @else
                                        Bisa pilih lebih dari 1
                                    @endif
                                </span>
                            </div>

                            {{-- Options --}}
                            @if($group->selection_type === 'single')
                                {{-- Radio group --}}
                                <div class="grid grid-cols-1 gap-2 pt-1">
                                    @foreach($group->options as $option)
                                        <label class="relative flex items-center justify-between p-3 rounded-lg cursor-pointer transition-all active:scale-[0.99] select-none
                                                      {{ !$option->is_available ? 'opacity-50 cursor-not-allowed' : '' }}"
                                               :class="isRadioSelected({{ $group->id }}, {{ $option->id }})
                                                   ? 'bg-surface-container-low'
                                                   : 'bg-surface-container-lowest hover:bg-surface-container-low/50'">
                                            <input type="radio"
                                                   name="options[{{ $group->id }}]"
                                                   value="{{ $option->id }}"
                                                   {{ !$option->is_available ? 'disabled' : '' }}
                                                   @if($group->is_required && $group->min_selection >= 1) required @endif
                                                   x-on:change="setRadio({{ $group->id }}, {{ $option->id }}, {{ (float) $option->additional_price }}, '{{ addslashes($option->name) }}')"
                                                   :checked="isRadioSelected({{ $group->id }}, {{ $option->id }})"
                                                   class="sr-only">
                                            <div class="flex items-center gap-3">
                                                {{-- Custom radio indicator --}}
                                                <div class="w-5 h-5 rounded-full flex items-center justify-center shadow-sm transition-colors"
                                                     :class="isRadioSelected({{ $group->id }}, {{ $option->id }})
                                                         ? 'bg-primary-container'
                                                         : 'bg-surface-container-high'">
                                                    <div class="w-2 h-2 rounded-full transition-colors"
                                                         :class="isRadioSelected({{ $group->id }}, {{ $option->id }})
                                                             ? 'bg-surface-container-lowest'
                                                             : 'bg-transparent'">
                                                    </div>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-label-lg text-label-lg text-on-surface font-semibold">
                                                        {{ $option->name }}
                                                        @if(!$option->is_available)
                                                            <span class="font-label-sm text-label-sm text-outline font-normal">(Tidak tersedia)</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="font-label-md text-label-md font-bold"
                                                  :class="isRadioSelected({{ $group->id }}, {{ $option->id }}) ? 'text-primary-container' : 'text-on-surface'">
                                                {{ $option->additional_price > 0 ? '+Rp ' . number_format($option->additional_price, 0, ',', '.') : 'Termasuk' }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                {{-- Checkbox group --}}
                                <div class="flex flex-col gap-2 pt-1">
                                    @foreach($group->options as $option)
                                        <label class="flex items-center justify-between p-3 rounded-lg cursor-pointer select-none transition-all active:scale-[0.99]
                                                      {{ !$option->is_available ? 'opacity-50 cursor-not-allowed' : '' }}"
                                               :class="isChecked({{ $group->id }}, {{ $option->id }})
                                                   ? 'bg-surface-container-low'
                                                   : 'bg-surface-container-lowest hover:bg-surface-container-low/50'">
                                            <input type="checkbox"
                                                   name="options[{{ $group->id }}][]"
                                                   value="{{ $option->id }}"
                                                   {{ !$option->is_available ? 'disabled' : '' }}
                                                   x-on:change="toggleCheckbox({{ $group->id }}, {{ $option->id }}, {{ (float) $option->additional_price }}, '{{ addslashes($option->name) }}')"
                                                   :checked="isChecked({{ $group->id }}, {{ $option->id }})"
                                                   class="sr-only">
                                            <div class="flex items-center gap-3">
                                                {{-- Custom checkbox --}}
                                                <div class="w-5 h-5 rounded flex items-center justify-center transition-colors"
                                                     :class="isChecked({{ $group->id }}, {{ $option->id }})
                                                         ? 'bg-primary-container text-on-primary'
                                                         : 'bg-surface-container-high text-transparent'">
                                                    <span class="material-symbols-outlined text-[16px] leading-none font-bold">check</span>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-label-md text-label-md text-on-surface font-semibold">
                                                        {{ $option->name }}
                                                        @if(!$option->is_available)
                                                            <span class="font-label-sm text-label-sm text-outline font-normal">(Tidak tersedia)</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="font-label-md text-label-md text-primary-container font-bold">
                                                {{ $option->additional_price > 0 ? '+Rp ' . number_format($option->additional_price, 0, ',', '.') : 'Gratis' }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

                <div class="h-[1px] bg-surface-container w-full"></div>

                {{-- Quantity --}}
                <div class="flex items-center justify-between py-1">
                    <div class="flex flex-col">
                        <span class="font-label-lg text-label-lg text-on-surface font-bold">Jumlah Pesanan</span>
                    </div>
                    <div class="inline-flex items-center bg-surface-container-low rounded-full p-1 gap-3 shadow-inner">
                        <button type="button"
                                x-on:click="decrement()"
                                :disabled="quantity <= 1"
                                class="w-8 h-8 rounded-full bg-surface-container-lowest text-on-surface flex items-center justify-center active:scale-90 transition-transform disabled:opacity-40"
                                aria-label="Kurangi jumlah">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold tabular-nums min-w-[20px] text-center"
                              x-text="quantity">1</span>
                        <button type="button"
                                x-on:click="increment()"
                                class="w-8 h-8 rounded-full bg-primary-container text-on-primary flex items-center justify-center active:scale-90 transition-transform shadow-sm"
                                aria-label="Tambah jumlah">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </button>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="flex flex-col gap-1.5">
                    <label class="font-label-md text-label-md text-on-surface font-semibold flex items-center justify-between" for="order-notes">
                        <span>Catatan untuk Barista</span>
                        <span class="font-body-sm text-body-sm text-outline font-normal">Opsional</span>
                    </label>
                    <div class="relative">
                        <textarea
                            id="order-notes"
                            x-model="note"
                            :maxlength="maxNote"
                            rows="3"
                            placeholder="Contoh: Kurangi es batu, pisahkan gula..."
                            class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary-container p-3.5 pb-7 rounded-xl font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none transition-colors min-h-[96px] resize-none"></textarea>
                        <div class="absolute bottom-2.5 right-3 font-label-sm text-[11px] text-outline">
                            <span x-text="note.length">0</span>/100
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="bg-surface-container-low rounded-xl p-space-md flex flex-col gap-2.5">
                    {{-- Base price --}}
                    <div class="flex items-center justify-between text-on-surface-variant font-body-md text-body-md">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-primary-container">receipt_long</span>
                            <span>{{ $product->name }}</span>
                        </span>
                        <span class="tabular-nums font-semibold text-on-surface"
                              x-text="formatRupiah(basePrice)">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Selected options --}}
                    <template x-for="opt in selectedOptionsList()" :key="opt.id">
                        <div class="flex items-center justify-between text-on-surface-variant font-body-md text-body-md">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary-container">add_circle</span>
                                <span x-text="opt.name"></span>
                            </span>
                            <span class="tabular-nums font-semibold text-on-surface"
                                  x-text="'+' + formatRupiah(opt.price)"></span>
                        </div>
                    </template>

                    {{-- Qty multiplier (shown when qty > 1) --}}
                    <div class="flex items-center justify-between text-on-surface-variant font-body-md text-body-md"
                         x-show="quantity > 1">
                        <span>Pengali Jumlah</span>
                        <span class="tabular-nums font-semibold text-on-surface" x-text="'× ' + quantity"></span>
                    </div>

                    <div class="h-[1px] bg-surface-container-high w-full my-0.5"></div>

                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-primary-container uppercase font-extrabold tracking-wider whitespace-nowrap">
                            Total Pembayaran
                        </span>
                        <span class="font-headline-sm text-headline-sm text-primary-container font-extrabold tabular-nums whitespace-nowrap"
                              x-text="formatRupiah(grandTotal())">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Sticky Add to Cart CTA --}}
        <div class="fixed bottom-0 inset-x-0 z-50 pb-safe bg-surface/95 backdrop-blur-xl shadow-[0_-4px_20px_rgba(124,92,62,0.08)]">
            <div class="max-w-[24.375rem] mx-auto px-space-md py-3">
                @if($product->is_available)
                    <button type="submit"
                            class="w-full bg-primary-container text-on-primary py-3.5 px-space-md rounded-lg font-label-lg text-label-lg flex items-center justify-center gap-2 shadow-[0_4px_16px_rgba(124,92,62,0.25)] active:scale-[0.98] transition-all hover:bg-on-secondary-container">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                        <span>Tambah ke Keranjang •
                            <span x-text="formatRupiah(grandTotal())">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </span>
                    </button>
                @else
                    <button type="button" disabled
                            class="w-full bg-surface-container-high text-outline py-3.5 px-space-md rounded-lg font-label-lg text-label-lg flex items-center justify-center gap-2 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">block</span>
                        <span>Tidak Tersedia</span>
                    </button>
                @endif
            </div>
        </div>

    </form>

</div>
@endsection
