<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Pastikan user yang mengakses adalah admin.
     * Jika bukan admin, kembalikan respon JSON 403 atau redirect dengan pesan error.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akses ditolak. Hanya admin yang diizinkan.',
                ], Response::HTTP_FORBIDDEN);
            }

            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman tersebut khusus untuk Admin.');
        }

        return $next($request);
    }
}
