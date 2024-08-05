<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ActividadEconomicas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Actividad Económica';
    }

    public function render()
    {
        return view('livewire.actividad_economicas.actividad_economicas', [
            'actividades' => $this->loadActividad()
        ]);
    }

    public function loadActividad()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ActividadEconomica::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = ActividadEconomica::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:actividad_economicas,valor,{$this->selected_id}|min:1",
            'valor' => "required|unique:actividad_economicas,valor,{$this->selected_id}|min:3",
            'status' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'codigo.required' => 'El codigo es requerido',
            'codigo.unique' => 'Ya existe el codigo',
            'codigo.min'=> 'El codigo debe tener mas de 1 caracteres',
            'valor.required' => 'El nombre la actividad económica es requerido',
            'valor.unique' => 'Ya existe la actividad económica',
            'valor.min'=> 'El nombre la actividad económica debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $actividad = ActividadEconomica::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Actividad Económica registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $actividad = ActividadEconomica::find($id);
        $this->codigo = $actividad->codigo;
        $this->valor = $actividad->valor;
        $this->status = $actividad->status;
        $this->selected_id = $actividad->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $actividad = ActividadEconomica::find($this->selected_id);
        $actividad->codigo = $this->codigo;
        $actividad->valor = $this->valor;
        $actividad->status = $this->status;
        $actividad->save();

        $this->dispatch('noty', msg: 'Actividad Económica Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $id->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'ACTIVIDAD ECONOMICA ELIMINADA CON ÉXITO');
    }

    protected $listeners = [
        'store' => 'Store',
        'edit' => 'Edit'
    ];

    public function ResetInt()
    {
        $this->codigo = '';
        $this->valor = '';
        $this->status = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}