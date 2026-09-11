<?php

namespace App\Services;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const SESSION_KEY = 'cart';

    public static function get(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public static function add(Product $product, array $selectedOptions, int $quantity, string $note): void
    {
        $cart = self::get();

        $sortedOptionIds = collect($selectedOptions)->pluck('id')->sort()->values()->all();
        $cartItemKey = md5('product_' . $product->id . '|' . implode(',', $sortedOptionIds));

        $subtotal = ((float) $product->price + collect($selectedOptions)->sum('additional_price')) * $quantity;

        if (isset($cart[$cartItemKey])) {
            $cart[$cartItemKey]['quantity'] += $quantity;
            $cart[$cartItemKey]['subtotal'] = ((float) $cart[$cartItemKey]['product_price'] + collect($cart[$cartItemKey]['options'])->sum('additional_price')) * $cart[$cartItemKey]['quantity'];
        } else {
            $cart[$cartItemKey] = [
                'cart_item_key'  => $cartItemKey,
                'product_id'     => $product->id,
                'product_name'   => $product->name,
                'product_price'  => (float) $product->price,
                'product_image'  => $product->image_url,
                'options'        => $selectedOptions,
                'quantity'       => $quantity,
                'note'           => $note,
                'subtotal'       => $subtotal,
            ];
        }

        Session::put(self::SESSION_KEY, $cart);
    }

    public static function update(string $cartItemKey, int $quantity): void
    {
        $cart = self::get();

        if (!isset($cart[$cartItemKey])) {
            return;
        }

        $cart[$cartItemKey]['quantity'] = $quantity;
        $cart[$cartItemKey]['subtotal'] = ((float) $cart[$cartItemKey]['product_price'] + collect($cart[$cartItemKey]['options'])->sum('additional_price')) * $quantity;

        Session::put(self::SESSION_KEY, $cart);
    }

    public static function remove(string $cartItemKey): void
    {
        $cart = self::get();
        unset($cart[$cartItemKey]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function total(): float
    {
        return collect(self::get())->sum('subtotal');
    }

    public static function count(): int
    {
        return collect(self::get())->sum('quantity');
    }
}
