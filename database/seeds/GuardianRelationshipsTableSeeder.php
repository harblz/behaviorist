<?php

use Illuminate\Database\Seeder;

class GuardianRelationshipsTableSeeder extends Seeder
{

    public function run()
    {
		factory('App\GuardianRelationships', 225)->create();
    }
}
