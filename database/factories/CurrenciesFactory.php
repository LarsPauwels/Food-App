<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Currency;
use Faker\Generator as Faker;

$factory->define(\App\Currency::class, function (Faker $faker) {
    return [
        'name' => $faker->currencyCode
    ];
});
