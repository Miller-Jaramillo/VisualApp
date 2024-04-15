<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class BarrasApiladasClaseGenero extends Component
{
    public $year = '2024'; // Año inicial

    protected $listeners = ['yearSelected'];

    public $data;

    public function render()
    {
        $this->loadData();
        return view('livewire.charts.barras-apiladas-clase-genero');
    }

    public function mount()
    {
        $this->loadData();
        $this->emit('updateClaseGenero', ['data' => $this->data]);
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->loadData();
        $this->emit('updateClaseGenero', ['data' => $this->data]);
    }

    private function loadData()
    {
        $this->data = Archivo::select('clase_accidente', 'genero')
            ->selectRaw('COUNT(*) as total')
            ->whereYear('fecha', $this->year)
            ->groupBy('clase_accidente', 'genero')
            ->get();

        $this->emit('updateClaseGenero', ['data' => $this->data]);
    }
}
