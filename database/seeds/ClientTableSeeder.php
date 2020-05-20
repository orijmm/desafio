<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::create([
            'email' => 'admin@example.com',
            'join_date' => date('Y-m-d')
        ]);
    }
}
