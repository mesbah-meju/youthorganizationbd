<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsUser
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
        if (Auth::check() && (Auth::user()->user_type == 'organization' || Auth::user()->user_type == 'directorate') ) {
            return $next($request);
        } else {
            session(['link' => url()->current()]);
            return redirect()->route('user.login');
        }
    }
}
