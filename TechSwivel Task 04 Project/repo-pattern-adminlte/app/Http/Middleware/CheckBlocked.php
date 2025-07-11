<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!auth()->check()) {

            return redirect()->route('login');
        }

        if (auth()->user()->isBlocked) {

            auth()->logout();

            return redirect()->route('login')->withErrors(['email' => 'This User is BLOCKED, Contact SUPER ADMIN']);
        }

        return $next($request);
    }
}
