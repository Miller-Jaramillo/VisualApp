<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesEstadoVia extends Component
{
    public $year = '2024'; // Año inicial
    public $estados;
    public $estadoConMasAccidentes;
    public $estadoConMenosAccidentes;
    public $conteoEstados;

    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-estado-via');
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
        $this->estados = Archivo::whereYear('fecha', $this->year)
            ->pluck('estado_via')
            ->toArray();

        $this->estadoConMasAccidentes = $this->obtenerEstadosConMasAccidentes($this->estados);
        $this->estadoConMenosAccidentes = $this->obtenerEstadosConMenosAccidentes($this->estados);

        $this->conteoEstados = array_count_values($this->estados); // Añade esta línea
        $this->emit('updateBarrasEstadoVia', ['data' => $this->estados]);
    }

    private function obtenerEstadosConMasAccidentes($estados)
    {
        $conteoEstados = array_count_values($estados);
        arsort($conteoEstados);
        $maxAccidentes = reset($conteoEstados); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoEstados, $maxAccidentes);
    }

    private function obtenerEstadosConMenosAccidentes($estados)
    {
        $conteoEstados = array_count_values($estados);
        asort($conteoEstados);
        $minAccidentes = reset($conteoEstados); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoEstados, $minAccidentes);
    }
}
