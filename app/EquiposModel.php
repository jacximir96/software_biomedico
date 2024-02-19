<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquiposModel extends Model
{
    protected $table = 'equipo';

    protected $primaryKey= 'id_equipo';

    public function cronogramas() {
        return $this->hasMany('App\CronogramasModel','id_equipo');
    }
}

