<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use App\Models\User;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; // ahora la migración crea timestamps

    protected $fillable = [
        'fecha_cita',
        'hora_cita',
        'estado_cita',
        'motivo_cita',
        'total_cita',
        'paciente_id',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_cita' => 'date',
        'hora_cita' => 'datetime:H:i',  // así te devuelve la hora con Carbon
        'total_cita' => 'decimal:2',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'cedula');
    }

    public function odontologo()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }
}
