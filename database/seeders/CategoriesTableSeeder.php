<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Get categories
     *
     * @return array
     */
    private function getCategories(): array
    {
        return [
            [
                'name' => 'Category 1',
                'category_id' => null,
            ],
            [
                'name' => 'Category 2',
                'category_id' => null,
            ],
            [
                'name' => 'Category 3',
                'category_id' => null,
            ],
            [
                'name' => 'SubCategory 1',
                'category_id' => 1,
            ],
            [
                'name' => 'SubCategory 2',
                'category_id' => 1,
            ],
            [
                'name' => 'SubSubCategory 1',
                'category_id' => 4,
            ],
            [
                'name' => 'SubSubCategory 2',
                'category_id' => 4,
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('categories')->insert($this->getCategories());
    }
}
