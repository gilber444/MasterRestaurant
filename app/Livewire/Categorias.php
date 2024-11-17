<?php

namespace App\Livewire;

use App\Models\Categorias as ModelsCategorias;
use App\Models\Lineas;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
class Categorias extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $categoria,$linea, $pagination = 10, $records;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function render()
    {
        return view('livewire.categorias.categorias', [
            'categorias' => $this->loadData(),
            'lineas' => $this->Lineas()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ModelsCategorias::where('categoria', 'like', "%{$this->search}%")
                ->orderBy('linea', 'asc');

        } else {
            $query = ModelsCategorias::orderBy('id', 'asc');
        }

        return $query->paginate($this->pagination);
    }

    public function Lineas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Lineas::orderBy('id', 'asc');

        } else {
            $query = Lineas::orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }
    

    protected function rules()
    {
        $rules = [
            'categoria' => "required|unique:categorias,categoria,{$this->selected_id}|min:3",
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'categoria.required' => 'El nombre de la categoria es requerido',
            'categoria.unique' => 'Ya existe esta categoria',
            'categoria.min'=> 'El nombre de la categoria debe tener mas de 3 caracteres',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsCategorias::create([
            'categoria' => $this->categoria,
            'linea' => $this->linea,
        ]);

        $this->dispatch('noty', msg: 'Categoria registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $cate = ModelsCategorias::find($id);
        $this->categoria = $cate->categoria;
        $this->linea = $cate->linea;
        $this->selected_id = $cate->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsCategorias::find($this->selected_id);
        $data->categoria = $this->categoria;
        $data->linea = $this->linea;
        $data->save();

        $this->dispatch('noty', msg: 'Categoria Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = ModelsCategorias::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'CATEGORIA ELIMINADA CON ÉXITO');
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->categoria = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
