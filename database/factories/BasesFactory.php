<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Base;
use Faker\Generator as Faker;

$factory->define(\App\Base::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->realText(191),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
        'currency_id' => random_int(\App\Currency::get()->min('id'), \App\Currency::get()->max('id'))
    ];
});
