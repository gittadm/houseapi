<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property int|null $category_id
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category subcategory()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'category_id'
    ];

    protected $casts = [
        'category_id' => 'integer',
    ];

    /**
     * Get category id and children ids
     *
     * @param int $parentId
     * @return array
     */
    public static function getChildrenIds(int $parentId): array
    {
        $ids = [$parentId];

        $categoriesIds = Category::where('category_id', $parentId)->pluck('id')->toArray();

        foreach ($categoriesIds as $categoriesId) {
            $ids = array_merge($ids, self::getChildrenIds($categoriesId));
        }

        return $ids;
    }

    /**
     * Subcategory scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeSubcategory($query)
    {
        return $query->whereNotNull('category_id');
    }
}