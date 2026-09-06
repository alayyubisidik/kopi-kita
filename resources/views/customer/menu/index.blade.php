@extends('layouts.customer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Menu Kopi Kita</h1>
        
        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Search Form -->
            <form action="{{ route('customer.menu') }}" method="GET" class="w-full md:w-1/3 relative">
                @if($categoryId)
                    <input type="hidden" name="category" value="{{ $categoryId }}">
                @endif
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari menu..." 
                           class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </form>

            <!-- Category Filter -->
            <div class="w-full md:w-2/3 overflow-x-auto pb-2 -mb-2">
                <div class="flex space-x-2">
                    <a href="{{ route('customer.menu', ['search' => $search]) }}" 
                       class="px-4 py-2 rounded-full whitespace-nowrap {{ !$categoryId ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                        All
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('customer.menu', ['category' => $category->id, 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-full whitespace-nowrap {{ $categoryId == $category->id ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-100">
            <i data-lucide="search-x" class="h-12 w-12 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Produk tidak ditemukan</h3>
            <p class="text-gray-500 mb-4">Coba gunakan kata pencarian atau kategori lain.</p>
            @if($search || $categoryId)
                <a href="{{ route('customer.menu') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Reset Filter
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden flex flex-col {{ !$product->is_available ? 'opacity-75' : '' }}">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gray-100 relative">
                        @if($product->hasMedia('product-images'))
                            <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i data-lucide="coffee" class="h-12 w-12 opacity-50"></i>
                            </div>
                        @endif
                        
                        @if(!$product->is_available)
                            <div class="absolute inset-0 bg-white/50 backdrop-blur-[2px] flex items-center justify-center">
                                <span class="bg-gray-900 text-white px-3 py-1 rounded-full text-sm font-medium">Habis</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col flex-grow">
                        @if($product->category)
                            <span class="text-xs text-blue-600 font-medium mb-1">{{ $product->category->name }}</span>
                        @endif
                        <h3 class="text-gray-900 font-medium line-clamp-2 mb-2 flex-grow">{{ $product->name }}</h3>
                        
                        <div class="mt-auto">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($product->is_available)
                                <a href="{{ route('customer.menu.show', $product->slug) }}" class="w-full mt-3 flex items-center justify-center gap-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-md transition-colors font-medium text-sm">
                                    <i data-lucide="plus" class="h-4 w-4"></i>
                                    Tambah
                                </a>
                            @else
                                <button disabled class="w-full mt-3 flex items-center justify-center gap-2 bg-gray-100 text-gray-400 px-4 py-2 rounded-md font-medium text-sm cursor-not-allowed">
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
