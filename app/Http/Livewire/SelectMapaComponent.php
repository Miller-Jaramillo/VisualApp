<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectMapaComponent extends Component
{

    public $selectedMapaYear = '2024'; // Año inicial

    public function render()
    {
        return view('livewire.select-mapa-component');
    }

        // Actualiza los datos cuando cambie el año seleccionado
        public function updatedselectedMapaYear()
        {
            $this->emit('yearSelectedMap', $this->selectedMapaYear);
        }
}
