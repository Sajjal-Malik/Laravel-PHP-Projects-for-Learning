<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status === 'Blocked') {
            
            auth()->logout();

            return redirect()->route('login')->withErrors(['username' => 'Your account is blocked.']);
        }

        return $next($request);
    }
}

