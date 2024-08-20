<?php

namespace App\Livewire;

use App\Models\AmbienteDestino;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AmbienteDestinos extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ambiente Destino';
    }

    public function render()
    {
        return view('livewire.ambiente_destinos.ambiente_destinos', [
            'ambientes' => $this->loadAmbientes()
        ]);
    }

    public function loadAmbientes()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = AmbienteDestino::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = AmbienteDestino::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:ambiente_destinos,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:ambiente_destinos,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del ambiente de destino es requerido',
            'valor.unique' => 'Ya existe el ambiente de destino',
            'valor.min'=> 'El nombre del ambiente de destino debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $ambiente = AmbienteDestino::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Ambiente Destino registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $ambiente = AmbienteDestino::find($id);
        $this->codigo = $ambiente->codigo;
        $this->valor = $ambiente->valor;
        $this->status = $ambiente->status;
        $this->selected_id = $ambiente->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $ambiente = AmbienteDestino::find($this->selected_id);
        $ambiente->codigo = $this->codigo;
        $ambiente->valor = $this->valor;
        $ambiente->status = $this->status;
        $ambiente->save();

        $this->dispatch('noty', msg: 'Ambiente Destino Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $ambiente = AmbienteDestino::find($id);
        $ambiente->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'AMBIENTE DESTINO ELIMINADO CON ÉXITO');
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
