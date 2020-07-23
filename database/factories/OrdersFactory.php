<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'employee_id' => random_int(\App\Employee::get()->min('id'), \App\Employee::get()->max('id')),
        'supplier_id' => random_int(\App\Supplier::get()->min('id'), \App\Supplier::get()->max('id')),
        'timesheet_id' => random_int(\App\Timesheet::get()->min('id'), \App\Timesheet::get()->max('id'))
    ];
});
