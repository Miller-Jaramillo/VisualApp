<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class GraficoBarrasAccidestesPorDia extends Component
{
    public $year = '2024'; // Año inicial

    protected $listeners = ['yearSelected'];

    public $data;
    public $dias;
    public $totalAccidentesPorDia;
    public $diaMasAccidentado;
    public $totalMasAccidentes;
    public $diaMenosAccidentado;
    public $totalMenosAccidentes;
    public $generoMasAccidentado;
    public $totalAccidentesGeneroMasAccidentado;
    public $generoMenosAccidentado;
    public $totalAccidentesGeneroMenosAccidentado;

    public function render()
    {
        $this->loadData();
        $this->obtenerInformacion();

        return view('livewire.charts.grafico-barras-accidestes-por-dia');
    }

    public function mount()
    {
        $this->loadData();
        $this->obtenerInformacion();
        $this->emit('updateBarrasAccidentesDia', ['data' => $this->data]);
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->loadData();
        $this->obtenerInformacion();
        $this->emit('updateBarrasAccidentesDia', ['data' => $this->data]);
    }

    private function loadData()
    {
        $this->data = Archivo::select('dia', 'genero')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('fecha', $this->year)
            ->groupBy('dia', 'genero')
            ->get();

        $this->emit('updateBarrasAccidentesDia', ['data' => $this->data]);
    }

    private function obtenerInformacion()
    {





        $this->dias = $this->data->pluck('dia')->unique()->toArray();

        $this->totalAccidentesPorDia = $this->data->groupBy('dia')->map->sum('total');

        // Obtener el día con más accidentes
        $maxAccidents = $this->totalAccidentesPorDia->max();
        $this->diaMasAccidentado = $this->totalAccidentesPorDia->filter(function ($value) use ($maxAccidents) {
            return $value === $maxAccidents;
        })->keys()->toArray();

        // Obtener el día con menos accidentes
        $minAccidents = $this->totalAccidentesPorDia->min();
        $this->diaMenosAccidentado = $this->totalAccidentesPorDia->filter(function ($value) use ($minAccidents) {
            return $value === $minAccidents;
        })->keys()->toArray();








        $this->generoMasAccidentado = $this->data->groupBy('genero')->map->sum('total')->sortDesc()->keys()->first();
        $this->totalAccidentesGeneroMasAccidentado = $this->data->groupBy('genero')->map->sum('total')->sortDesc()->first();

        $this->generoMenosAccidentado = $this->data->groupBy('genero')->map->sum('total')->sort()->keys()->first();
        $this->totalAccidentesGeneroMenosAccidentado = $this->data->groupBy('genero')->map->sum('total')->sort()->first();
    }
}
