<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $shopName;
    public string $pin;

    public function __construct(string $vendorName, string $shopName, string $pin)
    {
        $this->vendorName = $vendorName;
        $this->shopName   = $shopName;
        $this->pin        = $pin;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Vendor Application Has Been Approved - NepSole');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.vendor-request-approved');
    }

    public function attachments(): array
    {
        return [];
    }
}
