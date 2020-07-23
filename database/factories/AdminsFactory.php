<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(\App\Admin::class, function (Faker $faker) {
	$idArray = \App\User::select('users.id')->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.name', '=', 'Admin')->get();
	
    return [
        'firstname' => $faker->firstName(),
        'lastname' => $faker->lastName(),
        'user_id' => $idArray[random_int(0, count($idArray) - 1)]->id
    ];
});
