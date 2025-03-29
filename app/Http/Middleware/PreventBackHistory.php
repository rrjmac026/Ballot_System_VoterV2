<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        return $response->header('Cache-Control', 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->header('X-Frame-Options', 'DENY')
            ->header('Clear-Site-Data', '"cache", "cookies", "storage", "executionContexts"');
    }
}
