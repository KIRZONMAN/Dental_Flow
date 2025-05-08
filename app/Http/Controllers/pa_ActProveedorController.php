<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class pa_ActProveedorController extends Controller
{
    public function actualizarProveedor(Request $request)   
{
    #Validar los datos de entrada
    $request->validate([
        'nit' => 'required|string|max:20',
        'nombre' => 'required|string|max:50',
        'telefono' => 'required|string|max:50',
        'correo' => 'required|email|max:50', #validar como un email(@dominio.com)
    ]);

    $nit = (string) $request->input('nit');
    $nombre = $request->input('nombre');
    $telefono = (string) $request->input('telefono');
    $correo = $request->input('correo');
    DB::statement("CALL pa_ActualizarProveedor(?,?,?,?)",[$nit,$nombre,$telefono,$correo]); # ? ? ? Evita inyeccion SQL
    return redirect()->back()->with('success', 'Proveedor actualizado correctamente');
}

}
