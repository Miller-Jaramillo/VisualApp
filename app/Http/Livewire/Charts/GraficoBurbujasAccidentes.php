<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;

use Livewire\Component;

class GraficoBurbujasAccidentes extends Component
{

    public $year = '2024'; // Año inicial

    protected $listeners = ['yearSelected'];

    public $data;


    public $lesionMasAccidentes;
    public $lesionMenosAccidentes;
    public $edadPromedioPorLesion;
    public $lesionMenorEdad;
    public $lesionMayorEdad;

    public function render()
    {
        $this->loadData();
        $this->calculateAnalysis();
        return view('livewire.charts.grafico-burbujas-accidentes');
    }



    public function mount()
    {
        $this->loadData();
        $this->emit('updateGraficoBusrbujas', ['data' => $this->data]);
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->loadData();
        $this->calculateAnalysis();
        $this->emit('updateGraficoBusrbujas', ['data' => $this->data]);
    }

    private function loadData()
    {
        $this->data = Archivo::select('edad', 'lesion')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('fecha', $this->year)
            ->groupBy('edad', 'lesion')
            ->get();

        $this->emit('updateGraficoBusrbujas', ['data' => $this->data]);
    }

    public function calculateAnalysis()
    {
        $lesionesGrouped = $this->data->groupBy('lesion');

        $this->lesionMasAccidentes = $lesionesGrouped->sortByDesc->sum('total')->keys()->first();
        $this->lesionMenosAccidentes = $lesionesGrouped->sortBy->sum('total')->keys()->first();

        $this->edadPromedioPorLesion = $lesionesGrouped->map(function ($items) {
            return $items->sum('total') > 0 ?
                $items->sum(function ($item) {
                    return $item['edad'] * $item['total'];
                }) / $items->sum('total') : 0;
        });

        $this->lesionMenorEdad = $this->edadPromedioPorLesion->sort()->keys()->first();
        $this->lesionMayorEdad = $this->edadPromedioPorLesion->sortDesc()->keys()->first();
    }





}
