<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderForVendor extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public Vendor $vendor;
    public $items;

    public function __construct(Order $order, Vendor $vendor)
    {
        $this->order  = $order;
        $this->vendor = $vendor;
        $this->items  = $order->orderItems->where('vendor_id', $vendor->id);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Order Received - Order #' . $this->order->id . ' | NepSole');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.new-order-vendor');
    }

    public function attachments(): array { return []; }
}
