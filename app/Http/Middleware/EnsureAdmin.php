<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Pastikan user yang mengakses adalah admin.
     * Jika bukan admin, kembalikan respons 403 Forbidden.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Hanya admin yang diizinkan.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
