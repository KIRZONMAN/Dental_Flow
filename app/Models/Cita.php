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
        'total_cita' => 'decimal:2',
    ];

    public function getFechaHoraAttribute()
{
    $hora = $this->hora_cita
        ? substr($this->hora_cita, 0, 5)
        : '--:--';
    return $this->fecha_cita->format('d/m/Y') . ' ' . $hora;
}

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'cedula');
    }

    public function odontologo()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }
}
