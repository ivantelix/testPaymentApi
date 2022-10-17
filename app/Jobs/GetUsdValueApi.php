<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

use App\Models\Payment;

class GetUsdValueApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     /**
     * The payment instance.
     *
     * @var \App\Models\Payment
     */
    protected $payment;

    /**
     * The current date value.
     *
     * @var date value format Y-m-d
     */
    protected $currentDate;

    /**
     * Create a new job instance.
     *
     * @param  App\Models\Payment  $payment
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->currentDate = date('Y-m-d');
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ( !session()->has('usdValue') ) {

            $res = Http::get('https://mindicador.cl/api/dolar');
            $res = $res->json('serie');

            foreach ($res as $value) {

                $valueDate = explode('T', $value['fecha'])[0];

                if ( $valueDate == $this->currentDate ) {

                    session()->put('usdValue', $value['valor']);

                }
            }

        }

        $payment = Payment::find($this->payment->id);
        $payment->update(['clp_usd' => session('usdValue')]);

    }
}
