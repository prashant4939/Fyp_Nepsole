<?php

namespace App\Mail;

use App\Models\VendorRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewVendorRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public VendorRequest $vendorRequest;

    public function __construct(VendorRequest $vendorRequest)
    {
        $this->vendorRequest = $vendorRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Vendor Application Received - NepSole');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-vendor-request');
    }

    public function attachments(): array
    {
        return [];
    }
}
