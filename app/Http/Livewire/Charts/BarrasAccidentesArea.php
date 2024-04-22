<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesArea extends Component
{
    public $year = '2024'; // Año inicial
    public $areas;
    public $areaConMasAccidentes;
    public $areaConMenosAccidentes;
public $conteoAreas;


    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-area');
    }

    public function mount()
    {
        $this->loadData();
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->loadData();
    }

    private function loadData()
    {
        $this->areas = Archivo::whereYear('fecha', $this->year)
            ->pluck('area')
            ->toArray();

        $this->areaConMasAccidentes = $this->obtenerAreasConMasAccidentes($this->areas);
        $this->areaConMenosAccidentes = $this->obtenerAreasConMenosAccidentes($this->areas);


        $this-> conteoAreas = array_count_values($this->areas); // Añade esta línea
        $this->emit('updateBarrasArea', ['data' => $this->areas]);
    }

    private function obtenerAreasConMasAccidentes($areas)
    {
        $conteoAreas = array_count_values($areas);
        arsort($conteoAreas);
        $maxAccidentes = reset($conteoAreas); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoAreas, $maxAccidentes);
    }

    private function obtenerAreasConMenosAccidentes($areas)
    {
        $conteoAreas = array_count_values($areas);
        asort($conteoAreas);
        $minAccidentes = reset($conteoAreas); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoAreas, $minAccidentes);
    }


}

