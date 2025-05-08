<?php
namespace App\Contracts;

interface PacienteServiceInterface
{
    public function all(): array;
    public function find(string $cedula): ?object;
    public function create(array $datos): void;
    public function update(string $cedula, array $datos): void;
    public function delete(string $cedula): void;
}
