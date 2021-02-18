<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class OrdersService
{
    /**
     * Get paginate user orders
     *
     * @param int $userId
     * @param array $filter
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedUserOrders(int $userId, array $filter)
    {
        return Order::where('user_id', $userId)->paginate($filter['limit']);
    }

    /**
     * Update order status
     *
     * @param int $orderId
     * @param string $status
     */
    public function updateStatus(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);

        $order->update(['status' => $status]);
    }
}