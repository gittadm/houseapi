<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class CartsService
{
    /**
     * Get cart with products
     *
     * @param int $id
     * @return Order|null
     */
    public function getCartWithProducts(int $id): ?Order
    {
        return Order::cart()->where('id', $id)->with('products')->firstOrFail();
    }

    /**
     * Create cart
     *
     * @param int|null $userId
     * @param array $data
     * @return Order|null
     * @throws \Throwable
     */
    public function store(?int $userId, array $data): ?Order
    {
        $products = [];

        foreach ($data['products'] as $product) {
            $products[$product['id']] = ['count' => $product['count']];
        }

        return DB::transaction(function () use ($products, $userId) {
            $order = Order::create([
                'user_id' => $userId,
                'status' => Order::STATUS_CART
            ]);

            $order->products()->attach($products);

            $order->refresh();

            return $order;
        });
    }

    /**
     * Update cart product count
     *
     * @param int $cartId
     * @param array $data
     */
    public function updateProduct(int $cartId, array $data): void
    {
        $orderProduct = OrderProduct::where('order_id', $cartId)
            ->where('product_id', $data['product_id'])->firstOrFail();

        $orderProduct->update(['count' => $data['count']]);
    }

    /**
     * Delete cart or cart products
     *
     * @param int $cartId
     * @param array $data
     * @throws \Exception
     */
    public function deleteCartProducts(int $cartId, array $data): void
    {
        if (empty($data['product_id'])) {
            $order = Order::findOrFail($cartId);
            $order->delete();
        } else {
            $orderProduct = OrderProduct::where('order_id', $cartId)
                ->where('product_id', $data['product_id'])->firstOrFail();
            $orderProduct->delete();
        }
    }
}