<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test {to}';
    protected $description = 'Send a test email';

    public function handle()
    {
        $to = $this->argument('to');
        try {
            Mail::raw('This is a test email from NepSole. Mail is working correctly!', function ($msg) use ($to) {
                $msg->to($to)->subject('NepSole Mail Test');
            });
            $this->info("✅ Test email sent to: {$to}");
        } catch (\Exception $e) {
            $this->error("❌ Mail failed: " . $e->getMessage());
        }
    }
}
