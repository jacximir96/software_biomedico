<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramasCalendarioModel extends Model
{
    protected $table = 'cronogramacalendario';

    public function Equipo(){
        return $this->belongsTo('App\EquiposGarantiaModel','id_equipoGarantia','id_equipoGarantia');
    }

    protected $fillable = [
        "id_cronogramaCalendario",
        "id_equipoGarantia",
        "fecha",
        "fecha_final",
        "realizado",
        "observacion",
        "pdf_cronograma",
    ];
}
