<?php

namespace App\Http\Middleware;

use Closure;

class DisableCsrfForAdmin
{
    public function handle($request, Closure $next)
    {
        // Skip CSRF check for admin routes
        if ($request->is('admin/*') || $request->is('admin/login')) {
            return $next($request);
        }
        
        return $next($request);
    }
}