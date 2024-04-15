<?php

namespace App\Imports;

use App\Models\Archivo;
use App\Models\Registro;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ArchivosImport implements ToCollection
{
    protected $registro;

    public function __construct(Registro $registro)
    {
        $this->registro = $registro;
    }
    public function collection(Collection $rows)
    {
        // Comenzar desde la segunda fila para omitir los encabezados
        foreach ($rows->skip(1) as $row) {
            // Verificar si la fila está vacía
            if (
                $row
                    ->filter(function ($value) {
                        return $value !== null && $value !== '';
                    })
                    ->isNotEmpty()
            ) {
                // Obtener el valor de fecha de Excel (asegúrate de que sea la columna correcta)
                $excelDate = $row[0]; // Asumiendo que la fecha está en la primera columna

                // Convertir el valor de fecha de Excel a un número (formato Excel)
                $excelValue = (float) $excelDate;

                // Convertir el número de Excel a una fecha
                $timestamp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelValue);

                // Crear una fecha a partir del timestamp
                $fecha = date('Y-m-d', $timestamp);
                // Obtener la hora de Excel (asegúrate de que sea la columna correcta)
                // Obtener la hora de Excel (asegúrate de que sea la columna correcta)
                $excelHora = $row[14]; // Suponiendo que la hora está en la columna 14

                // Convertir la hora de Excel a un objeto DateTime de PHP
                $horaObjeto = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelHora);

                // Obtener la hora en formato de 24 horas
                $hora = $horaObjeto->format('H:i:s');
                // Crear un nuevo registro_accidente y asignar los valores desde el archivo XLSX
                Archivo::create([
                    'fecha' => $fecha,
                    'direccion' => $row[1] ?? null,
                    'barrio' => $row[2] ?? null,
                    'comuna' => $row[3] ?? null,
                    'codigo_postal' => $row[4] ?? null,
                    'edad' => $row[5] ?? null,
                    'genero' => $row[6] ?? null,
                    'tipo_victima' => $row[7] ?? null,
                    'clase_accidente' => $row[8] ?? null,
                    'caso_accidente' => $row[9] ?? null,
                    'lesion' => $row[10] ?? null,
                    'hipotesis' => $row[11] ?? null,

                    'estado_victima' => $row[12] ?? null,
                    'dia' => $row[13] ?? null,
                    'hora' => $hora ?? null,
                    'area' => $row[15] ?? null,
                    'sector' => $row[16] ?? null,
                    'condicion_climatica' => $row[17] ?? null,
                    'superficie_rodadura' => $row[18] ?? null,
                    'geometria' => $row[19] ?? null,
                    'estado_via' => $row[20] ?? null,
                    'condicion' => $row[21] ?? null,

                    'registro_id' => $this->registro->id, // Asociamos el id del registro
                ]);
            }
        }
    }
}
