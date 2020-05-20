<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Payment;
use Illuminate\Support\Str;
use App\Jobs\GetValueApiJob;
use App\Events\SendMail;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
    	$payments = Client::find($request->client)->payments;
    	return response()->json($payments, 200);
    } 

    public function store(Request $request)
    {
    	$data = $request->all();
    	$data['uuid'] = (string) Str::uuid();
    	$storepayment = Payment::create($data);
    	dispatch(new GetValueApiJob($storepayment));
    	event(new SendMail());
    	return response()->json('success',200);
    }
}
