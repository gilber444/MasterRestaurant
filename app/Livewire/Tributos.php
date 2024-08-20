<?php

namespace App\Livewire;

use App\Models\Tributo;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tributos extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Tributos';
    }

    public function render()
    {
        return view('livewire.tributos.tributos', [
            'tributos' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Tributo::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = Tributo::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:tributos,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:tributos,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del tributo es requerido',
            'valor.unique' => 'Ya existe el tributo',
            'valor.min'=> 'El nombre del tributo debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Tributo::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Tributo registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $tributo = Tributo::find($id);
        $this->codigo = $tributo->codigo;
        $this->valor = $tributo->valor;
        $this->status = $tributo->status;
        $this->selected_id = $tributo->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Tributo::find($this->selected_id);
        $data->codigo = $this->codigo;
        $data->valor = $this->valor;
        $data->status = $this->status;
        $data->save();

        $this->dispatch('noty', msg: 'Tributo Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = Tributo::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'TRIBUTO ELIMINADO CON ÉXITO');
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


