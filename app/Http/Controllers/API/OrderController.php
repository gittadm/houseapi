<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersRequest;
use App\Http\Requests\OrderStatusUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrdersService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private $ordersService;

    /**
     * OrderController constructor.
     * @param OrdersService $ordersService
     */
    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    /**
     * Get paginated user orders by filter
     *
     * @param OrdersRequest $request
     * @return JsonResponse
     */
    public function index(OrdersRequest $request)
    {
        $orders = $this->ordersService->getPaginatedUserOrders(id(), $request->validated());

        return response()->json(OrderResource::collection($orders), JsonResponse::HTTP_OK);
    }

    /**
     * Update order status
     *
     * @param int $id
     * @return JsonResponse
     */
    public function updateStatus(OrderStatusUpdateRequest $request, int $id)
    {
        $this->ordersService->updateStatus($id, $request->status);

        return response_ok();
    }
}
