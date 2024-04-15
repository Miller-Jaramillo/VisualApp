<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use App\Models\Registro;
use Livewire\Component;

class GraficoPastelAccidentes extends Component
{
    public $year = '2024'; // Año inicial
    public $labels = [];
    public $counts = [];
    public $conteoMujeres;
    public $conteoHombres;

    protected $listeners = ['yearSelected'];

    public function mount()
    {
        // Obtener todos los registros para el elemento select
        $this->loadData();
        $this->emit('updateChart', [
            'labels' => $this->labels,
            'counts' => $this->counts,
        ]);
    }

    public function render()
    {
        return view('livewire.charts.grafico-pastel-accidentes');
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->updateChart();
    }

    public function updateChart()
    {
        $this->loadData();
        $this->emit('updateChart', [
            'labels' => $this->labels,
            'counts' => $this->counts,
        ]);
    }

    private function loadData()
    {
        // Consultar el conteo general si no se selecciona ningún registro específico
        $this->conteoMujeres = Archivo::where('genero', 'F')
            ->whereYear('fecha', $this->year)
            ->count();

        $this->conteoHombres = Archivo::where('genero', 'M')
            ->whereYear('fecha', $this->year)
            ->count();

        // Actualizar datos para el gráfico
        $this->labels = ['Mujeres', 'Hombres'];
        $this->counts = [$this->conteoMujeres, $this->conteoHombres];
    }
}
