<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramasGeneralModel extends Model
{
    protected $table = 'cronogramageneral';

    protected $primaryKey = 'id_cronogramaGeneral';

    public function equipo(){
        return $this->belongsTo('App\EquiposModel','id_equipo','id_equipo');
    }

}
