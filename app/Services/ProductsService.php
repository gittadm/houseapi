<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class ProductsService
{
    /**
     * Get paginate products
     *
     * @param array $filter
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedProducts(array $filter)
    {
        $products = Product::query();

        if (!empty($filter['min_price'])) {
            $products->where('price', '>=', $filter['min_price']);
        }

        if (!empty($filter['max_price'])) {
            $products->where('price', '<=', $filter['max_price']);
        }

        if (!empty($filter['width'])) {
            $products->where('features->width', $filter['width']);
        }

        if (!empty($filter['height'])) {
            $products->where('features->height', $filter['height']);
        }

        if (!empty($filter['category'])) {
            $products->whereIn('category_id', Category::getChildrenIds($filter['category']));
        }

        return Product::paginate($filter['limit']);
    }

    /**
     * Get product by slug
     *
     * @param string $slug
     * @return Product|null
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->firstOrFail();
    }
}