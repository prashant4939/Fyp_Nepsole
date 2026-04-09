<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderItemConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public OrderItem $orderItem;
    public string $trackUrl;

    public function __construct(Order $order, OrderItem $orderItem)
    {
        $this->order     = $order;
        $this->orderItem = $orderItem;
        $this->trackUrl  = url('/orders/' . $order->id);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Order Item Has Been Confirmed - Order #' . $this->order->id . ' | NepSole');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-item-confirmed');
    }

    public function attachments(): array { return []; }
}
