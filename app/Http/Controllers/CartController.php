<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use App\Services\AlertService;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartService::get();
        $total = CartService::total();

        return view('customer.cart.index', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:100'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable'],
        ]);

        $product = Product::with([
            'optionGroups' => function ($query) {
                $query->with(['options' => function ($q) {
                    $q->where('is_available', true);
                }]);
            },
        ])->findOrFail($validated['product_id']);

        if (!$product->is_available) {
            AlertService::error('Product ini sedang tidak tersedia.');
            return back();
        }

        $submittedOptions = $request->input('options', []);

        $selectedOptions = [];

        foreach ($product->optionGroups as $group) {
            $groupId = (string) $group->id;
            $submittedForGroup = $submittedOptions[$groupId] ?? null;

            if ($group->selection_type === 'single') {
                if (!empty($submittedForGroup)) {
                    $optionId = (int) $submittedForGroup;
                    $option = $group->options->firstWhere('id', $optionId);

                    if (!$option) {
                        AlertService::error('Pilihan tidak valid untuk ' . $group->name . '.');
                        return back();
                    }

                    if (!$option->is_available) {
                        AlertService::error('Pilihan ' . $option->name . ' sedang tidak tersedia.');
                        return back();
                    }

                    $selectedOptions[] = [
                        'option_id' => $option->id,
                        'option_group_id' => $group->id,
                        'option_name' => $option->name,
                        'option_group_name' => $group->name,
                        'additional_price' => (float) $option->additional_price,
                        'id' => $option->id,
                    ];
                } elseif ($group->min_selection >= 1) {
                    AlertService::error('Wajib memilih ' . $group->name . '.');
                    return back();
                }
            } else {
                $selectedIds = [];
                if (!empty($submittedForGroup) && is_array($submittedForGroup)) {
                    $selectedIds = array_map('intval', $submittedForGroup);
                }

                if ($group->min_selection > 0 && count($selectedIds) < $group->min_selection) {
                    AlertService::error('Pilih minimal ' . $group->min_selection . ' pilihan untuk ' . $group->name . '.');
                    return back();
                }

                if ($group->max_selection && count($selectedIds) > $group->max_selection) {
                    AlertService::error('Maksimal ' . $group->max_selection . ' pilihan untuk ' . $group->name . '.');
                    return back();
                }

                foreach ($selectedIds as $optionId) {
                    $option = $group->options->firstWhere('id', $optionId);

                    if (!$option) {
                        AlertService::error('Pilihan tidak valid untuk ' . $group->name . '.');
                        return back();
                    }

                    if (!$option->is_available) {
                        AlertService::error('Pilihan ' . $option->name . ' sedang tidak tersedia.');
                        return back();
                    }

                    $selectedOptions[] = [
                        'option_id' => $option->id,
                        'option_group_id' => $group->id,
                        'option_name' => $option->name,
                        'option_group_name' => $group->name,
                        'additional_price' => (float) $option->additional_price,
                        'id' => $option->id,
                    ];
                }
            }
        }

        CartService::add($product, $selectedOptions, (int) $validated['quantity'], $validated['note'] ?? '');

        AlertService::success('Item berhasil ditambahkan ke cart.');

        return to_route('cart.index');
    }

    public function update(Request $request, string $cartItemKey)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        CartService::update($cartItemKey, (int) $validated['quantity']);

        return to_route('cart.index');
    }

    public function destroy(string $cartItemKey)
    {
        CartService::remove($cartItemKey);

        AlertService::deleted('Item berhasil dihapus dari cart.');

        return to_route('cart.index');
    }

    public function clear()
    {
        CartService::clear();

        AlertService::success('Cart berhasil dikosongkan.');

        return to_route('cart.index');
    }
}
