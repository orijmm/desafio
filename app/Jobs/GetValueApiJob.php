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
        $checkOldPay = NULL;
        if (is_null($this->paymentdate)) {
            $apiUrl = 'https://mindicador.cl/api/dolar/';
        } else {
            $checkOldPay = Payment::where('payment_date',$this->paymentdate)->first();
            $date = \Carbon\Carbon::createFromFormat('Y-m-d',$this->paymentdate)->format('d-m-Y');
            $apiUrl = 'https://mindicador.cl/api/dolar/'.$date;
        }

        if(is_null($checkOldPay)){
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            curl_close($curl);

            $decode = json_decode($json,true);
            $usd_value = $decode['serie'][0]['valor'];
        }else{
            $usd_value = $checkOldPay->clp_usd;
        }
            
        $updatePayment = Payment::find($this->paymentid);
        $updatePayment->clp_usd = $usd_value;
        $updatePayment->save();
    }
}
