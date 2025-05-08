<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomUserProvider implements UserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        return User::where('correo_usuario', $credentials['correo_usuario'])
            ->first();
    }


    public function retrieveById($identifier)
    {
        return DB::table('usuarios')
            ->where('id_usuario', $identifier)
            ->first();
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        DB::table('usuarios')
            ->where('id_usuario', $user->id_usuario)
            ->update(['remember_token' => $token]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {

        return Hash::check($credentials['password'],
        $user->contrasena_usuario);
    }



    public function getAuthIdentifierName()
    {
        /* desde aquí corregí: tu PK en usuarios es id_usuario */
        return 'id_usuario';
        /* hasta aquí corregí */
    }

    public function getAuthIdentifier($user)
    {
        return $user->id_usuario;
    }

    public function getAuthPassword($user)
    {
        return $user->contrasena_usuario;
    }

    public function getRememberToken($user)
    {
        return $user->remember_token ?? null;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function setRememberToken($user, $value)
    {
        // ya está cubierto por updateRememberToken
    }
}
