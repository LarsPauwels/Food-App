<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Detail;
use Faker\Generator as Faker;

$factory->define(\App\Detail::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'name' => $faker->company,
        'address_id' => random_int(\App\Address::get()->min('id'), \App\Address::get()->max('id'))
    ];
});
