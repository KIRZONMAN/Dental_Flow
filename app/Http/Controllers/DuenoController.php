<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DuenoController extends Controller
{
    public function configuracion(Request $request)
    {
        // Si es POST, guardamos en sesión de Laravel
        if ($request->isMethod('post')) {
            session([
                'dueno.nombre' => $request->input('nombre'),
                'dueno.telefono' => $request->input('telefono'),
                'dueno.email' => $request->input('email'),
            ]);
            return redirect('api/dueno');
        }

        // Valores por defecto
        $datos = [
            'nombre' => session('dueno.nombre', '(Nombre)'),
            'telefono' => session('dueno.telefono', '+57 34567890'),
            'email' => session('dueno.email', 'gerencia@dentalflow.com'),
            'especialidad' => 'Dueño',
        ];

        return view('dueno.dueno-configuracion', $datos);
    }
}
