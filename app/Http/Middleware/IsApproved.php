<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsApproved
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_approved != 1) {
            $redirect_to = "";
            if(auth()->user()->user_type == 'developer' || auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'directorate'){
                $redirect_to = "user.verify";
            } else {
                $redirect_to = "user.login";
            }

            // auth()->logout();

            flash(translate("You are an unapproved user. Please contact the administrator."));
            return redirect()->route($redirect_to);
        }

        return $next($request);
    }
}
