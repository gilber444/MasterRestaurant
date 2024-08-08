<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use App\Models\UnidadMedida;
use App\Models\Producto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, $valor, $status, $pagination = 10;

    public $codigo_barra;
    public $producto;
    public $categoria;
    public $marca;
    public $unidad_medida;
    public $unidad_medida_mh; 

    public function mount()
    {
        $this->pageTitle = 'Productos';
        $this->componentName = 'Listado';
    }
    public function render()
    {
        return view('livewire.admin_productos.productos',[
            'unidades' => $this->UMexterno()
        ]);
    }

    // consulta de Unidades de medida Ministerio de Hacienda
    public function UMexterno()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = UnidadMedida::where('valor', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%")
                ->orderBy('codigo', 'asc');

        } else {
            $query = UnidadMedida::orderBy('codigo', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'codigo_barra' => "required|unique:productos,codigo_barra,{$this->selected_id}|min:1",
            'producto' => "required|min:1",
            'categoria' => "required|min:1",
            'marca' => "required|min:1",
            'unidad_medida' => "required|min:1",
            'unidad_medida_mh' => "required|min:3",
        ];
        

        return $rules;
    }

    protected function messages()
    {
        return [
            'codigo_barra.required' => 'El codigo_barra es requerido',
            'codigo_barra.unique' => 'Ya existe el codigo_barra',
            'codigo_barra.min'=> 'El codigo_barra debe tener mas de 1 caracteres',
            'producto.required' => 'El nombre del producto es requerido',
            'producto.unique' => 'Ya existe el nombre del producto',
            'producto.min'=> 'El producto debe tener mas de 1 caracteres',
            'marca.required' => 'El nombre de la marca es requerido',
            'marca.unique' => 'Ya existe el nombre de la marca',
            'marca.min'=> 'El nombre de la marca debe tener mas de 1 caracteres',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $medida = Producto::create([
            'codigo_barra' => $this->codigo_barra,
            'producto' => $this->producto,
            'categoria' => $this->categoria,
            'marca' => $this->marca,
            'unidad_medida' => $this->unidad_medida,
            'unidad_medida_mh' => $this->unidad_medida_mh
        ]);

        $this->dispatch('noty', msg: 'Producto registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function ResetInt()
    {
        $this->codigo_barra = '';
        $this->producto = '';
        $this->categoria = 0;
        $this->marca = '';
        $this->unidad_medida = 0;
        $this->unidad_medida_mh = 0;
        $this->resetValidation();
    }
    
}
