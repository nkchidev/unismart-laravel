<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AdminSession
{
    public function handle(Request $request, Closure $next)
    {
        Config::set('session.cookie', config('session.admin_cookie'));
        return $next($request);
    }
} 