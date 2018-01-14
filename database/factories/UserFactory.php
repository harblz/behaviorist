<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'street_address' => $faker->streetAddress,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'state' => 'Florida',
        'country' => 'USA',
        'contact_phone_work' => $faker->phoneNumber,
        'contact_phone_home' => $faker->phoneNumber,
        'contact_phone_cell' => $faker->phoneNumber,
        'preferred_contact' => (Rand(1, 2) == 2) ? 'work' : 'cell',
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
