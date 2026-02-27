<?php

namespace App\Jobs\Middleware;

use Closure;

class SendWelcomeEmailEnable
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        if (true) {
            $job->fail();
            return;
        }
        $next($job);
    }
}
