<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesCondicionClimatica extends Component
{
    public $year = '2024'; // Año inicial
    public $condicions;
    public $condicionConMasAccidentes;
    public $condicionConMenosAccidentes;
    public $conteoCondicions;
    public $data;

    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-condicion-climatica');
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
        $this->condicions = Archivo::whereYear('fecha', $this->year)
            ->pluck('condicion_climatica')
            ->toArray();

        $this->condicionConMasAccidentes = $this->obtenerCondicionsConMasAccidentes($this->condicions);
        $this->condicionConMenosAccidentes = $this->obtenerCondicionsConMenosAccidentes($this->condicions);

        $this->conteoCondicions = array_count_values($this->condicions); // Añade esta línea
        $this->emit('updateBarrasCondicion', ['data' => $this->condicions]);
    }

    private function obtenerCondicionsConMasAccidentes($condicions)
    {
        $conteoCondicions = array_count_values($condicions);
        arsort($conteoCondicions);
        $maxAccidentes = reset($conteoCondicions); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoCondicions, $maxAccidentes);
    }

    private function obtenerCondicionsConMenosAccidentes($condicions)
    {
        $conteoCondicions = array_count_values($condicions);
        asort($conteoCondicions);
        $minAccidentes = reset($conteoCondicions); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoCondicions, $minAccidentes);
    }
}
