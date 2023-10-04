<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'Akses Ditolak'); // Atau alihkan pengguna ke halaman lain jika perlu
        }
        return $next($request);
    }
}
