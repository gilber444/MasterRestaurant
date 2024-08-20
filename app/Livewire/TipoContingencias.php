<?php

namespace App\Livewire;

use App\Models\TipoContingencia;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TipoContingencias extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Tipo de Contingencia';
    }

    public function render()
    {
        return view('livewire.tipo_contingencias.tipo_contingencias', [
            'tipo' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = TipoContingencia::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = TipoContingencia::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:tipo_contingencias,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:tipo_contingencias,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del tipo de contingencia es requerido',
            'valor.unique' => 'Ya existe el tipo de contingencia',
            'valor.min'=> 'El nombre del tipo de contingencia debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = TipoContingencia::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Tipo de Contingencia registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $data = TipoContingencia::find($id);
        $this->codigo = $data->codigo;
        $this->valor = $data->valor;
        $this->status = $data->status;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = TipoContingencia::find($this->selected_id);
        $data->codigo = $this->codigo;
        $data->valor = $this->valor;
        $data->status = $this->status;
        $data->save();

        $this->dispatch('noty', msg: 'Tipo de Contingencia Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = TipoContingencia::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'TIPO CONTINGENCIA ELIMINADO CON ÉXITO');
    }

    #[On('ResetInt')]
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

