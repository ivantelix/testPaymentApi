<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentMailNotifications extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The payment details.
     *
     * @var Payment detail data
     */
    public $paymentDetail;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentDetail)
    {
        $this->paymentDetail = $paymentDetail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Payment Mail Notifications',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.payments.payment_notifications',
            with: [
                'client' => $this->paymentDetail['client'],
                'status' => $this->paymentDetail['status'],
                'date' => $this->paymentDetail['created_at']
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
