<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    public function user() {
    	return $this->hasOne('App\User', 'id', 'staff_id');
    }

    public function client() {
    	return $this->hasOne('App\Client', 'id', 'client_id');
    }
}
