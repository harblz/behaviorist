<?php

use Illuminate\Database\Seeder;

class GuardiansTableSeeder extends Seeder
{

    public function run()
    {
		factory('App\Guardians', 100)->create();
    }
}
