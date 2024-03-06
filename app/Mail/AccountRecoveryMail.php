<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountRecoveryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }


        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.recoveryPassword')
                    ->subject('Reset Password Mail');
    }
}