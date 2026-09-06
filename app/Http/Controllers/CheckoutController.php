<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use App\Services\AlertService;
use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = CartService::get();

        if (empty($cart)) {
            AlertService::error('Cart kamu masih kosong.');

            return to_route('cart.index');
        }

        $total = CartService::total();

        return view('customer.checkout.index', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $cart = CartService::get();

        if (empty($cart)) {
            AlertService::error('Cart kamu masih kosong.');

            return to_route('cart.index');
        }

        $validated = $request->validate(
            [
                'customer_name' => ['required', 'string', 'max:255'],
            ],
            [
                'customer_name.required' => 'Nama pemesan wajib diisi.',
                'customer_name.string' => 'Nama pemesan tidak valid.',
                'customer_name.max' => 'Nama pemesan maksimal 255 karakter.',
            ]
        );

        $customerName = strip_tags($validated['customer_name']);

        $recalculatedCart = [];
        $hasInvalidItem = false;

        foreach ($cart as $cartItemKey => $item) {
            $product = Product::find($item['product_id']);

            if (!$product || !$product->is_available) {
                AlertService::error('Produk "' . $item['product_name'] . '" tidak lagi tersedia. Silakan periksa kembali cart kamu.');
                CartService::remove($cartItemKey);
                $hasInvalidItem = true;
                continue;
            }

            $recalculatedOptions = [];
            $optionAdditionalTotal = 0;

            foreach ($item['options'] as $optionData) {
                $option = Option::find($optionData['option_id']);

                if (!$option || !$option->is_available) {
                    AlertService::error('Pilihan "' . $optionData['option_name'] . '" tidak lagi tersedia. Silakan periksa kembali cart kamu.');
                    CartService::remove($cartItemKey);
                    $hasInvalidItem = true;
                    break 2;
                }

                $recalculatedOptions[] = [
                    'option_id' => $option->id,
                    'option_group_id' => $optionData['option_group_id'],
                    'option_name' => $option->name,
                    'option_group_name' => $optionData['option_group_name'],
                    'additional_price' => (float) $option->additional_price,
                    'id' => $option->id,
                ];

                $optionAdditionalTotal += (float) $option->additional_price;
            }

            $itemSubtotal = ((float) $product->price + $optionAdditionalTotal) * $item['quantity'];

            $recalculatedCart[$cartItemKey] = [
                'cart_item_key' => $cartItemKey,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => (float) $product->price,
                'options' => $recalculatedOptions,
                'quantity' => $item['quantity'],
                'note' => $item['note'],
                'subtotal' => $itemSubtotal,
            ];
        }

        if ($hasInvalidItem) {
            return to_route('cart.index');
        }

        $finalTotal = collect($recalculatedCart)->sum('subtotal');

        session([
            'checkout_data' => [
                'customer_name' => $customerName,
                'cart' => $recalculatedCart,
                'total' => $finalTotal,
            ],
        ]);

        return to_route('checkout.index');
    }
}
