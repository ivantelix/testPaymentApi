<?php

namespace App\Listeners;

use App\Events\EventPaymentRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use App\Mail\PaymentMailNotifications;

use App\Models\Client;

class ListenerPaymentRegistered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EventPaymentRegistered  $event
     * @return void
     */
    public function handle(EventPaymentRegistered $event)
    {
        
        $client = Client::find($event->payment->client_id);
        
        $paymentDetail = [
            'client' => $client->email,
            'uuid' => $event->payment->uuid,
            'expires_at' => $event->payment->expires_at,
            'status' => $event->payment->status,
            'clp_usd' => $event->payment->clp_usd,
            'created_at' => $event->payment->created_at
        ];

        Mail::to($client->email)->send(new PaymentMailNotifications($paymentDetail));


    }
}
