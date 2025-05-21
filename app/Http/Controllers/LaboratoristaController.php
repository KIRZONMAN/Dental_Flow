<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenLaboratorio;
use App\Models\Insumo;
use Carbon\Carbon;

class LaboratoristaController extends Controller
{
    public function index()
    {
        // Dashboard summary
        $hoy = Carbon::today();
        $ordenesHoy = OrdenLaboratorio::with([
            'cita.paciente',
            'cita.odontologo',
            'productos.insumo'
        ])
            ->whereDate('fecha_limite', Carbon::today())
            ->get();

        $enProduccion = OrdenLaboratorio::where('estado', 'en producción')->count();
        $insumosBajos = Insumo::whereColumn('cantidad_insumo', '<=', 'umbral_alerta')->count();

        return view('laboratorista.laboratorista', compact('ordenesHoy', 'enProduccion', 'insumosBajos'));
    }

    public function ordenesHoy()
    {
        $hoy = Carbon::today()->toDateString();

        $ordenes = OrdenLaboratorio::with([
            'cita.paciente',
            'cita.odontologo',
            'productos.insumo'
        ])
            ->whereDate('fecha_limite', $hoy)
            ->orderByDesc('fecha_limite')
            ->paginate(10);

        return view('laboratorista.Lab_Pedidos', compact('ordenes'));
    }



    public function show($id)
    {
        $orden = OrdenLaboratorio::with(['cita.paciente', 'cita.odontologo', 'productos.insumo'])
            ->findOrFail($id);

        return view('laboratorista.orden_show', compact('orden'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate(['estado' => 'required|in:pendiente,en producción,listo para enviar,entregada,rechazada']);
        $orden = OrdenLaboratorio::findOrFail($id);
        $orden->estado = $request->estado;
        $orden->save();

        return back()->with('success', 'Estado actualizado.');
    }

    public function addProducto(Request $request, $id)
    {
        $data = $request->validate([
            'insumo_id' => 'required|exists:insumos,id_insumo',
            'cantidad' => 'required|integer|min:1'
        ]);

        $orden = OrdenLaboratorio::findOrFail($id);
        $insumo = Insumo::findOrFail($data['insumo_id']);

        if ($insumo->cantidad_insumo < $data['cantidad']) {
            return back()->withErrors(['insumo_id' => 'Stock insuficiente']);
        }

        // crear producto y descontar stock
        $producto = $orden->productos()->create([
            'insumo_id' => $insumo->id_insumo,
            'cantidad' => $data['cantidad'],
            'detalles' => $request->input('detalles', '')
        ]);
        $insumo->decrement('cantidad_insumo', $data['cantidad']);

        return back()->with('success', 'Producto agregado.');
    }

    public function insumos()
    {
        // Traigo todos los insumos
        $insumos = \App\Models\Insumo::all();

        // Los paso a la vista gestionInsumos.blade.php
        return view('gestionInsumos', compact('insumos'));
    }

    public function config()
    {
        // Pantalla de configuración de notificac. y perfiles
        return view('laboratorista.configuracion4');
    }

    public function all()
    {
        // Carga todas las órdenes sin filtrar
        $ordenes = OrdenLaboratorio::with([
            'cita.paciente',
            'cita.odontologo',
            'productos.insumo'
        ])
            ->orderByDesc('fecha_solicitud')
            ->paginate(10);

        return view('laboratorista.Lab_Pedidos', compact('ordenes'));
    }






}
