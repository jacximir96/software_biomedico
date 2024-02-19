<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronogramasModel extends Model
{
    protected $table = 'cronograma';

    protected $primaryKey = "id_cronograma";


    public function mantenimiento(){
        return $this->belongsTo('App\TipoMantenimientosModel','id_mantenimiento','id_mantenimiento');
    }

    public function equipo(){
        return $this->belongsTo('App\EquiposModel','id_equipo','id_equipo');
    }

    public function Departamento(){
        return $this->belongsTo('App\DepartamentosModel','id_departamento','id_departamento');
    }

    public function Proveedor(){
        return $this->belongsTo('App\ProveedoresModel','id_proveedor','id_proveedor');
    }

    protected $fillable = [
        'id_cronograma',
        "id_equipo",
        "fecha",
        "fecha_final",
        "id_mantenimiento",
        "id_proveedor",
        "garantia",
        "monto_cronograma",
        "realizado",
        "observacion",
        "id_ordenServicio",
        "acumulado_cronograma",
        "pdf_cronograma",
        "id_departamento",
        "otm_cronograma"
    ];
}
