<?php
// app/Models/OrdenCompra.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'ordenes_compras';
    protected $primaryKey = 'id_orden_compra';

    protected $fillable = [
        'fecha_expedicion',
        'fecha_vencimiento',
        'usuario_id',
        'estado',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleOrden::class, 'orden_id', 'id_orden_compra');
    }
}
