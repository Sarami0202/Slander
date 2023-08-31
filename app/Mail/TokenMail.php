<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TokenMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$token,$date)
    {
        $this->mail = $mail;
        $this->token = $token;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->mail)
            ->subject('認証コードの確認')
            ->view('Token.mail')
            ->with([
                'mail' => $this->mail,
                'token' => $this->token,
                'date' => $this->date,
            ]);
    }

}