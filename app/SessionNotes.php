<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionNotes extends Model
{
    public function user() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function client() {
    	return $this->hasOne('App\Client', 'id', 'client_id');
    }
}
