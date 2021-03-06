<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topping;
use Faker\Generator as Faker;

$factory->define(\App\Topping::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
        'isAvailable' => random_int(0, 1),
        'base_id' => random_int(\App\Base::get()->min('id'), \App\Base::get()->max('id')),
        'currency_id' => random_int(\App\Currency::get()->min('id'), \App\Currency::get()->max('id'))
    ];
});
