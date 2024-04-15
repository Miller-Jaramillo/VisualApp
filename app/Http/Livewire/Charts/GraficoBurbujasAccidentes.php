<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;

use Livewire\Component;

class GraficoBurbujasAccidentes extends Component
{

    public $year = '2024'; // Año inicial

    protected $listeners = ['yearSelected'];

    public $data;

    public function render()
    {
        $this->loadData();

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



}
