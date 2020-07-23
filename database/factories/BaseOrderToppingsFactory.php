<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Base_Order_Topping;
use Faker\Generator as Faker;

$factory->define(\App\Base_Order_Topping::class, function (Faker $faker) {
	$baseOrderId = random_int(\App\Base_Order::get()->min('id'), \App\Base_Order::get()->max('id'));

    return [
        'base_order_id' => $baseOrderId,
        'topping_id' => random_int(\App\Topping::get()->min('id'), \App\Topping::get()->max('id')),
        'order_id' => (\App\Base_Order::where('base__orders.id', $baseOrderId)->first())->order_id
    ];
});
