<?php

namespace Bala\SelfHealingUrl\Middleware;

use Closure;
use Illuminate\Http\Request;

class NormalizeUrl
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->getPathInfo();
        $normalized = '/' . trim(strtolower($path), '/');

        if ($normalized === '') $normalized = '/';

        if ($normalized !== $path) {
            return redirect($normalized, 301);
        }

        return $next($request);
    }
}
