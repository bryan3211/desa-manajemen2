<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $subject;
    public $name;
    public $otp;
    public $expireAt;

    public function __construct($subject, $name, $otp, $expireAt)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->otp = $otp;
        $this->expireAt = $expireAt;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp');
    }
}