<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenLaboratorio extends Model
{
    protected $table = 'ordenes_laboratorio';
    protected $primaryKey = 'id_orden_lab';
    public $timestamps = true;
    protected $fillable = [
        'cita_id',
        'usuario_id',
        'fecha_solicitud',
        'fecha_limite',
        'horario',
        'tipo_material',
        'otros_detalles',
        'estado',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_limite' => 'date',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id', 'id_cita');
    }

    public function odontologo()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }

    public function productos()
    {
        return $this->hasMany(ProductoLaboratorio::class, 'orden_id', 'id_orden_lab');
    }
}
