<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BackendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   
        
        if (Auth::guard($guard)->check()) {
            if ($guard == 'backend') {
                // return $next($request);
                // return redirect('/dashboard');
            }
        } 
        return $next($request);
    }
}
