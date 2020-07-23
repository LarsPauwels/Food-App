<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Timesheet;
use Faker\Generator as Faker;

$factory->define(\App\Timesheet::class, function (Faker $faker) {
    return [
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'time' => $faker->time($format = 'H:i:s', $max = 'now')
    ];
});
