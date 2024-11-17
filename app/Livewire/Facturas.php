<?php

namespace App\Livewire;

use App\Models\Factura;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Facturas extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $factura, $status, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Tipo Facturas';
    }

    public function render()
    {
        return view('livewire.facturas.facturas', [
            'facturas' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Factura::where('factura', 'like', "%{$this->search}%")
                ->orderBy('id', 'asc');

        } else {
            $query = Factura::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'factura' => "required|unique:facturas,factura,{$this->selected_id}|min:1",
            'status' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'factura.required' => 'El factura es requerido',
            'factura.unique' => 'Ya existe el factura',
            'factura.min'=> 'El factura debe tener mas de 1 caracteres',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Factura::create([
            'factura' => $this->factura,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Tipo de factura registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $data = Factura::find($id);
        $this->factura = $data->factura;
        $this->status = $data->status;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Factura::find($this->selected_id);
        $data->factura = $this->factura;
        $data->status = $this->status;
        $data->save();

        $this->dispatch('noty', msg: 'Tipo de factura Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = Factura::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'TIPO DE FACTURA ELIMINADA CON ÉXITO');
    }

    public function ResetInt()
    {
        $this->factura = '';
        $this->status = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}



