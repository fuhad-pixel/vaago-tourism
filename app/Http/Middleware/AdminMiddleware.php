<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->role === 'admin' || $user->roles()->count() > 0) {
                return $next($request);
            }
        }
        return redirect('/admin')->withErrors(['email' => 'Access Denied. Admins only.']);
    }
}
