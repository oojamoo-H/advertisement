<?php

namespace App\Http\Middleware;

use Closure;

class AdminApiAuth
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

        if ($request->headers->has('x-session-token') && $request->session()->get('admin_user') === $request->headers->get('x-session-token')){
            return $next($request);
        } else {
            abort('403', 'No Right Visit');
        }
    }
}
