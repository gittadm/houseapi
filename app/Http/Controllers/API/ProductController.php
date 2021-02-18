<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsCollection;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productsService;

    /**
     * ProductController constructor.
     * @param ProductsService $productsService
     */
    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * Get paginated products by filter
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(ProductsRequest $request)
    {
        $products = $this->productsService->getPaginatedProducts($request->validated());

        return response()->json(new ProductsCollection($products), JsonResponse::HTTP_OK);
    }

    /**
     * Get product by slug
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug)
    {
        return response()->json(
            new ProductResource($this->productsService->getProductBySlug($slug))
        );
    }
}
