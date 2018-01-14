<?php

use Faker\Generator as Faker;

$factory->define(App\Agency::class, function (Faker $faker) {
    return [
        'agency_name' => 'ACME Behavior Company, LLC'
    ];
});
