<?
// app/Http/Middleware/IsBaakMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsBaakMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Logika untuk memeriksa apakah pengguna adalah BAAK
        // Misalnya, Anda dapat memeriksa peran atau atribut tertentu
        if (auth()->check() && auth()->user()->is_baak) {
            return $next($request);
        }

        return response([
            'message' => 'Anda tidak memiliki izin untuk mengakses ini.',
        ], 403);
    }
}
