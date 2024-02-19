<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DireccionesEjecutivasModel extends Model
{
    protected $table = 'direccionejecutiva';
    
    protected $primaryKey = "id_direccionEjecutiva";

    protected $fillable = [
        'nombre_direccionEjecutiva','iniciales_direccionEjecutiva','estado_direccionEjecutiva'
    ];
}
