<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class accessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /*
        *   Check User role to pass to their Dashboard
        */ 

        if (! Auth::check()) {

            return redirect()->route('login');

        }elseif (Auth::user()->role == 'admin') {
            return $next($request);
        }elseif (Auth::user()->role == 'kitchen') {
            return $next($request);
        }elseif (Auth::user()->role == 'accountant') {
            return $next($request);
        }elseif (Auth::user()->role == 'order') {
            return $next($request);
        }

    }
}
