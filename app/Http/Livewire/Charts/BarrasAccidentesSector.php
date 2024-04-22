<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasAccidentesSector extends Component
{
    public $year = '2024'; // Año inicial
    public $sectors;
    public $sectorConMasAccidentes;
    public $sectorConMenosAccidentes;
    public $conteoSectors;

    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();

        return view('livewire.charts.barras-accidentes-sector');
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
        $this->sectors = Archivo::whereYear('fecha', $this->year)
            ->pluck('sector')
            ->toArray();

        $this->sectorConMasAccidentes = $this->obtenerSectorsConMasAccidentes($this->sectors);
        $this->sectorConMenosAccidentes = $this->obtenerSectorsConMenosAccidentes($this->sectors);

        $this->conteoSectors = array_count_values($this->sectors); // Añade esta línea
        $this->emit('updateBarrasSector', ['data' => $this->sectors]);
    }

    private function obtenerSectorsConMasAccidentes($sectors)
    {
        $conteoSectors = array_count_values($sectors);
        arsort($conteoSectors);
        $maxAccidentes = reset($conteoSectors); // Obtiene la cantidad máxima de accidentes
        return array_keys($conteoSectors, $maxAccidentes);
    }

    private function obtenerSectorsConMenosAccidentes($sectors)
    {
        $conteoSectors = array_count_values($sectors);
        asort($conteoSectors);
        $minAccidentes = reset($conteoSectors); // Obtiene la cantidad mínima de accidentes
        return array_keys($conteoSectors, $minAccidentes);
    }
}
