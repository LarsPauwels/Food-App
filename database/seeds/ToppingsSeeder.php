<?php

use Illuminate\Database\Seeder;

class ToppingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Topping::class, 5)->create();
    }
}
