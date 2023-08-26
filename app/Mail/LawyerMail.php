<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LawyerMail extends Mailable
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
    public function __construct($type, $name, $mail, $num)
    {
        $this->type = $type;
        $this->name = $name;
        $this->mail = $mail;
        $this->num = $num;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 1)
            return $this->to($this->mail)
                ->subject("弁護士アカウントの申請結果")
                ->view('Lawyer.successMail')
                ->with([
                    'name' => $this->name,
                    'mail' => $this->mail,
                    'num' => $this->num,
                ]);
        else
            return $this->to($this->mail)
                ->subject("弁護士アカウントの申請結果")
                ->view('Lawyer.failMail')
                ->with([
                    'name' => $this->name,
                    'mail' => $this->mail,
                    'num' => $this->num,
                ]);
    }

}