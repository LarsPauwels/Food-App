<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(\App\Supplier::class, function (Faker $faker) {
	$idArray = \App\User::select('users.id')->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.name', '=', 'Supplier')->get();

    return [
    	'user_id' => $idArray[random_int(0, count($idArray) - 1)]->id,
        'detail_id' => random_int(\App\Address::get()->min('id'), \App\Address::get()->max('id'))
    ];
});
