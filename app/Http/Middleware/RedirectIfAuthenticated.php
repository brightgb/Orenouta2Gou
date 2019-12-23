<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $redir = '/';
        switch ($guard) {
            case "admin":
                $redir = '/admin';
                break;
            case "performer":
                $redir = '/performer';
                break;
            default:
                $redir = '/';
                break;
        }
        if (Auth::guard($guard)->check()) {
            return redirect($redir);
        }

        return $next($request);
    }
}