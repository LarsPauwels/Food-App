<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(\App\Company::class, function (Faker $faker) {
	$idArray = \App\User::select('users.id')->join('roles', 'roles.id', '=', 'users.role_id')->where('roles.name', '=', 'Company')->get();

    return [
    	'user_id' => $idArray[random_int(0, count($idArray) - 1)]->id,
        'detail_id' => random_int(\App\Detail::get()->min('id'), \App\Detail::get()->max('id'))
    ];
});
