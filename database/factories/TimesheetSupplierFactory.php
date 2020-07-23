<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Timesheet_Supplier;
use Faker\Generator as Faker;

$factory->define(\App\Timesheet_Supplier::class, function (Faker $faker) {
    return [
        'timesheet_id' => random_int(\App\Timesheet::get()->min('id'), \App\Timesheet::get()->max('id')),
        'supplier_id' => random_int(\App\Supplier::get()->min('id'), \App\Supplier::get()->max('id'))
    ];
});
