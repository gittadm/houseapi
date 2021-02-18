<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use DB;

class UsersTableSeeder extends Seeder
{
    private const PASSWORD = 's1122334455';
    private const COUNT = 30;

    private $passwordHash;
    private $faker;
    private $now;

    /**
     * UsersTableSeeder constructor.
     */
    public function __construct()
    {
        $this->passwordHash = bcrypt(self::PASSWORD);
        $this->now = now()->toDateTimeString();
        $this->faker = Factory::create();
    }

    /**
     * Get users
     *
     * @return array
     */
    private function get(): array
    {
        $users = [];

        for ($i = 0; $i < self::COUNT; $i++) {
            $users[] = [
                'email' => 'user' . ($i + 1) . '@user.ru',
                'password' => $this->passwordHash,
                'name' => $this->faker->name,
                'phone' => $this->faker->phoneNumber,
                'email_verified_at' => rand(0, 3) ? $this->now : null,
                'created_at' => $this->now
            ];
        }

        return $users;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert($this->get());
    }
}
