<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ProcedimientoController extends Controller
{
    public function index()
    {
        $procedimientos = DB::table('procedimientos')->get();
        return view('administrador.procedimientos', compact('procedimientos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_procedimiento' => 'required|string|max:30',
            'costo'             => 'required|numeric'
        ]);

        try {
            DB::table('procedimientos')->insert([
                'tipo_procedimiento' => $data['tipo_procedimiento'],
                'costo'              => $data['costo'],
            ]);
            return redirect()->back()->with('success', 'Procedimiento creado.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('procedimientos')
                ->where('id_procedimiento', $id)
                ->delete();
            return redirect()->back()->with('success', 'Procedimiento eliminado.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
