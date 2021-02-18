<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory;
use DB;
use Illuminate\Support\Arr;

class ProductsTableSeeder extends Seeder
{
    private const COUNT = 30;

    private $faker;
    private $now;
    private $categoriesIds;

    /**
     * ProductsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->now = now()->toDateTimeString();
        $this->faker = Factory::create();
        $this->categoriesIds = Category::subcategory()->pluck('id')->toArray();
    }

    /**
     * Gen product features
     *
     * @return string|null
     */
    private function genFeatures(): ?string
    {
        return mt_rand(0, 2) ? json_encode(['width' => mt_rand(10, 20), 'height' => mt_rand(10, 20)]) : null;
    }

    /**
     * Get products
     *
     * @return array
     */
    private function getProducts(): array
    {
        $products = [];

        for ($i = 0; $i < self::COUNT; $i++) {
            $products[] = [
                'name' => 'Product ' . ($i+1),
                'description' => $this->faker->sentences(3, true),
                'slug' => 'product-' . ($i+1),
                'price' => mt_rand(10, 1000) * 10,
                'features' => $this->genFeatures(),
                'category_id' => Arr::random($this->categoriesIds),
                'created_at' => $this->now,
                'updated_at' => $this->now
            ];
        }

        return $products;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('products')->insert($this->getProducts());
    }
}
