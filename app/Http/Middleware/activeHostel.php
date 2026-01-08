<?php

namespace App\Http\Middleware;

use App\Models\Hostel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class activeHostel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $slug = $request->route('hostel');
        $hostel = Hostel::whereSlug($slug)->firstOrFail();
        session(['active_hostel' => $hostel]);

        return $next($request);
    }
}
