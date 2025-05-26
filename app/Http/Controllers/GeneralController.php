<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insumo;

class GeneralController extends Controller
{
      public function insumos()
    {
        // Traigo todos los insumos
        $insumos = Insumo::all();

        // Los paso a la vista gestionInsumos.blade.php
        return view('gestionInsumos', compact('insumos'));
    }
}
