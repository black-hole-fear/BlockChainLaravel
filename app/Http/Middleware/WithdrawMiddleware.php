<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WithdrawMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $general = gs();
        if (!$general->withdrawal) {
            $notify[] = ['warning','Access denied for user'];
            return to_route('user.home')->withNotify($notify);
        }
        return $next($request);
    }
}
