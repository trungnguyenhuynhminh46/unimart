<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Closure;

class GuestOrActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if ($request->user() && $request->user() instanceof MustVerifyEmail && !$request->user()->hasVerifiedEmail()) {
            request()->session()->flush();
            return Redirect::route('verification.notice');
        }
        return $next($request);
    }
}
