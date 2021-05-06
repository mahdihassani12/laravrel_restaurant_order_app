<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class kitchenAuthenticated
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
        if( Auth::check() )
        {
            // if user is not admin take him to his dashboard
            if ( Auth::user()->role == 'admin' ) {
                 return redirect(route('adminDashboard'));
            }
            elseif( Auth::user()->role == 'accountant'){
                 return redirect(route('accountantDashboard'));   
            }
            elseif( Auth::user()->role == 'order'){
                 return redirect(route('orderDashboard'));   
            }
            elseif ( Auth::user()->role == 'kitchen' ) {
               return $next($request);
            }
        }

        abort(404);  // for other user throw 404 error
    }
}
