<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoLaboratorio extends Model
{
    protected $table = 'productos_laboratorio';
    protected $primaryKey = 'id_producto_lab';
    public $timestamps = true;
    protected $fillable = ['orden_id', 'insumo_id', 'cantidad', 'detalles'];

    public function orden()
    {
        return $this->belongsTo(OrdenLaboratorio::class, 'orden_id', 'id_orden_lab');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id', 'id_insumo');
    }
}
