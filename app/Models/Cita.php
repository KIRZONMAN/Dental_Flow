<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha',
        'hora',
        /* 'paciente_id',
        'odontologo_id',
        'estado_cita_id', */
    ];
}
