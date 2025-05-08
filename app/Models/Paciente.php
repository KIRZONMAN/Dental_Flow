<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'cedula';
    public $incrementing = false;          // porque 'cedula' no es AUTO_INCREMENT
    protected $keyType = 'string';         // si tu PK es VARCHAR
    public $timestamps = false;            // según tu script SQL
    // añade aquí $fillable si quieres…
}
