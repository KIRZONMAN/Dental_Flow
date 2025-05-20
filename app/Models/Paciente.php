<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'cedula';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // 1) Añade esto para que Eloquent incluya el atributo en toArray()/toJson()
    protected $appends = ['nombre_completo_paciente'];

    // 2) El accesor que concatena nombres y apellidos
    public function getNombreCompletoPacienteAttribute()
    {
        return trim("{$this->nombres_paciente} {$this->apellidos_paciente}");
    }
}
