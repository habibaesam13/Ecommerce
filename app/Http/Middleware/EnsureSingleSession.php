<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->session_id !== Session::getId()) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();

            return redirect()->route('Auth.login')->withErrors([
                'email' => 'Your session has expired because you logged in from another device.',
            ]);
        }
    }

    return $next($request);
}

}
