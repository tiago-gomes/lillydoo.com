<?php

namespace App\Core\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;

class JsonMiddleware {
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}