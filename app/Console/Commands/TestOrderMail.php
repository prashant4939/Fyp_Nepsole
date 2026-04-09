<?php

namespace App\Console\Commands;

use App\Mail\NewOrderForVendor;
use App\Mail\OrderItemConfirmed;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestOrderMail extends Command
{
    protected $signature = 'mail:test-order';
    protected $description = 'Send test order emails using the latest order';

    public function handle()
    {
        $order = Order::with([
            'orderItems.product',
            'orderItems.variant',
            'user',
            'shippingAddress',
        ])->latest()->first();

        if (!$order) {
            $this->error('No orders found in the database.');
            return 1;
        }

        $this->info("Using Order #{$order->id} — Customer: {$order->user->email}");

        // ── Test 1: Vendor new order notification ──
        $vendorIds = $order->orderItems->pluck('vendor_id')->unique()->filter();

        if ($vendorIds->isEmpty()) {
            $this->warn('No vendor IDs on order items — skipping vendor email.');
        } else {
            foreach ($vendorIds as $vendorId) {
                $vendor = Vendor::with('user')->find($vendorId);
                if (!$vendor || !$vendor->user) {
                    $this->warn("Vendor #{$vendorId} not found, skipping.");
                    continue;
                }
                try {
                    Mail::to($vendor->user->email)->send(new NewOrderForVendor($order, $vendor));
                    $this->info("✅ Vendor email sent to: {$vendor->user->email}");
                } catch (\Exception $e) {
                    $this->error("❌ Vendor email failed: " . $e->getMessage());
                }
            }
        }

        // ── Test 2: Customer item confirmed notification ──
        $firstItem = $order->orderItems->first();
        if (!$firstItem) {
            $this->warn('No order items found — skipping customer email.');
            return 0;
        }

        try {
            Mail::to($order->user->email)->send(new OrderItemConfirmed($order, $firstItem));
            $this->info("✅ Customer confirmation email sent to: {$order->user->email}");
        } catch (\Exception $e) {
            $this->error("❌ Customer email failed: " . $e->getMessage());
        }

        return 0;
    }
}
