<?php


namespace App\Http\Livewire;


use GuzzleHttp\Client;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;



class MapasComponent extends Component
{
    public $year = '2024'; // Año inicial

    protected $listeners = ['yearSelected'];

    public $data;

    public $coordenadas;

    public function render()
    {
        $this->loadData();
        return view('livewire.mapas-component');
    }

    public function mount()
    {
        $this->loadData();
        $this->emit('updateMapa', ['coordenadas' => $this->coordenadas]);

    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->loadData();
        $this->emit('updateMapa', ['coordenadas' => $this->coordenadas]);


    }

    private function loadData()
    {


        $this->coordenadas = Archivo::select('direccion', DB::raw('COUNT(*) as total_accidentes'))
        ->whereYear('fecha', $this->year)
        ->groupBy('direccion')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(5) // Obtener las 5 direcciones más frecuentes
        ->get()
        ->map(function ($archivo) {
            return $this->geocodificarDireccion($archivo->direccion, $archivo->total_accidentes);
        })
        ->filter();

        $this->emit('updateMapa', ['coordenadas' => $this->coordenadas]);



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



}
