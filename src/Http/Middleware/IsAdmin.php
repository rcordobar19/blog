<?php

namespace MetaGameTechnologies\Blog\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if(Auth::user() && Auth::user()->is_admin == 1){
            return $next($request);
        }

        throw new AuthenticationException();
    }
}
