<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {

	$date = Carbon\Carbon::create(rand(2007, 2014), rand(1,12), rand(1,28), 0, 0, 0);

	$status = (rand(1,2) == 2 ? 'discharged' : 'potential' );
	$status = (rand(1,2) == 2 ? $status : 'active' );

    return [
        'first_name' => $faker->firstName,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'agency_id' => 1,
        'dob' => $date,
        'status' => $status,
    ];
});
