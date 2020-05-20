<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Payment;
use Illuminate\Http\Request;

class GetValueApiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $paymentid;
    protected $paymentdate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->paymentid = $payment->uuid;
        $this->paymentdate = $payment->payment_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        if (is_null($this->paymentdate)) {
            $apiUrl = 'https://mindicador.cl/api/dolar/';
        } else {
            $date = \Carbon\Carbon::createFromFormat('Y-m-d',$this->paymentdate)->format('d-m-Y');
            $apiUrl = 'https://mindicador.cl/api/dolar/'.$date;
        }
        
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
            
        $decode = json_decode($json,true);
    
        $updatePayment = Payment::find($this->paymentid);
        $updatePayment->clp_usd = $decode['serie'][0]['valor'];
        $updatePayment->save();
    }
}
