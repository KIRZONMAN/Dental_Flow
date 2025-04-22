<?php
namespace App\Services;

use App\Contracts\PacienteServiceInterface;
use Illuminate\Support\Facades\DB;

class PacienteService implements PacienteServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerPacientes()');
    }

    public function find(string $cedula): ?object
    {
        return DB::table('pacientes')->where('cedula', $cedula)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarPaciente(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $datos['cedula'],
                $datos['nombres_paciente'],
                $datos['apellidos_paciente'],
                $datos['edad'],
                $datos['genero'],
                $datos['telefono_paciente'],
                $datos['direccion_paciente'],
                $datos['correo_paciente'],
                $datos['tipo_sangre'],
            ]
        );
    }

    public function update(string $cedula, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarPaciente(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $cedula,
                $datos['nombres_paciente'],
                $datos['apellidos_paciente'],
                $datos['edad'],
                $datos['genero'],
                $datos['telefono_paciente'],
                $datos['direccion_paciente'],
                $datos['correo_paciente'],
                $datos['tipo_sangre'],
            ]
        );
    }

    public function delete(string $cedula): bool
    {
        return DB::statement('CALL pa_EliminarPaciente(?)', [$cedula]);
    }
}
