<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample customers
        $customers = [];
        for ($i = 1; $i <= 10; $i++) {
            $customers[] = User::create([
                'name' => "Customer $i",
                'email' => "customer$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample vendors
        $vendors = [];
        for ($i = 1; $i <= 5; $i++) {
            $vendors[] = User::create([
                'name' => "Vendor $i",
                'email' => "vendor$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'email_verified_at' => now(),
            ]);
        }

        // Create sample orders
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        for ($i = 1; $i <= 50; $i++) {
            Order::create([
                'customer_id' => $customers[array_rand($customers)]->id,
                'vendor_id' => $vendors[array_rand($vendors)]->id,
                'order_number' => 'ORD-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'total_amount' => rand(500, 10000),
                'status' => $statuses[array_rand($statuses)],
                'notes' => 'Sample order ' . $i,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('10 Customers, 5 Vendors, 50 Orders');
    }
}
