<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Base_Order;
use Faker\Generator as Faker;

$factory->define(\App\Base_Order::class, function (Faker $faker) {
    return [
        'order_id' => random_int(\App\Order::get()->min('id'), \App\Order::get()->max('id')),
        'base_id' => random_int(\App\Base::get()->min('id'), \App\Base::get()->max('id'))
    ];
});
