<?php

namespace App\Services;

use App\Models\Category;

class CategoriesService
{
    /**
     * Recursive tree creating
     *
     * @param $categories
     * @param int|null $parentId
     * @return array
     */
    private function getTree($categories, ?int $parentId = null): array
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->category_id === $parentId) {
                $tree[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'children' => $this->getTree($categories, $category->id)
                ];
            }
        }

        return $tree;
    }

    /**
     * Get categories tree
     *
     * @return array
     */
    public function getCategories(): array
    {
        $categories = Category::orderBy('name')->get();

        return empty($categories) ? [] : $this->getTree($categories);
    }
}