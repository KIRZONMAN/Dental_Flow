<?php
namespace App\Contracts;

interface ProveedorServiceInterface
{
    public function all(): array;
    public function find(string $nit): ?object;
    public function create(array $datos): void;
    public function update(string $nit, array $datos): void;
    public function delete(string $nit): void;
}
