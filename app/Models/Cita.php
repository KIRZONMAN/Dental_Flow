<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';       // coincide con tu SQL
    public    $timestamps = false;           // si no tienes created_at / updated_at

    protected $fillable = [
        'fecha_cita',
        'hora_cita',
        'motivo_cita',
        'estado_cita',
        'paciente_id',
        'usuario_id',
    ];

    // Relación al paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'cedula');
    }

    // Relación al odontólogo
    public function odontologo()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }
}
