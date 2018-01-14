<?php

use Faker\Generator as Faker;

$factory->define(App\Staff::class, function (Faker $faker) {

	$dob = Carbon\Carbon::create(rand(1985, 1997), rand(1,12), rand(1,28), 0, 0, 0);
	$hire_date = Carbon\Carbon::create(rand(2013, 2016), rand(1,12), rand(1,28), 0, 0, 0);


	$status = ((rand(1,2) == 2) ? 'active' : 'inactive' );

    $end_date = null;
    if ($status == 'inactive') {
        $end_date = Carbon\Carbon::create(rand($hire_date->year, 2016), rand(1,12), rand(1,28), 0, 0, 0);
    }

    $user = App\User::where('user_type', NULL)->inRandomOrder()->take(1)->first();
    $user_id = $user->id;
    $status = (Rand(1, 2) == 2) ? 'active' : 'inactive';
    $user->user_type = 'staff';
    $user->status = $status;
    $user->save();

    return [
    	'agency_id' => 1,
    	'user_id' => $user_id,
    	'dob' => $dob,
    	'hire_date' => $hire_date,
        'end_date' => $end_date,
    	'status' => $status,
    ];
});
