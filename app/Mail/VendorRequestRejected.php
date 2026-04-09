<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorRequestRejected extends Mailable
{
    use Queueable, SerializesModels;

    public string $vendorName;
    public string $shopName;
    public string $adminMessage;

    public function __construct(string $vendorName, string $shopName, string $adminMessage)
    {
        $this->vendorName   = $vendorName;
        $this->shopName     = $shopName;
        $this->adminMessage = $adminMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Vendor Application Status - NepSole');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.vendor-request-rejected');
    }

    public function attachments(): array
    {
        return [];
    }
}
