<?php

namespace App\Livewire;

use App\Models\TipoTransmision;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TipoTransmisions extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Tipo de Transmisión';
    }

    public function render()
    {
        return view('livewire.tipo_transmisions.tipo_transmisions', [
            'transmision' => $this->loadTransmision()
        ]);
    }

    public function loadTransmision()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = TipoTransmision::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = TipoTransmision::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:tipo_transmisions,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:tipo_transmisions,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del tipo de transmisión es requerido',
            'valor.unique' => 'Ya existe el tipo de transmisión',
            'valor.min'=> 'El nombre del tipo de transmisión debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $transmision = TipoTransmision::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Tipo de Transmisión registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $transmision = TipoTransmision::find($id);
        $this->codigo = $transmision->codigo;
        $this->valor = $transmision->valor;
        $this->status = $transmision->status;
        $this->selected_id = $transmision->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $transmision = TipoTransmision::find($this->selected_id);
        $transmision->codigo = $this->codigo;
        $transmision->valor = $this->valor;
        $transmision->status = $this->status;
        $transmision->save();

        $this->dispatch('noty', msg: 'Tipo de Transmisión Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $transmision = TipoTransmision::find($id);
        $transmision->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'TIPO TRANSMISION ELIMINADO CON ÉXITO');
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

