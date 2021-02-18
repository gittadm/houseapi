<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * List of the seeders to run only on the local server
     *
     * @var array
     */
    private array $localSeeders = [
        UsersTableSeeder::class,
        CategoriesTableSeeder::class,
        ProductsTableSeeder::class,
        OrdersTableSeeder::class
    ];

    /**
     * List of the seeders to run only on the production server
     *
     * @var array
     */
    private array $productionSeeders = [];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Disable logging of queries and checking foreign keys
        \DB::disableQueryLog();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        switch (app()->environment()) {
            case 'local':
                foreach ($this->localSeeders as $seeder) {
                    // Truncate table
                    \DB::table(\Str::snake(str_replace('TableSeeder', '', class_basename($seeder))))
                        ->truncate();

                    $this->call($seeder);
                }
                break;

            case 'production':
                foreach ($this->productionSeeders as $seeder) {
                    $this->call($seeder);
                }
                break;
        }

        // Enable logging of queries and checking foreign keys
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        \DB::enableQueryLog();
    }

}
