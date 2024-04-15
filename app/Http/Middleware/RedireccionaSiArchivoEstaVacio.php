<?php

namespace App\Http\Middleware;

use App\Models\Archivo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class RedireccionaSiArchivoEstaVacio
{
    use HasRoles;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Archivo::count() == 0) {
            // Redirigir al usuario admin a subir-registro
            if (Auth::user()->hasRole('admin')) {
                return redirect('/subir-registro');
            }
            // Redirigir al usuario user a maps
            if (Auth::user()->hasRole('user')) {
                return redirect('/anuncio');
            }
        }

        return $next($request);
    }
}
