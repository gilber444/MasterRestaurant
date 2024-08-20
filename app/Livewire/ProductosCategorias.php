<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductoCategoria;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class ProductosCategorias extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo,
    $valor, $status, $pagination = 10, $categoria, $estado;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function render()
    {
        return view('livewire.productos_categorias.productosCategorias',[
            'categorias' => $this->Allcategorias()
        ]);
    }

    public function Allcategorias()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductoCategoria::where('categoria', 'like', "%{$this->search}%")
                ->orWhere('categoria', 'like', "%{$this->search}%")
                ->orderBy('categoria', 'asc');

        } else {
            $query = ProductoCategoria::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }


    protected function rules()
    {
        $rules = [
            'categoria' => "required|min:1",
            'estado' => "required|min:1",
        ];


        return $rules;
    }

    protected function messages()
    {
        return [
            'categoria.required' => 'La categoria es requerido',
            'categoria.unique' => 'Ya existe la categoria',
            'categoria.min'=> 'La categoria debe tener mas de 1 caracteres',
            'estado.required' => 'El estado del producto es requerido',
            'estado.min'=> 'El estado debe tener mas de 1 caracteres'
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $createCategoria = ProductoCategoria::create([
            'categoria' => $this->categoria,
            'estado' => $this->estado
        ]);

        $createCategoria->save();

        $this->dispatch('noty', msg: 'Producto registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $selectCategoria = ProductoCategoria::find($id);
        $this->categoria = $selectCategoria->categoria;
        $this->estado = $selectCategoria->estado;
        $this->selected_id = $selectCategoria->id;

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $updateCategoria = ProductoCategoria::find($this->selected_id);
        $updateCategoria->categoria = $this->categoria;
        $updateCategoria->estado = $this->estado;

        $updateCategoria->save();

        $this->dispatch('noty', msg: 'PRODUCTO Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $deleteCategoria = ProductoCategoria::findOrFail($id);
        $deleteCategoria->delete();

        $this->resetPage();
        $this->ResetInt();
        $this->dispatch('noty', msg: 'CATEGORIA ELIMINADA CON ÉXITO');
    }


    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->categoria = '';
        $this->estado = '';
        $this->resetValidation();
    }

}
