<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$W6zQcJJxHK4be3.z2S.iUe36JKXepph90UiWfnN/SICQOASG1q6K2', //password
        'remember_token' => Str::random(10),
        'role_id' => random_int(\App\Role::get()->min('id'), \App\Role::get()->max('id'))
    ];
});
