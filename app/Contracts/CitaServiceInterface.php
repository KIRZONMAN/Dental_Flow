<?php
namespace App\Contracts;

interface CitaServiceInterface
{
    /** Devuelve todas las citas del día */
    public function allHoy(string $fecha): array;

    /** Recupera una cita por su id */
    public function find(int $id): ?object;

    /** Inserta una nueva cita */
    public function create(array $datos): void;

    /** Actualiza una cita existente */
    public function update(int $id, array $datos): void;

    /** Elimina una cita */
    public function delete(int $id): void;
}
