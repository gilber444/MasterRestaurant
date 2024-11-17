<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\ProductoMenu;
use App\Models\RecetaProductos;
use App\Models\Inventario;
use App\Models\ProgramacionMenu;

class ProgramacionMenuEditar extends Component
{    
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName,$codigo,
    $valor, $status, $pagination = 10, $productoMenu = [], $producto, $stock, $fecha,$prueba = [], $existenciasInsuficientes, $selectprogmenuID;
    public function mount($idProgmenu)
    {
        $selectProgMenu = ProgramacionMenu::find($idProgmenu);
        $this->selectprogmenuID = $idProgmenu; // uso en update()

        $this->fecha = $selectProgMenu->fecha;
        $this->stock = $selectProgMenu->stock;
        $this->producto = $selectProgMenu->producto;

        $this->pageTitle = 'Listado';
        $this->componentName = 'Programacion del Menu';

        $this->Temporal($selectProgMenu->producto);
        
    }
    public function render()
    {
        return view('livewire.programacion_menu_editar.programacion_menu_editar',[
            'productos' => $this->Allproductos()
        ]);
    }

    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductoMenu::where('status', 'Activo')
                ->orWhere('producto', 'like', "%{$this->search}%")
                ->orWhere('id', 'like', "%{$this->search}%")
                ->orderBy('id', 'desc');

        } else {
            $query = ProductoMenu::where('status', 'Activo')
            ->with('Rmarcas')
            ->orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    public function Temporal($productoId)
    {
        $this->productoMenu = RecetaProductos::with('RProducto')
        ->where('producto', $productoId)->get();
    }

    protected function rules()
    {
        $rules = [
            'producto' => "required|min:1",
            'stock' => "required|numeric|min:1",
            'fecha' => "required|min:1",
        ];


        return $rules;
    }

    protected function messages()
    {
        return [
            'producto.required' => 'El producto es requerido',
            'producto.unique' => 'Ya existe el producto',
            'producto.min'=> 'El producto debe tener mas de 1 caracteres',
            'stock.required' => 'El stock es requerido',
            'stock.unique' => 'Ya existe el stock',
            'stock.min'=> 'El stock debe ser mayor a 1',
            'fecha.required' => 'El fecha es requerida',
            'fecha.min'=> 'El fecha debe tener mas de 1 caracteres'
        ];
    }

    public function Update(){
        $this->validate($this->rules(), $this->messages());

        $this->prueba = RecetaProductos::with('RProducto')
        ->where('producto', $this->producto)->get();

        if($this->prueba->isNotEmpty()){

            $existenciasList = [];

            foreach ($this->prueba as $key ) {
                // Formula de productos
                $existenciasFormula = $key->cantidad * $this->stock;

                $inventario = Inventario::where('producto', $key->RProducto->id)->first();

                if ($inventario) {
                    $existencia = $inventario->existencia;

                    if($existenciasFormula <= $existencia){
                        $existenciasList[] = [
                            'producto_id' => $key->RProducto->id,
                            'producto_name' => $key->RProducto->producto,
                            'existencia' => true,
                            'existencia_number' => $existencia,
                            'existencia_formula' => $existenciasFormula,
                        ];
                    }
                    else{ 
                        $existenciasList[] = [
                            'producto_id' => $key->RProducto->id,
                            'producto_name' => $key->RProducto->producto,
                            'existencia' => false,
                            'existencia_number' => $existencia,
                            'existencia_formula' => $existenciasFormula,
                        ];
                    }
                } 
            }

            $this->existenciasInsuficientes = array_filter($existenciasList, function ($item) {
                return $item['existencia'] === false;
            });
            
            if (!empty($this->existenciasInsuficientes)) {
                $this->dispatch('open-modal');
                $this->dispatch('noty-error-menu', msg: 'No hay suficientes existencias de productos en el inventario');
            } else {
                $updateProgMenu = ProgramacionMenu::find($this->selectprogmenuID);
                $updateProgMenu->fecha = $this->fecha;
                $updateProgMenu->stock = $this->stock;
                $updateProgMenu->producto = $this->producto;

                $updateProgMenu->save();

                $this->dispatch('noty', msg: 'Platillo creado con exito');
                return redirect()->route('programacionmenu');
            }

        }
        else{
            $this->dispatch('noty-error', msg: 'El producto no cuenta con una receta');
        }
    }

    


    public function resetProcess()
    {
        return redirect()->route('programacionmenu');
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->fecha ;
        $this->stock;
        $this->producto ;
    }

}
