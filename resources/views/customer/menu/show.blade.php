@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
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

        toggleCheckbox(groupId, optionId, additionalPrice) {
            const selected = this.selectedOptions[groupId];
            const idx = selected.findIndex(o => o.id === optionId);
            if (idx === -1) {
                selected.push({ id: optionId, price: additionalPrice });
            } else {
                selected.splice(idx, 1);
            }
        },

        isChecked(groupId, optionId) {
            return this.selectedOptions[groupId].some(o => o.id === optionId);
        },

        setRadio(groupId, optionId, additionalPrice) {
            this.selectedOptions[groupId] = { id: optionId, price: additionalPrice };
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

        increment() {
            this.quantity++;
        },

        decrement() {
            if (this.quantity > 1) this.quantity--;
        },

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
        }
    }">

    {{-- Back link --}}
    <a href="{{ route('customer.menu') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 mb-6">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Kembali ke Menu
    </a>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">

        {{-- Product Image --}}
        <div class="aspect-video bg-gray-100 relative">
            @if($product->hasMedia('product-images'))
                <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <i data-lucide="coffee" class="h-20 w-20 opacity-40"></i>
                </div>
            @endif

            @if(!$product->is_available)
                <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                    <span class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm font-semibold">Tidak Tersedia</span>
                </div>
            @endif
        </div>

        <div class="p-6">

            {{-- Product Info --}}
            <div class="mb-6">
                @if($product->category)
                    <span class="text-xs text-blue-600 font-medium uppercase tracking-wide">{{ $product->category->name }}</span>
                @endif
                <h1 class="text-2xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
                @if($product->description)
                    <p class="text-gray-500 mt-2 text-sm leading-relaxed">{{ $product->description }}</p>
                @endif
                <p class="text-xl font-bold text-blue-600 mt-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>

            @if(!$product->is_available)
                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-md text-center">
                    <p class="text-gray-600 text-sm">Product ini sedang tidak tersedia untuk dipesan.</p>
                </div>
            @endif

                <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" :value="quantity">
                <input type="hidden" name="note" :value="note">

                {{-- Option Groups --}}
                @if($product->is_customizable && $product->optionGroups->isNotEmpty())
                    <div class="space-y-6 mb-6">
                        @foreach($product->optionGroups as $group)
                            <div class="border-t border-gray-100 pt-5">
                                <div class="mb-3">
                                    <h3 class="font-semibold text-gray-900">{{ $group->name }}</h3>
                                    @if($group->description)
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $group->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        @if($group->selection_type === 'single')
                                            Pilih 1
                                        @else
                                            @if($group->min_selection > 0 && $group->max_selection)
                                                Pilih {{ $group->min_selection }}–{{ $group->max_selection }}
                                            @elseif($group->min_selection > 0)
                                                Pilih minimal {{ $group->min_selection }}
                                            @elseif($group->max_selection)
                                                Pilih maks. {{ $group->max_selection }}
                                            @else
                                                Pilih sesuai selera
                                            @endif
                                        @endif
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    @foreach($group->options as $option)
                                        @if($group->selection_type === 'single')
                                            <label class="flex items-center justify-between p-3 rounded-md border {{ $option->is_available ? 'border-gray-200 cursor-pointer hover:border-blue-300' : 'border-gray-100 opacity-50 cursor-not-allowed' }}"
                                                :class="isRadioSelected({{ $group->id }}, {{ $option->id }}) ? 'border-blue-500 bg-blue-50' : ''">
                                                <div class="flex items-center gap-3">
                                                    <input type="radio"
                                                        name="options[{{ $group->id }}]"
                                                        value="{{ $option->id }}"
                                                        @if(!$product->is_available || !$option->is_available) disabled @endif
                                                        @if($group->min_selection >= 1) required @endif
                                                        x-on:change="setRadio({{ $group->id }}, {{ $option->id }}, {{ (float) $option->additional_price }})"
                                                        :checked="isRadioSelected({{ $group->id }}, {{ $option->id }})"
                                                        class="text-blue-600 focus:ring-blue-500">
                                                    <span class="text-sm text-gray-800">{{ $option->name }}</span>
                                                    @if(!$option->is_available)
                                                        <span class="text-xs text-gray-400">(Tidak tersedia)</span>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $option->additional_price > 0 ? '+Rp ' . number_format($option->additional_price, 0, ',', '.') : 'Gratis' }}
                                                </span>
                                            </label>
                                        @else
                                            <label class="flex items-center justify-between p-3 rounded-md border {{ $option->is_available ? 'border-gray-200 cursor-pointer hover:border-blue-300' : 'border-gray-100 opacity-50 cursor-not-allowed' }}"
                                                :class="isChecked({{ $group->id }}, {{ $option->id }}) ? 'border-blue-500 bg-blue-50' : ''">
                                                <div class="flex items-center gap-3">
                                                    <input type="checkbox"
                                                        name="options[{{ $group->id }}][]"
                                                        value="{{ $option->id }}"
                                                        @if(!$product->is_available || !$option->is_available) disabled @endif
                                                        x-on:change="toggleCheckbox({{ $group->id }}, {{ $option->id }}, {{ (float) $option->additional_price }})"
                                                        :checked="isChecked({{ $group->id }}, {{ $option->id }})"
                                                        class="text-blue-600 focus:ring-blue-500 rounded">
                                                    <span class="text-sm text-gray-800">{{ $option->name }}</span>
                                                    @if(!$option->is_available)
                                                        <span class="text-xs text-gray-400">(Tidak tersedia)</span>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $option->additional_price > 0 ? '+Rp ' . number_format($option->additional_price, 0, ',', '.') : 'Gratis' }}
                                                </span>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Quantity --}}
                <div class="border-t border-gray-100 pt-5 mb-5">
                    <h3 class="font-semibold text-gray-900 mb-3">Jumlah</h3>
                    <div class="flex items-center gap-4">
                        <button type="button"
                            x-on:click="decrement()"
                            :disabled="{{ !$product->is_available ? 'true' : 'false' }}"
                            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i data-lucide="minus" class="h-4 w-4"></i>
                        </button>
                        <span class="text-lg font-semibold text-gray-900 w-6 text-center" x-text="quantity"></span>
                        <button type="button"
                            x-on:click="increment()"
                            :disabled="{{ !$product->is_available ? 'true' : 'false' }}"
                            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i data-lucide="plus" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Additional Note --}}
                <div class="mb-6">
                    <label class="block font-semibold text-gray-900 mb-2">Catatan <span class="text-gray-400 font-normal text-sm">(opsional)</span></label>
                    <textarea
                        x-model="note"
                        :maxlength="maxNote"
                        :disabled="{{ !$product->is_available ? 'true' : 'false' }}"
                        rows="3"
                        placeholder="Contoh: kurangi es, gula sedikit..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm resize-none disabled:bg-gray-50 disabled:text-gray-400"></textarea>
                    <p class="text-right text-xs text-gray-400 mt-1">
                        <span x-text="note.length"></span>/<span x-text="maxNote"></span>
                    </p>
                </div>

                {{-- Dynamic Price Summary --}}
                <div class="border border-gray-200 rounded-md p-4 mb-6 bg-gray-50 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Harga dasar</span>
                        <span x-text="formatRupiah(basePrice)"></span>
                    </div>

                    <template x-for="opt in selectedOptionsList()" :key="opt.id">
                        <div class="flex justify-between text-gray-600">
                            <span>Pilihan</span>
                            <span x-text="'+' + formatRupiah(opt.price)"></span>
                        </div>
                    </template>

                    <div class="border-t border-gray-200 pt-2 flex justify-between font-semibold text-gray-900">
                        <span>Total per item</span>
                        <span x-text="formatRupiah(itemTotal())"></span>
                    </div>

                    <div class="flex justify-between text-gray-500 text-xs">
                        <span>Jumlah</span>
                        <span x-text="quantity + 'x'"></span>
                    </div>

                    <div class="border-t border-gray-200 pt-2 flex justify-between font-bold text-blue-600 text-base">
                        <span>Total</span>
                        <span x-text="formatRupiah(grandTotal())"></span>
                    </div>
                </div>

                {{-- Add to Cart Button --}}
                @if($product->is_available)
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                        <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                        Add to Cart
                    </button>
                @else
                    <button type="button" disabled
                        class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-400 px-6 py-3 rounded-md font-semibold cursor-not-allowed">
                        <i data-lucide="ban" class="h-5 w-5"></i>
                        Tidak Tersedia
                    </button>
                @endif

            </form>
        </div>
    </div>
</div>
@endsection
