<?php

namespace App\Jobs;

use App\Jobs\Middleware\SendWelcomeEmailEnable;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\SkipIfBatchCancelled;

class TryAPICall implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info("Trying to call API...");
        $response = Http::get('https://httpbin.org/status/200');
        \Log::info("API response status: " . $response->status());

        if ($response->status() === 429) {
            $this->release(30); // Retry after 30 seconds
            return;
        }

        if ($response->status() !== 200) {
            $this->fail(new \Exception("API call failed with status: " . $response->status()));
            return;
        }
    }

    public function middleware()
    {
        return [new SendWelcomeEmailEnable];
    }
}
