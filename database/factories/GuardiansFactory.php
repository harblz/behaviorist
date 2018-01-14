<?php

use Faker\Generator as Faker;

$factory->define(App\Guardians::class, function (Faker $faker) {

	//$guardian_ids = App\User::select('id')->where('user_type', 'guardian')->pluck('id')->all();
	//$client_ids = App\Client::select('id')->pluck('id')->all();

	$user = App\User::where('user_type', NULL)->inRandomOrder()->take(1)->first();
    $user_id = $user->id;
    $user->user_type = 'guardian';
    $user->save();

    return [
        'id' => $user_id,
    ];
});
