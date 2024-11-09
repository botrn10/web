<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Log;

class SendOtpUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $user;
    protected $otp;

    public function __construct($user, $otp)
    {
        Log::info("----------- SendOtpUpdateEmail ---------");
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        Log::info("----------- envelope ---------");
        return new Envelope(
            from: new Address('thangb1906766@gmail.com', 'Thắng Lê'),
            subject: 'OTP update email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
       
        return new Content(
            view: 'email.otp_update_email',
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ],
        );

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
