<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
    	'company_id' => random_int(\App\Company::get()->min('id'), \App\Company::get()->max('id')),
        'employee_id' => random_int(\App\Employee::get()->min('id'), \App\Employee::get()->max('id')),
        'supplier_id' => random_int(\App\Supplier::get()->min('id'), \App\Supplier::get()->max('id')),
        'timesheet_id' => random_int(\App\Timesheet::get()->min('id'), \App\Timesheet::get()->max('id')),
        'delivery_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'total_price' => random_int(1, 100),
        'delivered' => random_int(0, 1)
    ];
});
