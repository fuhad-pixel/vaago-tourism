<?php

namespace App\Mail;

use App\Models\Quotation;
use App\Models\CompanySetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $companySetting;
    public $publicUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Quotation $quotation, CompanySetting $companySetting, $publicUrl)
    {
        $this->quotation = $quotation;
        $this->companySetting = $companySetting;
        $this->publicUrl = $publicUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Travel Quotation - ' . ($this->quotation->title ?? $this->quotation->quotation_code),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quotation',
            with: [
                'quotation' => $this->quotation,
                'companySetting' => $this->companySetting,
                'publicUrl' => $this->publicUrl,
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
