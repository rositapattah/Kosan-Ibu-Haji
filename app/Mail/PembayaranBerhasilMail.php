<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pembayaran;

class PembayaranBerhasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pembayaran;

    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function build()
    {
        return $this->subject('Resi Pembayaran Tagihan Anda')
                    ->markdown('emails.resi_pembayaran_email_template')
                    ->with([
                        'user' => $this->pembayaran->user,
                        'pembayaran' => $this->pembayaran,
                        'tagihan' => $this->pembayaran->tagihan,
                    ]);
    }
}
