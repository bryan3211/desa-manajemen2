<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Track visitor on specific pages
        if ($this->shouldTrack($request)) {
            try {
                DB::table('visitors')->insert([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'action' => 'view',
                    'page' => $request->path(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Silently fail if tracking fails
            }
        }

        return $next($request);
    }

    /**
     * Check if request should be tracked
     */
    private function shouldTrack(Request $request)
    {
        $trackedPages = [
            '/',
            'login',
            'register',
            'dashboard',
        ];

        foreach ($trackedPages as $page) {
            if ($request->is($page) || $request->is($page . '*')) {
                return true;
            }
        }

        return false;
    }
}
