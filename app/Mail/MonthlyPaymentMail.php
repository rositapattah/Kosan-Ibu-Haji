<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyPaymentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $tagihan;

    public function __construct($user, $tagihan)
    {
        $this->user = $user;
        $this->tagihan = $tagihan;
    }

    public function build()
    {
        return $this->subject('Tagihan Bulanan Anda - ' . now()->format('F Y'))
                   ->view('emails.monthly_payment')
                   ->with([
                       'user' => $this->user,
                       'tagihan' => $this->tagihan,
                   ]);
    }
}