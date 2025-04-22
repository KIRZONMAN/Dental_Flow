<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface PacienteServiceInterface
{
    public function all(): array;
    public function find(string $cedula): ?object;
    public function create(array $datos): void;

    public function update(string $cedula, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarPaciente(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $cedula,
                $datos['nombres_paciente']        ?? null,
                $datos['apellidos_paciente']      ?? null,
                $datos['edad']                    ?? null,
                $datos['genero']                  ?? null,
                $datos['telefono_paciente']       ?? null,
                $datos['direccion_paciente']      ?? null,
                $datos['correo_paciente']         ?? null,
                $datos['tipo_sangre']             ?? null,
            ]
        );
    }

    public function delete(string $cedula): bool
    {
        return DB::statement('CALL pa_EliminarPaciente(?)', [$cedula]);
    }
}
