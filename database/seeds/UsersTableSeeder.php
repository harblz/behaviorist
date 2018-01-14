<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
		factory('App\User', 200)->create();

		$harblz = new App\User;
		$harblz->first_name = "Alex";
		$harblz->middle_name = "Martin";
		$harblz->last_name = "Raymond";
		$harblz->user_type = "staff";
		$harblz->email = "harblz@gmail.com";
		$harblz->street_address = "805 B Miccosukee Road";
		$harblz->city = "Tallahassee";
		$harblz->postcode = "32303";
		$harblz->state = "Florida";
		$harblz->country = "USA";
		$harblz->contact_phone_work = "352-672-0022";
		$harblz->contact_phone_home = "352-672-0022";
		$harblz->contact_phone_cell = "352-672-0022";
		$harblz->preferred_contact = "cell";
		$harblz->password = bcrypt('Exitus1lol'); // super secret test password
		$harblz->remember_token = str_random(10);
		$harblz->save();
    }
}
