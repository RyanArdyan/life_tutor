<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // $penjaga berisi kosong($penjaga) jika kosong maka kosong dan jika tidak kosong maka diisi dengan $guards
        $guards = empty($guards) ? [null] : $guards;

        // lakukan pengulangan
        // untuk setiap $penjaga dijadikan $penjaga
        foreach ($guards as $guard) {
            // jika autentikasi::penjaga($penjaga) di cek apakah dia sudah login
            if (Auth::guard($guard)->check()) {
                // jika sudah login maka pang
                return response()->json('Anda sudah login', 401);
            }
        }

        return $next($request);
    }
}
