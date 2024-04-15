<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardCard04 extends Component
{
    public $labels = [];
    public $counts = [];


    public $conteoMujeres;
    public $conteoHombres;

    public function render()
    {
        $data = Archivo::select('clase_accidente', 'genero')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('clase_accidente', 'genero')
        ->get();

        return view('livewire.charts.dashboard-card04', ['data' => $data]);
    }

    public function mount()
    {
        $this->refreshData();

        //     $data = DB::table('archivos')
        //     ->select('genero', 'clase_accidente', DB::raw('count(*) as count'))
        //     ->groupBy('genero', 'clase_accidente')
        //     ->get();

        // // Formatea los datos para el gráfico
        // foreach ($data as $item) {
        //     $this->chartData[] = [
        //         'genero' => $item->genero,
        //         'clase' => $item->clase_accidente,
        //         'cantidad' => $item->count,
        //     ];
        // }
    }


    public function refreshData()
    {
        $this->conteoMujeres = DB::table('archivos')
            ->where('genero', 'F')
            ->count();

        $this->conteoHombres = DB::table('archivos')
            ->where('genero', 'M')
            ->count();

        // Otras operaciones para obtener los datos que deseas mostrar

        // Asigna los resultados a las propiedades de tu componente

        // Realiza otras operaciones para obtener los datos que deseas mostrar en el gráfico

        // Actualiza los datos del gráfico
        $this->labels = json_encode(['Mujeres', 'Hombres']); // Ejemplo de etiquetas
        $this->counts = json_encode([$this->conteoMujeres, $this->conteoHombres]); // Ejemplo de datos de recuento

        // Otros pasos necesarios para actualizar los datos del gráfico
    }
}

