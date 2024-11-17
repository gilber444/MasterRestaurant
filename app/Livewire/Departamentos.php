<?php

namespace App\Livewire;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Sucursales;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Departamentos extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $departamento, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Departamentos';
    }

    public function render()
    {
        return view('livewire.departamentos.departamentos', [
            'departamentos' => $this->loadDepartamentos()
        ]);
    }

    public function loadDepartamentos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Departamento::where('departamento', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = Departamento::orderBy('codigo', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:departamentos,codigo,{$this->selected_id}|min:1",
            'departamento' => "required|unique:departamentos,departamento,{$this->selected_id}|min:3",
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
            'departamento.required' => 'El nombre del departamento es requerido',
            'departamento.unique' => 'Ya existe el nombre del departamento',
            'departamento.min'=> 'El nombre del departamento debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $depto = Departamento::create([
            'codigo' => $this->codigo,
            'departamento' => $this->departamento,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Departamento registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $depto = Departamento::find($id);
        $this->codigo = $depto->codigo;
        $this->departamento = $depto->departamento;
        $this->status = $depto->status;
        $this->selected_id = $depto->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $depto = Departamento::find($this->selected_id);
        $depto->codigo = $this->codigo;
        $depto->departamento = $this->departamento;
        $depto->status = $this->status;
        $depto->save();

        $this->dispatch('noty', msg: 'Departamento Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $departamento = Departamento::find($id);

        $empresa = Empresas::where('departamento', $departamento->id);
        $municipio = Municipio::where('departamento', $departamento->id);
        $sucursal = Sucursales::where('departamento', $departamento->id);
        if ($empresa || $municipio || $sucursal) {
            $this->dispatch('noty', msg: 'NO SE PUEDE ELIMINAR: EL DEPARTAMENTO ESTÁ ASOCIADO A UNA EMPRESA, MUNICIPIO Y SUCURSALES');
            return;
        }

        $departamento->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'DEPARTAMENTO ELIMINADO CON ÉXITO');
    }

    protected $listeners = [
        'store' => 'Store',
        'edit' => 'Edit'
    ];

    public function ResetInt()
    {
        $this->codigo = '';
        $this->departamento = '';
        $this->status = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
