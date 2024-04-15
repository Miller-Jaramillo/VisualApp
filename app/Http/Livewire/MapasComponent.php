<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Archivo;
use Illuminate\Support\Facades\DB;

class MapasComponent extends Component
{
    public $page = 1; // Página inicial
    public $perPage = 10; // Cantidad de marcadores por página


    public function render()
    {

        $coordenadas = Archivo::select('direccion', DB::raw('COUNT(*) as total_accidentes'))
    ->groupBy('direccion')
    ->orderByRaw('COUNT(*) DESC')
    ->limit(5) // Obtener las 5 direcciones más frecuentes
    ->get()
    ->map(function ($archivo) {
        return $this->geocodificarDireccion($archivo->direccion, $archivo->total_accidentes);
    })
    ->filter();


    return view('livewire.mapas-component', compact('coordenadas'));
    }

    private function geocodificarDireccion($direccion, $totalAccidentes)
    {
        $client = new Client();
        $api_key = 'AIzaSyBvrQwMO1wOGDGLIqMhE3_UYsWtRsQba34';
        $endpoint = 'https://maps.googleapis.com/maps/api/geocode/json';

        $response = $client->get($endpoint, [
            'query' => [
                'address' => $direccion,
                'key' => $api_key,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['results'][0]['geometry']['location'])) {
            $location = $data['results'][0]['geometry']['location'];

            // Consultar el barrio desde la base de datos
            $barrio = Archivo::where('direccion', $direccion)->value('barrio');

            return [
                'direccion' => $direccion,
                'barrio' => $barrio, // Agregar el barrio al array
                'latitud' => $location['lat'],
                'longitud' => $location['lng'],
                'totalAccidentes' => $totalAccidentes,
            ];
        }

        return null;
    }

    public function loadMore()
    {
        $this->page++;
    }
}
