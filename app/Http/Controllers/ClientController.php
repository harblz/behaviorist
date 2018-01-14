<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getAll() {
    	$clients = $client_count = \App\Client::where(['status' => 'active', 'agency_id' => 1])->get();
    	return response($clients);
    }
}
