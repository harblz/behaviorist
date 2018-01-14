<?php

use Illuminate\Database\Seeder;

class AgencyTableSeeder extends Seeder
{

    public function run()
    {
		factory('App\Agency', 1)->create();
    }
}
