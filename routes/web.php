<?php

use App\Http\Controllers\CustomRegisteredUserController;
use App\Http\Controllers\DashboardCard04;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMapaController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Livewire\Admin\RegistrosComponent;
use App\Http\Livewire\Admin\RegistrosTableComponent;
use App\Http\Livewire\AnuncioComponent;
use App\Http\Livewire\InicioComponent;
use App\Http\Livewire\MapasComponent;
use App\Http\Livewire\SelectMapaComponent;
use App\Http\Livewire\UsersTableComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

// Route::get('/inicio', InicioComponent::class)->middleware('verificarArchivo')->name('inicio');



// Ruta para procesar la solicitud de registro de administradores
Route::get('/register', [CustomRegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [CustomRegisteredUserController::class, 'store']);

// Ruta para procesar la solicitud de registro de usuarios
Route::get('/register-user', [RegisterUserController::class, 'create'])->name('register-user');
Route::post('/register-user', [RegisterUserController::class, 'store']);


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verificarArchivo')->name('dashboard');
    Route::fallback(function() {
        return view('pages/utility/404');
    });


    Route::get('/users', UsersTableComponent::class)->name('users');
    Route::get('/subir-registro', RegistrosComponent::class)->middleware('soloAdmin')->name('subir-registro');

    Route::get('/registros', RegistrosTableComponent::class)->middleware('soloAdmin')->name('registros');

    Route::get('/mapas', [DashboardMapaController::class, 'index'])->middleware('verificarArchivo')->name('mapas');
    Route::get('/anuncio', AnuncioComponent::class)->name('anuncio');


    // routes/web.php







});