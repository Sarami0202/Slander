<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
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
    public function __construct($type,$name,$mail,$tel,$body,$date)
    {
        $this->type = $type;
        $this->name = $name;
        $this->mail = $mail;
        $this->tel = $tel;
        $this->body = $body;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to("sarami0202@icloud.com")
            ->subject($this->type)
            ->view('inquiry.mail')
            ->with([
                'name' => $this->name,
                'mail' => $this->mail,
                'tel' => $this->tel,
                'body' => $this->body,
                'date' => $this->date,
            ]);
    }

}