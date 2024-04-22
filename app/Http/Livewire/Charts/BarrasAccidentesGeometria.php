<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesGeometria extends Component
{
    public $year = '2024'; // Año inicial
    public $geometrias;
    public $geometriaConMasAccidentes;
    public $geomtriaConMenosAccidentes;
public $conteoGeometrias;


    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-geometria');
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
        $this->geometrias = Archivo::whereYear('fecha', $this->year)
            ->pluck('geometria')
            ->toArray();

        $this->geometriaConMasAccidentes = $this->obtenerGeometriasConMasAccidentes($this->geometrias);
        $this->geomtriaConMenosAccidentes = $this->obtenerGeometriasConMenosAccidentes($this->geometrias);


        $this-> conteoGeometrias = array_count_values($this->geometrias); // Añade esta línea
        $this->emit('updateBarrasGeometria', ['data' => $this->geometrias]);
    }

    private function obtenerGeometriasConMasAccidentes($geometrias)
    {
        $conteoGeometrias = array_count_values($geometrias);
        arsort($conteoGeometrias);
        $maxAccidentes = reset($conteoGeometrias); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoGeometrias, $maxAccidentes);
    }

    private function obtenerGeometriasConMenosAccidentes($geometrias)
    {
        $conteoGeometrias = array_count_values($geometrias);
        asort($conteoGeometrias);
        $minAccidentes = reset($conteoGeometrias); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoGeometrias, $minAccidentes);
    }


}

