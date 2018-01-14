<?php

use Faker\Generator as Faker;

$factory->define(App\GuardianRelationships::class, function (Faker $faker) {

	$guardian_id = App\User::select('id')->where('user_type', 'guardian')->inRandomOrder()->pluck('id')->first();
	$client_id = App\Client::select('id')->inRandomOrder()->pluck('id')->first();

    return [
        'client_id' => $client_id,
        'guardian_id' => $guardian_id,
    ];
});
