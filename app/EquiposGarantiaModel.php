<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquiposGarantiaModel extends Model
{
    protected $table = 'equipogarantia';

    protected $primaryKey = 'id_equipoGarantia';

    public function ambiente() {
        return $this->belongsTo('App\AmbientesModel','id_ambiente');
    }
    public function cronogramas() {
        return $this->hasMany('App\CronogramasCalendarioModel','id_equipoGarantia');
    }
}
