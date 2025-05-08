<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombres_usuario',
        'apellidos_usuario',
        'correo_usuario',
        'telefono_usuario',
        'direccion_usuario',
        'estado_usuario',
        'especialidad_usuario',
        'rol_id',
    ];

    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $hidden = [
        'contrasena_usuario',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contrasena_usuario' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena_usuario;
    }

    public function getAuthIdentifierName()
    {
        return 'correo_usuario';
    }

}
