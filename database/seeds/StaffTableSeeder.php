<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{

    public function run()
    {
		factory('App\Staff', 25)->create();
    }
}
