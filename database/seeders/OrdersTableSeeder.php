<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;
use DB;
use Illuminate\Support\Arr;

class OrdersTableSeeder extends Seeder
{
    private const COUNT = 30;

    private $faker;
    private $now;
    private $usersIds;

    /**
     * OrdersTableSeeder constructor.
     */
    public function __construct()
    {
        $this->now = now()->toDateTimeString();
        $this->faker = Factory::create();
        $this->usersIds = User::pluck('id')->toArray();
    }

    /**
     * Get orders
     *
     * @return array
     */
    private function getOrders(): array
    {
        $orders = [];

        for ($i = 0; $i < self::COUNT; $i++) {
            $orders[] = [
                'user_id' => mt_rand(0, 1) ? null : Arr::random($this->usersIds),
                'name' => 'Test user name ' . ($i+1),
                'description' => $this->faker->sentences(3, true),
                'email' => 'email' . ($i+1) . '@user.ru',
                'phone' => $this->faker->phoneNumber,
                'status' => mt_rand(0, 1) ? Order::STATUS_CART : Order::STATUS_ORDER,
                'created_at' => $this->now,
                'updated_at' => $this->now
            ];
        }

        return $orders;
    }

    /**
     * Get order products
     *
     * @return array
     */
    private function getOrderProducts(): array
    {
        $ordersIds = Order::inRandomOrder()->pluck('id')->toArray();
        $productsIds = Product::pluck('id')->toArray();

        $orderProducts = [];

        foreach ($ordersIds as $ordersId) {
            foreach ($productsIds as $productsId) {
                $orderProducts[] = [
                    'order_id' => $ordersId,
                    'product_id' => $productsId,
                    'count' => mt_rand(1, 3),
                    'created_at' => $this->now,
                    'updated_at' => $this->now
                ];

                if (!rand(0, 3)) {
                    break;
                }
            }
        }

        return $orderProducts;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('orders')->insert($this->getOrders());
        DB::table('order_products')->insert($this->getOrderProducts());
    }
}
