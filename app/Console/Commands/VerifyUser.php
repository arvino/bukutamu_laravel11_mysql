<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Command;

class VerifyUser extends Command
{
    protected $signature = 'user:verify {email}';
    protected $description = 'Verify user email for development';

    public function handle()
    {
        $email = $this->argument('email');
        $user = Member::where('email', $email)->firstOrFail();
        
        $user->markEmailAsVerified();
        
        $this->info("User {$email} has been verified!");
    }
} 