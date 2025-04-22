<?php

namespace App\Providers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\DB;

class CustomUserProvider implements UserProvider
{
    protected $app;

    public function __construct()
    {
        $this->app = app(); // Acceso a la aplicación
    }

    // Autenticación básica (buscar en la tabla usuarios)
    public function retrieveByCredentials(array $credentials)
    {
        // Aquí se asume que los usuarios se identifican por correo_usuario
        if (isset($credentials['correo_usuario'])) {
            return DB::table('usuarios')
                ->where('correo_usuario', $credentials['correo_usuario']) // Cambié "usuario" por "correo_usuario"
                ->first();
        }

        return null;
    }

    public function retrieveById($identifier)
    {
        return DB::table('usuarios')->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        // Implementa si usas 'remember_token'
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Cambié el campo de 'password' por 'contrasena_usuario'
        return password_verify($credentials['contrasena_usuario'], $user->contrasena_usuario);
    }

    public function getAuthIdentifierName()
    {
        return 'id';  // El campo que actúa como identificador
    }

    public function getAuthIdentifier($user)
    {
        return $user->id;
    }

    public function getAuthPassword($user)
    {
        return $user->contrasena_usuario; // Cambié "password" por "contrasena_usuario"
    }

    public function getRememberToken($user)
    {
        return $user->remember_token ?? null;
    }

    public function setRememberToken($user, $value)
    {
        // Implementa si usas 'remember_token'
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
