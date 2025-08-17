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
    public function handle(Request $request, Closure $next): Response {
        if (Auth::check()) {
            $user = Auth::user();
            // If the current session is not the same as the one stored in the DB → Logout
            if ($user->session_id !== Session::getId()) {
                Auth::logout();
                return redirect()->route('Auth.login')->withErrors([
                    'email' => 'You are already logged in from another device. Please log out from that device first.',
                ]);
            }
        }
        return $next($request);
    }
}
