<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoBarrasApiladas extends Component
{
    public $data ;
    public $year = '2024'; // Año inicial
public $analysis;
    protected $listeners = ['yearSelected'];

    public function render()
    {
        $this->loadData();
        return view('livewire.charts.grafico-barras-apiladas');
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
        $this->data = Archivo::select('tipo_victima', 'clase_accidente', DB::raw('count(*) as total'))
            ->whereYear('fecha', $this->year)
            ->groupBy('tipo_victima', 'clase_accidente')
            ->get();

        $this->emit('updateChartBarrasApiladas', ['data' => $this->data]);
    }

    public function tipoVictimaConMasAccidentes()
    {
        $maxTipoVictima = $this->data->groupBy('tipo_victima')->map->sum('total')->max();
        $tipoVictima = $this->data->groupBy('tipo_victima')->map->sum('total')->search($maxTipoVictima);
        $maxClaseAccidente = $this->data->where('tipo_victima', $tipoVictima)->groupBy('clase_accidente')->map->sum('total')->max();
        $claseAccidente = $this->data->where('tipo_victima', $tipoVictima)->groupBy('clase_accidente')->map->sum('total')->search($maxClaseAccidente);

        return "$tipoVictima: $maxTipoVictima accidentes en $claseAccidente";
    }

    public function tipoVictimaConMenosAccidentes()
    {
        $minTipoVictima = $this->data->groupBy('tipo_victima')->map->sum('total')->min();
        $tipoVictima = $this->data->groupBy('tipo_victima')->map->sum('total')->search($minTipoVictima);
        $minClaseAccidente = $this->data->where('tipo_victima', $tipoVictima)->groupBy('clase_accidente')->map->sum('total')->min();
        $claseAccidente = $this->data->where('tipo_victima', $tipoVictima)->groupBy('clase_accidente')->map->sum('total')->search($minClaseAccidente);

        return "$tipoVictima: $minTipoVictima accidentes en $claseAccidente";
    }

    public function claseAccidenteConMasAccidentes()
    {
        $maxClaseAccidente = $this->data->groupBy('clase_accidente')->map->sum('total')->max();
        $claseAccidente = $this->data->groupBy('clase_accidente')->map->sum('total')->search($maxClaseAccidente);
        $tiposVictimas = $this->data->where('clase_accidente', $claseAccidente)->groupBy('tipo_victima')->keys()->implode(', ');

        return "$claseAccidente con $maxClaseAccidente accidentes que incluye $tiposVictimas.";
    }

    public function claseAccidenteConMenosAccidentes()
    {
        $minClaseAccidente = $this->data->groupBy('clase_accidente')->map->sum('total')->min();
        $claseAccidente = $this->data->groupBy('clase_accidente')->map->sum('total')->search($minClaseAccidente);
        $tiposVictimas = $this->data->where('clase_accidente', $claseAccidente)->groupBy('tipo_victima')->keys()->implode(', ');

        return "$claseAccidente con $minClaseAccidente accidentes que incluye $tiposVictimas.";
    }

    public function valorAportado()
    {
        // Aporta aquí tu valor añadido al análisis
        return "Aquí puedes colocar tu aporte al análisis...";
    }
}
