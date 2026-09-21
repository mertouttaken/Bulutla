<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Scheduler
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->subscription) {
            $subscription = $user->subscription;

            if ($subscription->status === 'active' && $subscription->ends_at && now()->greaterThan($subscription->ends_at)) {
                $subscription->cancel();
            }
        }

        return $next($request);
    }
}