<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class HistogramaAccidentes extends Component
{
    public $year = '2024'; // Año inicial
    public $edades;
    public $edadConMasAccidentes;
    public $edadConMenosAccidentes;
public $conteoEdades;
    public $edadPromedio;
    public $edadMediana;

    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.histograma-accidentes');
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
        $this->edades = Archivo::whereYear('fecha', $this->year)
            ->pluck('edad')
            ->toArray();

        $this->edadConMasAccidentes = $this->obtenerEdadesConMasAccidentes($this->edades);
        $this->edadConMenosAccidentes = $this->obtenerEdadesConMenosAccidentes($this->edades);

        $this->edadPromedio = $this->calcularEdadPromedio($this->edades);
        $this->edadMediana = $this->calcularEdadMediana($this->edades);

        $this-> conteoEdades = array_count_values($this->edades); // Añade esta línea
        $this->emit('updateChartHistograma', ['data' => $this->edades]);
    }

    private function obtenerEdadesConMasAccidentes($edades)
    {
        $conteoEdades = array_count_values($edades);
        arsort($conteoEdades);
        $maxAccidentes = reset($conteoEdades); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoEdades, $maxAccidentes);
    }

    private function obtenerEdadesConMenosAccidentes($edades)
    {
        $conteoEdades = array_count_values($edades);
        asort($conteoEdades);
        $minAccidentes = reset($conteoEdades); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoEdades, $minAccidentes);
    }

    private function calcularEdadPromedio($edades)
    {
        $totalEdades = count($edades);
        if ($totalEdades === 0) {
            return 0;
        }

        $sumaEdades = array_sum($edades);
        return round($sumaEdades / $totalEdades);
    }


    private function calcularEdadMediana($edades)
    {
        sort($edades);
        $totalEdades = count($edades);
        $mitad = floor($totalEdades / 2);

        if ($totalEdades % 2 == 0) {
            // Si hay un número par de edades, se promedian las dos del medio
            return ($edades[$mitad - 1] + $edades[$mitad]) / 2;
        } else {
            // Si hay un número impar de edades, se toma la del medio
            return $edades[$mitad];
        }
    }
}
