<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\UsersCredentials;

class RegistrosCardComponent extends Component
{
        // -> Variables
        use WithPagination;


    public function render()
    {


        return view('components.dashboard.dashboard-card-07');

    }




}
