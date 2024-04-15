<?php

namespace App\Http\Livewire;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnuncioComponent extends Component
{

    public function logout()
    {
        Auth::guard('web')->logout(); // Aquí se usa el guardia 'web'
        return redirect('/');
    }


    public function render()
    {
        return view('livewire.anuncio-component')->layout('layouts.base');
    }
}
