<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $type; // 'admin' or 'user'

    /**
     * Create a new message instance.
     */
    public function __construct(Enquiry $enquiry, $type = 'admin')
    {
        $this->enquiry = $enquiry;
        $this->type = $type;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'admin' 
            ? 'New Enquiry Received - ' . config('app.name')
            : 'Thank You for Your Enquiry - ' . config('app.name');

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry',
            with: [
                'enquiry' => $this->enquiry,
                'type' => $this->type
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
