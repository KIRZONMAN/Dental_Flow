<?php
namespace App\Contracts;

interface PedidoServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    /** Ahora devuelve bool para indicar éxito/fallo */
    public function update(int $id, array $datos): bool;

    /** Ahora devuelve bool para indicar éxito/fallo */
    public function delete(int $id): bool;
}
