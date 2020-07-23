<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(\App\Address::class, function (Faker $faker) {
    return [
        'street' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'city' => $faker->city,
        'province' => $faker->state,
        'country' => $faker->country
    ];
});
