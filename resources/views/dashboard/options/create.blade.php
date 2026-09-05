@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-lg shadow">
                        <form method="POST" action="{{ route('dashboard.options.store') }}">
                            @csrf
                            
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="option_group_id" class="block text-sm font-medium text-gray-700 mb-2">Option Group</label>
                                    <select 
                                        id="option_group_id" 
                                        name="option_group_id"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('option_group_id') border-red-500 @enderror"
                                        required
                                    >
                                        <option value="">Pilih Option Group</option>
                                        @foreach($optionGroups as $group)
                                            <option value="{{ $group->id }}" {{ old('option_group_id') == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }} ({{ $group->selection_type }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('option_group_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Option</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                        required
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="additional_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Tambahan</label>
                                    <input 
                                        type="number" 
                                        id="additional_price" 
                                        name="additional_price" 
                                        value="{{ old('additional_price', 0) }}"
                                        min="0"
                                        step="0.01"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('additional_price') border-red-500 @enderror"
                                        required
                                    >
                                    @error('additional_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                                    <input 
                                        type="number" 
                                        id="sort_order" 
                                        name="sort_order" 
                                        value="{{ old('sort_order', 0) }}"
                                        min="0"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sort_order') border-red-500 @enderror"
                                    >
                                    @error('sort_order')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            name="is_available" 
                                            value="1"
                                            {{ old('is_available', true) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        >
                                        <span class="ml-2 text-sm text-gray-700">Tersedia</span>
                                    </label>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard.options.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                    Batal
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
@endsection
