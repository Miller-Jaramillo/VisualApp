<?php

namespace App\Http\Livewire\Charts;

use App\Models\Archivo;
use Livewire\Component;

class DiagramaDispersión extends Component
{
    public $data = [];
    public $trends = [];

    public function render()
    {
        // Realizar la consulta para obtener datos de edades y lesiones
        $this->data = Archivo::select('edad', 'lesion')->get();

        // Calcular tendencias basadas en los datos reales
        $this->trends = $this->calculateTrends();

        return view('livewire.charts.diagrama-dispersión', [
            'data' => $this->data,
            'trends' => $this->trends,
        ]);
    }

    protected function calculateTrends()
    {
        $trends = [];

        // Obtener tipos únicos de lesiones
        $uniqueLesions = $this->data->pluck('lesion')->unique();

        foreach ($uniqueLesions as $lesion) {
            // Obtener las edades asociadas a esa lesión
            $agesForLesion = $this->data->where('lesion', $lesion)->pluck('edad')->toArray();

            // Filtrar edades únicas
            $uniqueAges = array_unique($agesForLesion);

            // Realizar análisis adicional según sea necesario

            $trends[] = [
                'lesion' => $lesion,
                'edades' => $uniqueAges,
            ];
        }

        return $trends;
    }
}
