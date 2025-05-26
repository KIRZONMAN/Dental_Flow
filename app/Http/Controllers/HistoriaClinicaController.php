<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class HistoriaClinicaController extends Controller
{
    /** Lista todas las historias de un paciente */
    public function index(string $cedula)
    {
        $paciente = DB::table('pacientes')
            ->selectRaw("CONCAT(nombres_paciente,' ',apellidos_paciente) AS nombre")
            ->where('cedula', $cedula)
            ->first();

        $historias = DB::table('historias_clinicas')
            ->where('paciente_id', $cedula)
            ->orderBy('id_historia_clinica', 'desc')
            ->get();

        // Antes: view('odontologo.historias', …)
        return view('odontologo.historias_list', compact('paciente', 'historias'));
    }


    /** Borra una receta de una historia e invoca el trigger 17 */
    public function destroy(int $id)
    {
        try {
            DB::table('recetas_medicas')
                ->where('historia_clinica_id', $id)
                ->delete();
            return response()->json(['message' => 'Receta eliminada'], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
