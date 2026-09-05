<?php

namespace App\Http\Controllers;

use App\Models\OptionGroup;
use App\Services\AlertService;
use Illuminate\Http\Request;

class OptionGroupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search');

        $optionGroups = OptionGroup::query()
            ->withCount('options')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.option-groups.index', compact('optionGroups', 'search'));
    }

    public function create()
    {
        return view('dashboard.option-groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'selection_type' => ['required', 'in:single,multiple'],
                'min_selection' => ['nullable', 'integer', 'min:0'],
                'max_selection' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['boolean'],
            ],
            [
                'name.required' => 'Nama option group wajib diisi.',
                'selection_type.required' => 'Tipe seleksi wajib dipilih.',
                'selection_type.in' => 'Tipe seleksi tidak valid.',
            ]
        );

        $validated['is_active'] = $request->has('is_active');
        $validated['min_selection'] = $validated['min_selection'] ?? 1;
        $validated['max_selection'] = $validated['max_selection'] ?? null;

        OptionGroup::create($validated);

        AlertService::created('Option Group berhasil dibuat.');

        return to_route('dashboard.option-groups.index');
    }

    public function edit(OptionGroup $optionGroup)
    {
        return view('dashboard.option-groups.edit', compact('optionGroup'));
    }

    public function update(Request $request, OptionGroup $optionGroup)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'selection_type' => ['required', 'in:single,multiple'],
                'min_selection' => ['nullable', 'integer', 'min:0'],
                'max_selection' => ['nullable', 'integer', 'min:0'],
                'is_active' => ['boolean'],
            ],
            [
                'name.required' => 'Nama option group wajib diisi.',
                'selection_type.required' => 'Tipe seleksi wajib dipilih.',
                'selection_type.in' => 'Tipe seleksi tidak valid.',
            ]
        );

        $validated['is_active'] = $request->has('is_active');
        $validated['min_selection'] = $validated['min_selection'] ?? 1;
        $validated['max_selection'] = $validated['max_selection'] ?? null;

        $optionGroup->update($validated);

        AlertService::updated('Option Group berhasil diperbarui.');

        return to_route('dashboard.option-groups.index');
    }

    public function destroy(OptionGroup $optionGroup)
    {
        if ($optionGroup->options()->exists()) {
            AlertService::error('Option Group tidak dapat dihapus karena masih memiliki option.');

            return back();
        }

        $optionGroup->delete();

        AlertService::deleted('Option Group berhasil dihapus.');

        return to_route('dashboard.option-groups.index');
    }
}
