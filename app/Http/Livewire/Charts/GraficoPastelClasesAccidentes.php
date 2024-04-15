<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoPastelClasesAccidentes extends Component
{
    public $year = '2024'; // Año inicial
    public $labels = [];
    public $counts = [];

    protected $listeners = ['yearSelected'];

    public function mount()
    {
        $this->loadData();
        $this->emit('updateChartDona', [
            'labels' => $this->labels,
            'counts' => $this->counts,
        ]);
    }

    public function render()
    {
        return view('livewire.charts.grafico-pastel-clases-accidentes');
    }

    public function yearSelected($selectedYear)
    {
        $this->year = $selectedYear;
        $this->updateChartDona();
    }

    public function updateChartDona()
    {
        $this->loadData();
        $this->emit('updateChartDona', [
            'labels' => $this->labels,
            'counts' => $this->counts,
        ]);
    }

    private function loadData()
    {
        $data = Archivo::groupBy('clase_accidente')
            ->select('clase_accidente', DB::raw('count(*) as total'))
            ->whereYear('fecha', $this->year)
            ->get();

        $this->labels = $data->pluck('clase_accidente')->toArray();
        $this->counts = $data->pluck('total')->toArray();
    }
}
