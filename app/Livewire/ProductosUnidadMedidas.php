<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductoUnidadMedida;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductosUnidadMedidas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName,$codigo,
    $valor, $status, $pagination = 10, $nombre, $simbolo, $estado;
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Unidad de medida';
    }
    public function render()
    {
        return view('livewire.productos_um.productosUnidadMedidas', [
            'unidadesmedidas' => $this->Allunidadesmedida()
        ]);
    }

    public function Allunidadesmedida()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductoUnidadMedida::where('nombre', 'like', "%{$this->search}%")
                ->orWhere('nombre', 'like', "%{$this->search}%")
                ->orderBy('nombre', 'asc');

        } else {
            $query = ProductoUnidadMedida::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'nombre' => "required|min:1",
            'simbolo' => "required|min:1",
            'estado' => "required|min:1",
        ];


        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerida',
            'nombre.unique' => 'Ya existe el nombre',
            'nombre.min'=> 'El nombre debe tener mas de 1 caracteres',
            'simbolo.required' => 'El simbolo es requerida',
            'simbolo.unique' => 'Ya existe el simbolo',
            'simbolo.min'=> 'El simbolo debe tener mas de 1 caracteres',
            'estado.required' => 'El estado del producto es requerido',
            'estado.min'=> 'El estado debe tener mas de 1 caracteres'
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $createUnidadMedida = ProductoUnidadMedida::create([
            'nombre' => $this->nombre,
            'simbolo' => $this->simbolo,
            'estado' => $this->estado
        ]);

        $createUnidadMedida->save();

        $this->dispatch('noty', msg: 'Producto registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $selectUnidad = ProductoUnidadMedida::find($id);
        $this->nombre = $selectUnidad->nombre;
        $this->simbolo = $selectUnidad->simbolo;
        $this->estado = $selectUnidad->estado;
        $this->selected_id = $selectUnidad->id;

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $updateUnidad = ProductoUnidadMedida::find($this->selected_id);
        $updateUnidad->nombre = $this->nombre;
        $updateUnidad->simbolo = $this->simbolo;
        $updateUnidad->estado = $this->estado;

        $updateUnidad->save();

        $this->dispatch('noty', msg: 'UNIDAD Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $deleteUnidad = ProductoUnidadMedida::findOrFail($id);
        $deleteUnidad->delete();

        $this->resetPage();
        $this->ResetInt();
        $this->dispatch('noty', msg: 'UNIDAD ELIMINADA CON ÉXITO');
    }


    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->nombre = '';
        $this->simbolo = '';
        $this->estado = '';
        $this->resetValidation();
    }
}
