<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search');

        $products = Product::query()
            ->with(['category', 'media'])
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $optionGroups = OptionGroup::where('is_active', true)->get();

        return view('dashboard.products.create', compact('categories', 'optionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'],
            'is_available' => ['nullable', 'boolean'],
            'is_customizable' => ['nullable', 'boolean'],
            'option_groups' => ['nullable', 'array'],
            'option_groups.*' => ['exists:option_groups,id'],
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.uniqid();
        $validated['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : true;
        $validated['is_customizable'] = $request->boolean('is_customizable');

        $product = Product::create($validated);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('product-images');
        }

        if ($validated['is_customizable'] && ! empty($validated['option_groups'])) {
            $syncData = [];
            foreach ($validated['option_groups'] as $index => $groupId) {
                $syncData[$groupId] = ['sort_order' => $index + 1];
            }
            $product->optionGroups()->sync($syncData);
        }

        AlertService::created('Product created successfully');

        return to_route('dashboard.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $optionGroups = OptionGroup::where('is_active', true)->get();

        return view('dashboard.products.edit', compact('product', 'categories', 'optionGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'],
            'is_available' => ['boolean'],
            'is_customizable' => ['boolean'],
            'option_groups' => ['nullable', 'array'],
            'option_groups.*' => ['exists:option_groups,id'],
        ]);

        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']).'-'.uniqid();
        }

        $product->update($validated);

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('product-images');
            $product->addMediaFromRequest('image')->toMediaCollection('product-images');
        }

        if ($validated['is_customizable'] && ! empty($validated['option_groups'])) {
            $syncData = [];
            foreach ($validated['option_groups'] as $index => $groupId) {
                $syncData[$groupId] = ['sort_order' => $index + 1];
            }
            $product->optionGroups()->sync($syncData);
        } else {
            $product->optionGroups()->detach();
        }

        AlertService::updated('Product updated successfully');

        return to_route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        AlertService::deleted('Product deleted successfully');

        return to_route('dashboard.products.index');
    }
}
