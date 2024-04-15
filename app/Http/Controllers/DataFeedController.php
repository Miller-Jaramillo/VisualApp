<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\DataFeed;
use Illuminate\Http\Request;

class DataFeedController extends ApiController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataFeed(Request $request)
    {
        $df = new DataFeed();

        return (object) [
            'labels' => $df->getDataFeed($request->datatype, 'label', $request->limit),
            'data' => $df->getDataFeed($request->datatype, 'data', $request->limit),
        ];
    }

    public function dashboardCard04()
    {

        // Realiza las consultas o lógica necesaria para obtener los datos
        $data = Archivo::select('clase_accidente', 'genero')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('clase_accidente', 'genero')
            ->get();

        // Retorna los datos en formato JSON
        return response()->json(['data' => $data]);
    }
}
