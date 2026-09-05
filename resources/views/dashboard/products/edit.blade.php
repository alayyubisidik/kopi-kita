@extends('dashboard.layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Edit Product</h1>
    </div>

    <div class="bg-white shadow-lg rounded-sm border border-gray-200">
        <div class="p-6">
            <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column - Basic Info -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Basic Information</h2>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Product Name <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('name', $product->name) }}" required />
                            @error('name') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="category_id">Category <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="price">Price (Rp) <span class="text-red-500">*</span></label>
                            <input id="price" name="price" type="number" min="0" step="1" class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('price', (int)$product->price) }}" required />
                            @error('price') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="description">Description</label>
                            <textarea id="description" name="description" rows="4" class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="image">Product Image</label>
                            
                            @if($product->hasMedia('product-images'))
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 mb-1">Current Image:</p>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-md border border-gray-200">
                                </div>
                            @endif
                            
                            <input id="image" name="image" type="file" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image. Accepted formats: JPG, PNG, WEBP. Max size: 2MB.</p>
                            @error('image') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column - Settings & Customization -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Settings & Customization</h2>
                        
                        <div class="flex items-center mt-2">
                            <!-- Hidden input to ensure value is sent even if unchecked -->
                            <input type="hidden" name="is_available" value="0">
                            <input id="is_available" name="is_available" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ old('is_available', $product->is_available) ? 'checked' : '' }} />
                            <label for="is_available" class="ml-2 block text-sm leading-5 text-gray-900">Available (Can be ordered)</label>
                        </div>
                        
                        <div class="flex items-center mt-2">
                            <!-- Hidden input to ensure value is sent even if unchecked -->
                            <input type="hidden" name="is_customizable" value="0">
                            <input id="is_customizable" name="is_customizable" type="checkbox" value="1" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ old('is_customizable', $product->is_customizable) ? 'checked' : '' }} onchange="toggleCustomization()" />
                            <label for="is_customizable" class="ml-2 block text-sm leading-5 text-gray-900">Customizable (Has options like Size, Sugar, etc.)</label>
                        </div>
                        
                        @php
                            $selectedGroups = old('option_groups', $product->optionGroups->pluck('id')->toArray());
                        @endphp
                        
                        <div id="customization_section" class="mt-4 p-4 bg-gray-50 rounded-md border border-gray-200 {{ old('is_customizable', $product->is_customizable) ? '' : 'hidden' }}">
                            <h3 class="text-sm font-medium text-gray-800 mb-3">Select Option Groups</h3>
                            
                            @if($optionGroups->isEmpty())
                                <p class="text-sm text-gray-500 italic">No option groups available. Create them first.</p>
                            @else
                                <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
                                    @foreach($optionGroups as $group)
                                        <div class="flex items-center justify-between p-2 hover:bg-gray-100 rounded">
                                            <div class="flex items-center">
                                                <input id="group_{{ $group->id }}" name="option_groups[]" type="checkbox" value="{{ $group->id }}" class="form-checkbox h-4 w-4 text-indigo-600" {{ in_array($group->id, $selectedGroups) ? 'checked' : '' }} />
                                                <label for="group_{{ $group->id }}" class="ml-2 block text-sm leading-5 text-gray-900">
                                                    {{ $group->name }} 
                                                    <span class="text-xs text-gray-500">({{ ucfirst($group->selection_type) }})</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('option_groups') <div class="text-xs text-red-500 mt-1">{{ $message }}</div> @enderror
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('dashboard.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">Update Product</button>
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
            // We don't uncheck them on edit so if they toggle back they aren't lost before saving
        }
    }

    // Call it on page load to set the initial state correctly
    document.addEventListener('DOMContentLoaded', function() {
        toggleCustomization();
    });
</script>
@endpush
@endsection