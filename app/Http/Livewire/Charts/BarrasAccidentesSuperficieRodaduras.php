<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesSuperficieRodaduras extends Component
{
    public $year = '2024'; // Año inicial
    public $superficies;
    public $superficieConMasAccidentes;
    public $superficieConMenosAccidentes;
    public $conteoSuperficies;

    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-superficie-rodaduras');
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
        $this->superficies = Archivo::whereYear('fecha', $this->year)
            ->pluck('superficie_rodadura')
            ->toArray();

        $this->superficieConMasAccidentes = $this->obtenerSuperficiesConMasAccidentes($this->superficies);
        $this->superficieConMenosAccidentes = $this->obtenerSuperficesConMenosAccidentes($this->superficies);

        $this->conteoSuperficies = array_count_values($this->superficies); // Añade esta línea
        $this->emit('updateBarrasSuperficieRodadura', ['data' => $this->superficies]);
    }

    private function obtenerSuperficiesConMasAccidentes($superficies)
    {
        $conteoSuperficies = array_count_values($superficies);
        arsort($conteoSuperficies);
        $maxAccidentes = reset($conteoSuperficies); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoSuperficies, $maxAccidentes);
    }

    private function obtenerSuperficesConMenosAccidentes($superficies)
    {
        $conteoSuperficies = array_count_values($superficies);
        asort($conteoSuperficies);
        $minAccidentes = reset($conteoSuperficies); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoSuperficies, $minAccidentes);
    }
}
