<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:test {to?}';
    protected $description = 'Send a test email using the application mail configuration';

    public function handle()
    {
        $to = $this->argument('to') ?? config('mail.from.address');
        try {
            Mail::raw('Test message from application mailer', function ($m) use ($to) {
                $m->to($to)->subject('Laravel SMTP test');
            });
            $this->info('Mail sent (no exceptions thrown). Check inbox and logs.');
        } catch (\Exception $e) {
            $this->error('Mail send failed: ' . $e->getMessage());
            logger()->error('Mail test failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
