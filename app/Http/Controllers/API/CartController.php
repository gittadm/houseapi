<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartProductDeleteRequest;
use App\Http\Requests\CartProductUpdateRequest;
use App\Http\Requests\CartStoreRequest;
use App\Http\Resources\CartResource;
use App\Services\CartsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CartController extends Controller
{
    private $cartsService;

    /**
     * CartController constructor.
     * @param CartsService $cartsService
     */
    public function __construct(CartsService $cartsService)
    {
        $this->cartsService = $cartsService;
    }

    /**
     * Get cart with products
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(
            new CartResource($this->cartsService->getCartWithProducts($id))
        );
    }

    /**
     * Create cart
     * 
     * @param CartStoreRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CartStoreRequest $request)
    {
        return response()->json(
            new CartResource($this->cartsService->store(id(), $request->validated())),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update cart product
     *
     * @param CartProductUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CartProductUpdateRequest $request, int $id)
    {
        $this->cartsService->updateProduct($id, $request->validated());

        return response_ok();
    }

    /**
     * Delete cart or cart products
     *
     * @param CartProductDeleteRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(CartProductDeleteRequest $request, int $id)
    {
        $this->cartsService->deleteCartProducts($id, $request->validated());

        return response_ok();
    }
}
