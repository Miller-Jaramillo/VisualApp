<?php

namespace App\Http\Controllers;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class CustomRegisteredUserController extends RegisteredUserController
{


    public function create(Request $request): RegisterViewResponse
    {
        return app(RegisterViewResponse::class);
    }
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
       // Ejecuta el método original del controlador.

        // Aquí puedes agregar tu lógica personalizada, por ejemplo, asignar el rol "admin" al usuario.
        event(new Registered($user = $creator->create($request->all())));
        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->role_name = 'Administrador';
        $user->role_id = $role->id;
        $user->assignRole($role);
        $user->save();
        $this->guard->login($user);
        return app(RegisterResponse::class);
    }
}
