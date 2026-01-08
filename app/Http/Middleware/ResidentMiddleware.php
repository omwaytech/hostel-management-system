<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResidentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with(
                notificationMessage('error', 'Access', 'denied', 'Please login to access the resident portal.')
            );
        }

        if (auth()->user()->role_id != 4) {
            return redirect()->route('home')->with(
                notificationMessage('error', 'Access', 'denied', 'You do not have permission to access the resident portal.')
            );
        }

        if (!auth()->user()->resident) {
            return redirect()->route('home')->with(
                notificationMessage('error', 'Access', 'denied', 'No resident profile found for your account.')
            );
        }

        // Store resident in session
        if (!session()->has('current_resident')) {
            session(['current_resident' => auth()->user()->resident]);
            session(['current_resident_id' => auth()->user()->resident->id]);
        }

        return $next($request);
    }
}
