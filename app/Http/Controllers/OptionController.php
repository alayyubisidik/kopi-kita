<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\OptionGroup;
use App\Services\AlertService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search');
        $optionGroupId = $request->input('option_group');

        $options = Option::query()
            ->with('optionGroup')
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($optionGroupId, fn ($query) => $query->where('option_group_id', $optionGroupId))
            ->orderBy('option_group_id')
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        $optionGroups = OptionGroup::query()
            ->orderBy('name')
            ->get();

        return view('dashboard.options.index', compact('options', 'search', 'optionGroupId', 'optionGroups'));
    }

    public function create()
    {
        $optionGroups = OptionGroup::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.options.create', compact('optionGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'option_group_id' => ['required', 'exists:option_groups,id'],
                'name' => ['required', 'string', 'max:255'],
                'additional_price' => ['required', 'numeric', 'min:0'],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_available' => ['boolean'],
            ],
            [
                'option_group_id.required' => 'Option Group wajib dipilih.',
                'option_group_id.exists' => 'Option Group tidak valid.',
                'name.required' => 'Nama option wajib diisi.',
                'additional_price.required' => 'Harga tambahan wajib diisi.',
                'additional_price.numeric' => 'Harga tambahan harus berupa angka.',
                'additional_price.min' => 'Harga tambahan minimal 0.',
            ]
        );

        $validated['is_available'] = $request->has('is_available');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Option::create($validated);

        AlertService::created('Option berhasil dibuat.');

        return to_route('dashboard.options.index');
    }

    public function edit(Option $option)
    {
        $optionGroups = OptionGroup::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.options.edit', compact('option', 'optionGroups'));
    }

    public function update(Request $request, Option $option)
    {
        $validated = $request->validate(
            [
                'option_group_id' => ['required', 'exists:option_groups,id'],
                'name' => ['required', 'string', 'max:255'],
                'additional_price' => ['required', 'numeric', 'min:0'],
                'sort_order' => ['nullable', 'integer', 'min:0'],
                'is_available' => ['boolean'],
            ],
            [
                'option_group_id.required' => 'Option Group wajib dipilih.',
                'option_group_id.exists' => 'Option Group tidak valid.',
                'name.required' => 'Nama option wajib diisi.',
                'additional_price.required' => 'Harga tambahan wajib diisi.',
                'additional_price.numeric' => 'Harga tambahan harus berupa angka.',
                'additional_price.min' => 'Harga tambahan minimal 0.',
            ]
        );

        $validated['is_available'] = $request->has('is_available');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $option->update($validated);

        AlertService::updated('Option berhasil diperbarui.');

        return to_route('dashboard.options.index');
    }

    public function destroy(Option $option)
    {
        $option->delete();

        AlertService::deleted('Option berhasil dihapus.');

        return to_route('dashboard.options.index');
    }
}
