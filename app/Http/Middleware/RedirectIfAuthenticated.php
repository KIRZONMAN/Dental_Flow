<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Si el usuario ya está autenticado, redirige según rol.
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /* desde aquí corregí: redirigir según rol_id */
                $rol = Auth::user()->rol_id;
                return match ($rol) {
                    4 => redirect()->route('laboratorista.dashboard'),
                    3 => redirect()->route('asistente'),
                    2 => redirect()->route('odontologo.dashboard'),
                    1 => redirect()->route('administrador.dashboard'),
                    5 => redirect()->route('dueno.dashboard'),
                    default => redirect('/'),
                };
                /* hasta aquí corregí */
            }
        }

        return $next($request);
    }
}
