<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\SessionNotes;
use Auth;

class SessionNotesController extends Controller
{
    public function getClientsNotes($clientID) {
    	$start_date = Carbon::now()->startOfDay();
    	$end_date   = Carbon::now()->endOfDay();

    	$notes = \App\SessionNotes::whereBetween('session_date', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()] )
    								->where('client_id', $clientID)
    								->with('user', 'client')
    								->get();
    	return $notes;
    }

    public function store()
    {
        $this->validate(request(), [
        	'client_id'   => 'required',
            'description' => 'required'
        ]);

        SessionNotes::forceCreate([
            'user_id' 		=> Auth::user()->id,
            'client_id' 	=> request('client_id'),
            'note' 			=> request('description'),
            'session_date'	=> Carbon::now()->toDateTimeString(),
        ]);

        return ['message' => 'Note Saved!'];
    }
}
