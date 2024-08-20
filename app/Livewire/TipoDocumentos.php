<?php

namespace App\Livewire;

use App\Models\TipoDocumento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TipoDocumentos extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Tipo de Documento';
    }

    public function render()
    {
        return view('livewire.tipo_documentos.tipo_documentos', [
            'documentos' => $this->loadDocumentos()
        ]);
    }

    public function loadDocumentos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = TipoDocumento::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = TipoDocumento::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:tipo_documentos,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:tipo_documentos,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del tipo de documento es requerido',
            'valor.unique' => 'Ya existe el tipo de documento',
            'valor.min'=> 'El nombre del tipo de documento debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $documento = TipoDocumento::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Tipo de Documento registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $documento = TipoDocumento::find($id);
        $this->codigo = $documento->codigo;
        $this->valor = $documento->valor;
        $this->status = $documento->status;
        $this->selected_id = $documento->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $documento = TipoDocumento::find($this->selected_id);
        $documento->codigo = $this->codigo;
        $documento->valor = $this->valor;
        $documento->status = $this->status;
        $documento->save();

        $this->dispatch('noty', msg: 'Tipo de Documento Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $documento = TipoDocumento::find($id);
        $documento->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'TIPO DOCUMENTO ELIMINADO CON ÉXITO');
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
