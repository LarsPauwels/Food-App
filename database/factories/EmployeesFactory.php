<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(\App\Employee::class, function (Faker $faker) {
	$idArray = \App\User::select('users.id')->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.name', '=', 'Employee')->get();

    return [
        'firstname' => $faker->firstName(),
        'lastname' => $faker->lastName(),
        'user_id' => $idArray[random_int(0, count($idArray) - 1)]->id,
        'company_id' => random_int(\App\Company::get()->min('id'), \App\Company::get()->max('id'))
    ];
});
