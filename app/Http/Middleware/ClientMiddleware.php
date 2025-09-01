<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use App\CentralLogics\Helpers;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

     if (Auth::guard('client')->check()) {
            if (!auth('client')->user()->status) {
                auth()->guard('client')->logout();
                return redirect()->route('home');
            }

            if (session('login_remember_token') !== auth('client')->user()?->login_remember_token) {
                auth()->guard('client')->logout();
                session()->invalidate();
                session()->regenerateToken();
                $user_link = Helpers::get_login_url('store_login_url');
                return redirect()->route('login', [$user_link])
                    ->withErrors(['Your session has expired. Please log in again.']);
            }

            return $next($request);
        } else if (Auth::guard('client_employee')->check()) {
            if (Auth::guard('client_employee')->user()->is_logged_in == 0) {
                auth()->guard('client_employee')->logout();
                return redirect()->route('home');
            }
            if (!auth('client_employee')->user()->store->status) {
                auth()->guard('client_employee')->logout();
                return redirect()->route('home');
            }

            if (session('login_remember_token') !== Auth::guard('client_employee')->user()?->login_remember_token) {
                auth()->guard('client_employee')->logout();
                session()->invalidate();
                session()->regenerateToken();
                $user_link = Helpers::get_login_url('store_employee_login_url');
                return redirect()->route('login', [$user_link])
                    ->withErrors(['Your session has expired. Please log in again.']);
            }
            return $next($request);
        }
        return redirect()->route('home');

        // return $next($request);
    }
}
