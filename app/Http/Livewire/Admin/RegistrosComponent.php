<?php

namespace App\Http\Livewire\Admin;


use App\Imports\ArchivosImport;
use Livewire\Component;
use App\Models\Archivo;
use Livewire\WithFileUploads;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // Importa la clase Excel

class RegistrosComponent extends Component
{
    use WithFileUploads;

    public $nombre;
    public $descripcion;
    public $tipo;
    public $fecha_desde;
    public $fecha_hasta;
    public $archivo;
    public $mostrarVistaPrevia = false;
    public $numeroMujeres = 0;
    public $numeroHombres = 0;
    public $registroId;
    public $conteoMujeres = 0;
    public $conteoHombres = 0;

    public function contarMujeresAccidentadas()
    {
        // Realiza una consulta para contar la cantidad de mujeres accidentadas para un registro específico
        $this->conteoMujeres = Archivo::where('registro_id', $this->registroId)
            ->where('genero', 'F') // Asumiendo que 'F' representa el género femenino
            ->count();

        // Realiza una consulta para contar la cantidad de mujeres accidentadas para un registro específico
        $this->conteoHombres = Archivo::where('registro_id', $this->registroId)
            ->where('genero', 'M') // Asumiendo que 'F' representa el género femenino
            ->count();
    }



    public function render()
    {
        $registros = Registro::all();

        $this->numeroMujeres = DB::table('archivos')
            ->where('genero', 'F')
            ->count();

        $this->numeroHombres = DB::table('archivos')
            ->where('genero', 'M')
            ->count();

            if ($registros->isEmpty()) {
                session()->flash('message', 'Carga el primer registro, luego podras acceder al inicio y a la seccion del mapa.');
            }

        return view('livewire.admin.registros-component', compact('registros'));
    }

    public function cargarBase()
    {
        // Valida los datos
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'tipo' => 'nullable',
            'fecha_desde' => 'nullable',
            'fecha_hasta' => 'nullable',
            'archivo' => 'required|mimes:xlsx|max:2048',
        ]);

        // Sube el archivo
        $archivoPath = $this->archivo->store('bases', 'public');
        // Obtén el nombre del usuario autenticado
        $nombreUsuario = Auth::user()->name;

        // Crea un nuevo registro
        $registro = Registro::create([
            'nombre_registro' => $this->nombre,
            'descripcion' => $this->descripcion,
            //'tipo' => $this->tipo,
            'fecha_inicial' => $this->fecha_desde,
            'fecha_final' => $this->fecha_hasta,
            'archivo_xlsx' => $archivoPath,
            'user_id' => Auth::id(),
            'nombre_usuario' => $nombreUsuario, // Asociamos el id del usuario con el registro
        ]);

        // Procesar el archivo XLSX y crear reportes de accidentes
        Excel::import(new ArchivosImport($registro), storage_path('app/public/' . $archivoPath));

        //$this->mostrarVistaPrevia = true;

        // Limpia los campos del formulario
        $this->nombre = '';
        $this->descripcion = '';
        //$this->tipo = '';
        $this->fecha_desde = '';
        $this->fecha_hasta = '';
        $this->archivo = '';

        session()->flash('mensaje', 'Base de datos cargada con éxito.');
    }


}
