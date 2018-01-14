<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SessionNotesTableSeeder extends Seeder
{

    public function run()
    {

		$appointments = App\Appointments::with('user', 'client')->get();

		foreach($appointments as $appt) {

					$note 				= new App\SessionNotes;
					$note->user_id 		= $appt->staff_id;
					$note->client_id 	= $appt->client_id;
					$note->note      	= 'Therapy service provided on ' . Carbon::parse($appt->start_time)->toDateTimeString() . ' for ' . $appt->client->first_name . ' ' . $appt->client->last_name . ' by therapist ' . $appt->user->first_name . ' ' . $appt->user->last_name;
					$note->session_date = $appt->start_time;
					$note->save();

		}
    }
}
