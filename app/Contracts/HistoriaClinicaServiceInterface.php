<?php
namespace App\Contracts;

interface HistoriaClinicaServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;
    public function update(int $id, array $datos): void;
    public function delete(int $id): void;
}
