<?php

namespace App\Livewire;

use App\Models\ModeloFacturacion;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ModeloFacturacions extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Modelo Facturación';
    }

    public function render()
    {
        return view('livewire.modelo_facturacions.modelo_facturacions', [
            'facturacion' => $this->loadFacturacion()
        ]);
    }

    public function loadFacturacion()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ModeloFacturacion::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = ModeloFacturacion::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:modelo_facturacions,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:modelo_facturacions,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del modelo de facturación es requerido',
            'valor.unique' => 'Ya existe el modelo de facturación',
            'valor.min'=> 'El nombre del modelo de facturación debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $modelo = ModeloFacturacion::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Modelo de Facturación registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $modelo = ModeloFacturacion::find($id);
        $this->codigo = $modelo->codigo;
        $this->valor = $modelo->valor;
        $this->status = $modelo->status;
        $this->selected_id = $modelo->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $modelo = ModeloFacturacion::find($this->selected_id);
        $modelo->codigo = $this->codigo;
        $modelo->valor = $this->valor;
        $modelo->status = $this->status;
        $modelo->save();

        $this->dispatch('noty', msg: 'Modelo de Facturación Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $modelo = ModeloFacturacion::find($id);
        $modelo->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'MODELO DE FACTURACION ELIMINADO CON ÉXITO');
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

