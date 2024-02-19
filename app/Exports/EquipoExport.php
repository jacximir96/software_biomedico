<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class EquipoExport implements FromCollection ,WithHeadings,WithColumnFormatting,WithColumnWidths,WithEvents
{
    
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
            return collect(DB::select("SELECT E.nombre_equipo,E.marca_equipo,E.modelo_equipo,E.serie_equipo,E.cp_equipo,TE.nombre_tipoEquipamiento,DEE.iniciales_direccionEjecutiva as iniciales_direccionDepartamento,D.iniciales_departamento,A.nombre_ambiente,E.fecha_adquisicion_equipo,e.monto_adquisicion_equipo,ROUND(TIMESTAMPDIFF(MONTH,fecha_adquisicion_equipo,CURDATE())/12) AS antiguedad_equipo, e.tiempo_vida_util_equipo,E.prioridad_equipo from equipo E INNER JOIN cronograma C ON E.id_equipo = C.id_equipo
            INNER JOIN ambiente A ON E.id_ambiente = A.id_ambiente LEFT JOIN departamento D ON A.id_departamento = D.id_departamento LEFT JOIN direccionejecutiva DE
            ON A.id_direccionEjecutiva = DE.id_direccionEjecutiva LEFT JOIN direccionejecutiva DEE ON D.id_direccionEjecutiva = DEE.id_direccionEjecutiva INNER JOIN
            tipoequipamiento TE ON E.id_tipoEquipamiento = TE.id_tipoEquipamiento WHERE C.updated_at in (SELECT MAX(C.updated_at) FROM equipo E INNER JOIN cronograma C
            ON E.id_equipo = C.id_equipo GROUP BY E.id_equipo)"));
    }
    public function headings(): array
    {
        return [
            'Equipo',
            'Marca',
            'Modelo',
            '# Serie',
            'Cod. Patrimonial',
            'Tipo Equipamiento',
            'Dir. Ejecutiva',
            'Departamento',
            'Ambiente',
            'Fecha(Adquisión)',
            'Monto (Adquisión)',
            'Antigüedad',
            'Vida Util',
            'Prioridad'
            // Agrega más encabezados según tus necesidades
        ];
    }
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY ,
            // 'K' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            
            
            
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 45,
            'B' => 25,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,   
            'G' => 15, 
            'H' => 15,    
            'I' => 25,
            'J' => 15,
            'K' => 15
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . $event->sheet->getHighestColumn() . '1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
