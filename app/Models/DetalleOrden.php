<?php
// app/Models/DetalleOrden.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'detalles_ordenes';
    protected $primaryKey = 'id_detalle_orden';

    protected $fillable = [
        'cantidad_insumo',
        'total',
        'orden_id',
        'insumo_id',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenCompra::class, 'orden_id', 'id_orden_compra');
    }

    public function insumo()
    {
        return $this->belongsTo(\App\Models\Insumo::class, 'insumo_id', 'id_insumo');
    }
}
