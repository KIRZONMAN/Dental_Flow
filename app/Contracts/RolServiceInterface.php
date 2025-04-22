<?php
namespace App\Contracts;

interface RolServiceInterface
{
    /** Devuelve todos los roles */
    public function all(): array;

    /** Recupera un rol por su id */
    public function find(int $id): ?object;
}
