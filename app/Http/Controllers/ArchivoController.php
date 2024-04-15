<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{


    public function getChartData(Request $request)
    {
        // Obtener los datos desde la base de datos
        $data = Archivo::select('clase_accidente', 'genero')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('clase_accidente', 'genero')
            ->get();

        // Retornar los datos en formato JSON
        return response()->json(['data' => $data]);
    }
}
