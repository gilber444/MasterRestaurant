<?php

namespace App\Livewire;

use App\Models\UnidadMedida;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UnidadMedidas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Unidades Medidas';
    }

    public function render()
    {
        return view('livewire.unidad_medidas.unidad_medidas', [
            'unidades' => $this->loadUnidades()
        ]);
    }

    public function loadUnidades()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = UnidadMedida::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = UnidadMedida::orderBy('codigo', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:unidad_medidas,valor,{$this->selected_id}|min:1",
            'valor' => "required|unique:unidad_medidas,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre de unidad de medida es requerido',
            'valor.unique' => 'Ya existe el nombre de unidad de medida',
            'valor.min'=> 'El nombre de unidad de medida debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $medida = UnidadMedida::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Unidad de medida registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $medidas = UnidadMedida::find($id);
        $this->codigo = $medidas->codigo;
        $this->valor = $medidas->valor;
        $this->status = $medidas->status;
        $this->selected_id = $medidas->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $medida = UnidadMedida::find($this->selected_id);
        $medida->codigo = $this->codigo;
        $medida->valor = $this->valor;
        $medida->status = $this->status;
        $medida->save();

        $this->dispatch('noty', msg: 'Unidad de medida Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $id->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'UNIDAD DE MEDIDA ELIMINADA CON ÉXITO');
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