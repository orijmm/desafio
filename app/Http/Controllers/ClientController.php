<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index()
    {
    	$clients = Client::all();
    	return response()->json($clients, 200);
    }
}
