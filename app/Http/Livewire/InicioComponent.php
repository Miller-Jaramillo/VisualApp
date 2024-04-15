<?php

namespace App\Http\Livewire;

use App\Models\DataFeed;
use Livewire\Component;

class InicioComponent extends Component
{
    public function render()
    {
        $dataFeed = new DataFeed();
        return view('livewire.inicio-component', compact('dataFeed'))->layout('layouts.base');
    }
}
