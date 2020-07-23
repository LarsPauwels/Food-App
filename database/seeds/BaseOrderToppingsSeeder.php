<?php

use Illuminate\Database\Seeder;

class BaseOrderToppingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Base_Order_Topping::class, 5)->create();
    }
}
