<?php

use Illuminate\Database\Seeder;
use App\Payment;
use App\Client;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = Payment::create([
	        "uuid" => "4dc2aa90-744e-46da-aeea-952e211b719d",
			"payment_date" => null,
			"expires_at" => "2019-01-01",
			"status" => "pending",
			"user_id" => Client::orderByRaw('RAND()')->first()->id,
			"clp_usd" => 810,
        ]);

        $payments = Payment::create([
            "uuid" => "4638609f-0b81-4d5d-a82a-456533e2d509",
			"payment_date" => "2019-12-01",
			"expires_at" => "2020-01-01",
			"status" => "paid",
			"user_id" => Client::orderByRaw('RAND()')->first()->id,
			"clp_usd" => 820,
        ]);
    }
}
