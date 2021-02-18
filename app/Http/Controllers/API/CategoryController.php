<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private $categoriesService;

    /**
     * CategoryController constructor.
     * @param CategoriesService $categoriesService
     */
    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    /**
     * Get categories tree
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = $this->categoriesService->getCategories();

        return response()->json($categories, JsonResponse::HTTP_OK);
    }
}
