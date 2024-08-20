<?php

namespace App\Livewire;

use App\Models\DocumentoAsociado;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentoAsociados extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Documentos Asociados';
    }

    public function render()
    {
        return view('livewire.documento_asociados.documento_asociados', [
            'documento' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = DocumentoAsociado::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = DocumentoAsociado::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:documento_asociados,codigo,{$this->selected_id}|min:1",
            'valor' => "required|unique:documento_asociados,valor,{$this->selected_id}|min:3",
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
            'valor.required' => 'El nombre del documento asociado es requerido',
            'valor.unique' => 'Ya existe el documento asociado',
            'valor.min'=> 'El nombre del documento asociado debe tener mas de 3 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = DocumentoAsociado::create([
            'codigo' => $this->codigo,
            'valor' => $this->valor,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Documento Asociado registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $data = DocumentoAsociado::find($id);
        $this->codigo = $data->codigo;
        $this->valor = $data->valor;
        $this->status = $data->status;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = DocumentoAsociado::find($this->selected_id);
        $data->codigo = $this->codigo;
        $data->valor = $this->valor;
        $data->status = $this->status;
        $data->save();

        $this->dispatch('noty', msg: 'Documento Asociado Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = DocumentoAsociado::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'DOCUMENTO ASOCIADO ELIMINADO CON ÉXITO');
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



