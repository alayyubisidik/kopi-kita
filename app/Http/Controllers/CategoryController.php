<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search');

        $categories = Category::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
                'description' => ['nullable', 'string'],
                'is_active' => ['boolean'],
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan.',
            ]
        );

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        AlertService::created('Kategori berhasil dibuat.');

        return to_route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
                'description' => ['nullable', 'string'],
                'is_active' => ['boolean'],
            ],
            [
                'name.required' => 'Nama kategori wajib diisi.',
                'slug.required' => 'Slug wajib diisi.',
                'slug.unique' => 'Slug sudah digunakan.',
            ]
        );

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        AlertService::updated('Kategori berhasil diperbarui.');

        return to_route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->where('is_available', true)->exists()) {
            AlertService::error('Kategori tidak dapat dihapus karena masih memiliki produk aktif.');

            return back();
        }

        $category->delete();

        AlertService::deleted('Kategori berhasil dihapus.');

        return to_route('dashboard.categories.index');
    }
}
