<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectComponent extends Component
{

    public $selectedYear = '2024'; // Año inicial




    public function render()
    {
        return view('livewire.select-component');
    }

    // Actualiza los datos cuando cambie el año seleccionado
    public function updatedSelectedYear()
    {
        $this->emit('yearSelected', $this->selectedYear);
    }
}
