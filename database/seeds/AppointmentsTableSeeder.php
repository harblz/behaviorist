<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{

    public function run()
    {
		//factory('App\Appointments', 1)->create();
		$users = App\User::all();

		foreach($users as $user) {
			if ( $user->user_type == 'staff' ) {
				for ( $i = 0; $i <= 90; $i++) {
					$appt = new App\Appointments;
					$appt->staff_id 	= $user->id;
					$appt->client_id 	= App\Client::where('status', 'active')->inRandomOrder()->take(1)->select('id')->pluck('id')->first();
					$appt->service      = 'Therapy';
					$appt->start_time	= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(8);
					$appt->end_time		= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(9);
					$appt->save();

					$appt = new App\Appointments;
					$appt->staff_id 	= $user->id;
					$appt->client_id 	= App\Client::where('status', 'active')->inRandomOrder()->take(1)->select('id')->pluck('id')->first();
					$appt->service      = 'Therapy';
					$appt->start_time	= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(9);
					$appt->end_time		= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(12);
					$appt->save();

					$appt = new App\Appointments;
					$appt->staff_id 	= $user->id;
					$appt->client_id 	= App\Client::where('status', 'active')->inRandomOrder()->take(1)->select('id')->pluck('id')->first();
					$appt->service      = 'Therapy';
					$appt->start_time	= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(12);
					$appt->end_time		= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(14);
					$appt->save();

					$appt = new App\Appointments;
					$appt->staff_id 	= $user->id;
					$appt->client_id 	= App\Client::where('status', 'active')->inRandomOrder()->take(1)->select('id')->pluck('id')->first();
					$appt->service      = 'Therapy';
					$appt->start_time	= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(14);
					$appt->end_time		= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(16.5);
					$appt->save();

					$appt = new App\Appointments;
					$appt->staff_id 	= $user->id;
					$appt->client_id 	= App\Client::where('status', 'active')->inRandomOrder()->take(1)->select('id')->pluck('id')->first();
					$appt->service      = 'Therapy';
					$appt->start_time	= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(16.5);
					$appt->end_time		= Carbon::today()->endOfWeek()->subDays(1)->subDays($i)->startOfDay()->addHours(18);
					$appt->save();
				}
			}

		}
    }
}
