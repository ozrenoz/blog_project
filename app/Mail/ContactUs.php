<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;
      protected $name;
      protected $email;
      protected $mailText;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $mailText)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mailText = $mailText;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
                   from: new Address($this->email, $this->name),
                   replyTo: [
                        new Address($this->email, $this->name),
                        ],
                   subject: 'New email from Contact Us page'
            );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'front.emails.contact_us',
            with: [
                'mailText' => $this->mailText,
                'name' => $this->name,
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
