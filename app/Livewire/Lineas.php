<?php

namespace App\Livewire;

use App\Models\Lineas as ModelsLineas;
use App\Models\Marcas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class Lineas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $linea,$marca, $pagination = 10, $records;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Lineas';
    }

    public function render()
    {
        return view('livewire.lineas.lineas', [
            'lineas' => $this->loadData(),
            'marcas' => $this->Marcas()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ModelsLineas::where('linea', 'like', "%{$this->search}%")
                ->orderBy('linea', 'asc');

        } else {
            $query = ModelsLineas::orderBy('id', 'asc');
        }

        return $query->paginate($this->pagination);
    }
    public function Marcas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Marcas::orderBy('id', 'asc');

        } else {
            $query = Marcas::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }
    

    protected function rules()
    {
        $rules = [
            'linea' => "required|unique:lineas,linea,{$this->selected_id}|min:3",
            'marca' => "required|min:1",
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'linea.required' => 'El nombre de la linea es requerido',
            'linea.unique' => 'Ya existe esta linea',
            'linea.min'=> 'El nombre de la linea debe tener mas de 3 caracteres',
            'marca.required' => 'La marca es requerido',
            'marca.min'=> 'Seleccione una marca',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsLineas::create([
            'linea' => $this->linea,
            'marca' => $this->marca,
        ]);

        $this->dispatch('noty', msg: 'Liena registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $linea = ModelsLineas::find($id);
        $this->linea = $linea->linea;
        $this->marca = $linea->marca;
        $this->selected_id = $linea->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsLineas::find($this->selected_id);
        $data->linea = $this->linea;
        $data->marca = $this->marca;
        $data->save();

        $this->dispatch('noty', msg: 'Linea Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = ModelsLineas::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'LINEA ELIMINADA CON ÉXITO');
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->linea = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
