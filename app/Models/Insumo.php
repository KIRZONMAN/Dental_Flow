<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';
    protected $primaryKey = 'id_insumo';

    protected $fillable = [
        'nombre_insumo','cantidad_insumo','costo_insumo',
        'fecha_vencimiento','umbral_alerta',
    ];


    public function proveedores()
    {
        // pivote  proveedores_insumos( proveedor_id , insumo_id )
        return $this->belongsToMany(
            \App\Models\Proveedor::class,
            'proveedores_insumos',
            'insumo_id',
            'proveedor_id',
            'id_insumo',
            'nit'
        );
    }

    /* “Macro” que suma stock en bloque */
    public function aumentarStock(int $cantidad): void
    {
        $this->increment('cantidad_insumo', $cantidad);
    }
}
