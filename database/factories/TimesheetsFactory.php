<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Timesheet;
use Faker\Generator as Faker;

$factory->define(\App\Timesheet::class, function (Faker $faker) {
    return [
        'day' => $faker->dayOfWeek(),
        'from' => $faker->time($format = 'H:i'),
        'until' => $faker->time($format = 'H:i'),
        'active' => random_int(0, 1)
    ];
});
