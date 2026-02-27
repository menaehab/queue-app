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
    public $tries = 3; // Number of attempts before failing
    public $backoff = 10; // Time in seconds before retrying the job
    public $maxExceptions = 1; // Maximum number of exceptions allowed before failing the job
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
        throw new \Exception("Failed to send email");
        Mail::raw("you are logged in", function ($message) {
            $message->to($this->user->email)
                ->subject("Welcome to our application");
        });
    }

    public function uniqueId(): string
    {
        return $this->user->id;
    }

    public function failed($exception)
    {
        logger()->error("Failed to send welcome email for user {$this->user->id}: {$exception->getMessage()}");

    }
}
