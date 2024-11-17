<?php

namespace App\Livewire;

use App\Models\FormaVenta;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class FormaVentas extends Component
{
    use WithPagination;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $forma_venta, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Forma De Venta';
    }

    public function render()
    {
        return view('livewire.forma_ventas.forma_ventas', [
            'ventas' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = FormaVenta::where('forma_venta', 'like', "%{$this->search}%")
                ->orderBy('id', 'asc');

        } else {
            $query = FormaVenta::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'forma_venta' => "required|unique:forma_ventas,forma_venta,{$this->selected_id}|min:1"
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'forma_venta.required' => 'La forma de venta es requerido',
            'forma_venta.unique' => 'Ya existe la forma de venta',
            'forma_venta.min'=> 'La forma de venta debe tener mas de 3 caracteres'
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = FormaVenta::create([
            'forma_venta' => $this->forma_venta,
        ]);

        $this->dispatch('noty', msg: 'Forma de venta registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $data = FormaVenta::find($id);
        $this->forma_venta = $data->forma_venta;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = FormaVenta::find($this->selected_id);
        $data->forma_venta = $this->forma_venta;
        $data->save();

        $this->dispatch('noty', msg: 'Forma de venta Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = FormaVenta::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'FORMA DE VENTA ELIMINADA CON ÉXITO');
    }

    protected $listeners = [
        'store' => 'Store',
        'edit' => 'Edit'
    ];

    public function ResetInt()
    {
        $this->forma_venta = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}



