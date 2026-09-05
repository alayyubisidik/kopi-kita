@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-lg shadow">
                        <form method="POST" action="{{ route('dashboard.option-groups.store') }}" x-data="{ selectionType: '{{ old('selection_type', 'single') }}' }">
                            @csrf
                            
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Option Group</label>
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
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="selection_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Seleksi</label>
                                    <select 
                                        id="selection_type" 
                                        name="selection_type"
                                        x-model="selectionType"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('selection_type') border-red-500 @enderror"
                                        required
                                    >
                                        <option value="single">Single</option>
                                        <option value="multiple">Multiple</option>
                                    </select>
                                    @error('selection_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div x-show="selectionType === 'multiple'" class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="min_selection" class="block text-sm font-medium text-gray-700 mb-2">Min Seleksi</label>
                                        <input 
                                            type="number" 
                                            id="min_selection" 
                                            name="min_selection" 
                                            value="{{ old('min_selection') }}"
                                            min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_selection') border-red-500 @enderror"
                                        >
                                        @error('min_selection')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="max_selection" class="block text-sm font-medium text-gray-700 mb-2">Max Seleksi</label>
                                        <input 
                                            type="number" 
                                            id="max_selection" 
                                            name="max_selection" 
                                            value="{{ old('max_selection') }}"
                                            min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_selection') border-red-500 @enderror"
                                        >
                                        @error('max_selection')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="flex items-center">
                                        <input 
                                            type="checkbox" 
                                            name="is_active" 
                                            value="1"
                                            {{ old('is_active', true) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        >
                                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                    </label>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard.option-groups.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition">
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
