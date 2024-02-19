<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramasGeneralNuevoModel extends Model
{
    protected $table = 'cronogramageneralnuevo';

    protected $primaryKey = 'id_cronogramaGeneralNuevo';

    public function equipogarantia() {
       
        return $this->belongsTo('App\EquiposGarantiaModel','id_equipoGarantia','id_equipoGarantia');
    
}
}

