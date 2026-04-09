<?php

namespace App\Console\Commands;

use App\Mail\VendorRequestApproved;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResendVendorCredentials extends Command
{
    protected $signature = 'vendor:resend-credentials {email}';
    protected $description = 'Reset PIN and resend login credentials to a vendor';

    public function handle()
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No user found with email: {$email}");
            return 1;
        }

        $pin = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $user->password = Hash::make($pin);
        $user->save();

        $shopName = $user->vendor?->business_name ?? 'Your Shop';

        try {
            Mail::to($user->email)->send(new VendorRequestApproved($user->name, $shopName, $pin));
            $this->info("✅ Credentials emailed to: {$email}");
            $this->info("   PIN: {$pin} (also saved to account)");
        } catch (\Exception $e) {
            $this->error("❌ Mail failed: " . $e->getMessage());
        }

        return 0;
    }
}
