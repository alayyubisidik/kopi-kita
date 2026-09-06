<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerMenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search');
        $categoryId = $request->integer('category');

        $categories = Category::query()
            ->whereHas('products')
            ->get();

        $products = Product::query()
            ->with('category')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('name')
            ->get();

        return view('customer.menu.index', [
            'categories' => $categories,
            'products' => $products,
            'search' => $search,
            'categoryId' => $categoryId,
        ]);
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'optionGroups' => function ($query) {
                $query->orderBy('product_option_groups.sort_order');
            },
            'optionGroups.options' => function ($query) {
                $query->orderBy('sort_order');
            },
        ]);

        return view('customer.menu.show', [
            'product' => $product,
        ]);
    }
}
