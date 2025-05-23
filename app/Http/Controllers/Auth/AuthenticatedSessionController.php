<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController
{
    // Muestra la vista del login
    public function create(): View
    {
        return view('auth.login'); // asegúrate de que esta vista exista
    }

    // Cierra sesión y redirige
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // redirige al login después de logout
    }
}
