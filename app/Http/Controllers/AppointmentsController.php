<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Appointments;
use Carbon\Carbon;
use Auth;

class AppointmentsController extends Controller
{
    public function todaysAppointments() {
    	$appt = \App\Appointments::whereBetween('start_time', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()] )
    								->where('staff_id', Auth::user()->id)
    								->with('user', 'client')
    								->get();
    	return $appt;
    }

    public function thisWeeksAppointments() {
    	$appt = \App\Appointments::whereBetween('start_time', [Carbon::now()->startOfWeek()->subDays(1)->startOfDay(), Carbon::now()->endOfWeek()->subDays(1)->endOfDay()] )
    								->where('staff_id', Auth::user()->id)
    								->with('user', 'client')
    								->get();
		return $appt;
    }
}
