<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue, ShouldBeEncrypted, ShouldBeUnique
{
    use Queueable;
    public $uniqueFor = 60; // Ensure the job is unique for 60 seconds


    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw("you are logged in", function ($message) {
            $message->to($this->user->email)
                ->subject("Welcome to our application");
        });
    }

    public function uniqueId(): string
    {
        return $this->user->id;
    }
}
