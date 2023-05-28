<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorMiddleware
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
        $user = auth()->user();

        if (auth()->check() && $user->twoFactorCode->two_factor_code) {
            if (!now()->isBefore($user->twoFactorCode->expired_at)) {

                $user->resetTwoFactorCode();

                auth()->logout();

                return redirect()->route('register')->withStatus('The two factor code has expired. Please login again');
            }

            if (!$request->is('two_factor_authentication*')) {
                return redirect()->route('2fa.form');
            }
        }
        return $next($request);
    }
}
