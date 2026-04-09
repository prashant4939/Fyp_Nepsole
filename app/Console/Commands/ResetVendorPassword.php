<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetVendorPassword extends Command
{
    protected $signature = 'vendor:reset-password {email}';
    protected $description = 'Reset a vendor password to a known PIN';

    public function handle()
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No user found with email: {$email}");
            return 1;
        }

        $pin = '1234';
        $user->password = Hash::make($pin);
        $user->role     = 'vendor';
        $user->save();

        $this->info("✅ Password reset for: {$user->name} ({$user->email})");
        $this->info("   Role   : {$user->role}");
        $this->info("   New PIN: {$pin}");
        $this->info("   Login  : " . url('/vendor/login'));

        return 0;
    }
}
