<?php

use Illuminate\Database\Seeder;

class BaseOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Base_Order::class, 5)->create();
    }
}
