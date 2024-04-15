<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Imports\ArchivosImport;
use App\Models\Archivo;
use Livewire\WithFileUploads;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RegistrosTableComponent extends Component
{


    use WithPagination;
    public $search = '';
    public $perPage = '5';
    public $confirmingUserDeletion = false;
    public $message = '';
    public $showForm;
    public $name;

    public function render()
    {

        $query = Registro::query(); // Iniciar la consulta

        if ($this->search) {
            $query->where('nombre_registro', 'LIKE', "%{$this->search}%")->orWhere('descripcion', 'LIKE', "%{$this->search}%");
        }

        $registros = $query->paginate($this->perPage);

        return view('livewire.admin.registros-table-component', compact('registros') );
    }



    // cmt: Abre el formulario para agregar un nuevo admin
    public function openForm()
    {
        $this->showForm = true;
    }


        // cmt: Cierra el formulario para agregar un nuevo admin
        public function closeForm()
        {
            $this->showForm = false;
            $this->reset();
        }



    // cmt: Elimina el usuario
    public function deleteUser($userId)
    {
        $registro = Registro::findOrFail($userId);
        $registro ->delete();



        $this->confirmingUserDeletion = null;
    }

        // cmt: Se cancela la desicion de eliminar el usuario
        public function cancelUserDeletion()
        {
            $this->confirmingUserDeletion = null;
        }

        // cmt: Se confirma la desicion de eliminar el usuario
        public function confirmUserDeletion($userId)
        {
            $this->confirmingUserDeletion = $userId;
            $registro = Registro::find($userId);
            $this->name = $registro->nombre_registro;
        }

        public function clear()
        {
            $this->search = '';
            $this->page = 1;
            $this->perPage = 5;
        }



}
