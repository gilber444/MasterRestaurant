<?php

namespace App\Livewire;

use App\Models\Categorias;
use App\Models\FormaVenta;
use App\Models\Lineas;
use App\Models\Marcas;
use App\Models\Precios;
use App\Models\ProductoMenu;
use App\Models\RecetaProductos;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductoMenus extends Component
{
    public $search, $records, $selected_id, $pageTitle, $modalAction, $activateNewSection, $componentName,
        $producto, $marca, $linea, $categoria, $forma_venta, $comun, $status, $pagination = 10,
        $medidas;

    public $filtroMarca, $filtroLinea, $filtroCategoria, $filtroFormaVenta, $filtroStatus;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos Menú';
        $this->resetFiltro();
    }
    
    public function render()
    {
        $query = ProductoMenu::with(['Rmarcas:id,marca', 'Rlineas:id,linea', 'Rcategorias:id,categoria', 'Rventas:id,forma_venta'])
            ->when($this->filtroMarca, function ($query) {
                $query->whereHas('Rmarcas', function ($q) {
                    $q->where('id', $this->filtroMarca);
                });
            })
            ->when($this->filtroLinea, function ($query) {
                $query->whereHas('Rlineas', function ($q) {
                    $q->where('id', $this->filtroLinea);
                });
            })
            ->when($this->filtroCategoria, function ($query) {
                $query->whereHas('Rcategorias', function ($q) {
                    $q->where('id', $this->filtroCategoria);
                });
            })
            ->when($this->filtroFormaVenta, function ($query) {
                $query->whereHas('Rventas', function ($q) {
                    $q->where('id', $this->filtroFormaVenta);
                });
            })
            ->when($this->filtroStatus, function ($query) {
                $query->where('status', $this->filtroStatus);
            })
            ->where(function ($query) {
                $query->where('producto', 'like', '%' . $this->search . '%')
                    ->orWhereHas('Rmarcas', function ($q) {
                        $q->where('marca', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rlineas', function ($q) {
                        $q->where('linea', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rcategorias', function ($q) {
                        $q->where('categoria', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rventas', function ($q) {
                        $q->where('forma_venta', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('comun', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');
    
        $productos = $query->paginate(10);
    
        return view('livewire.producto_menus.producto_menus', [
            'productos' => $productos,
            'marcas' => Marcas::orderBy('marca', 'asc')->get(),
            'lineas' => Lineas::orderBy('linea', 'asc')->get(),
            'categorias' => Categorias::orderBy('categoria', 'asc')->get(),
            'FormaVentas' => FormaVenta::orderBy('forma_venta', 'asc')->get(),
        ]);
    }
    
    public function filtrar()
    {
        $this->render();
    }
    
    public function resetFiltro()
    {
        $this->reset(['filtroMarca', 'filtroLinea', 'filtroCategoria', 'filtroFormaVenta', 'filtroStatus']);
        $this->filtrar();
    }
    

    protected function rules()
    {
        $rules = [
            'producto' => "required|unique:producto_menus,producto,{$this->selected_id}|min:5",
            'marca' => 'required',
            'linea' => 'required',
            'categoria' => 'required',
            'forma_venta' => 'required',
            'comun' => 'required',
            'status' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'producto.required' => 'El producto es requerido',
            'producto.unique' => 'Ya existe el producto',
            'producto.min' => 'El producto debe tener mas de 5 caracteres',
            'marca.required' => 'La marca es requerida',
            'linea.required' => 'La linea es requerida',
            'categoria.required' => 'La categoria es requerida',
            'forma_venta.required' => 'La forma de venta es requerida',
            'comun.required' => 'El producto en común es requerido',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ProductoMenu::create([
            'producto' => $this->producto,
            'marca' => $this->marca,
            'linea' => $this->linea,
            'categoria' => $this->categoria,
            'forma_venta' => $this->forma_venta,
            'comun' => $this->comun,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Se a registrado el producto en el menú con exito');
        return redirect()->route('EditarProducto', [$data->id, true]);

        $this->dispatch('close-modal');
        $this->ResetInt();
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $pro = ProductoMenu::find($id);

        $precio = Precios::where('producto', $pro->id);
        $receta = RecetaProductos::where('producto', $pro->id);
        if ($precio->exists()) {
            $precio->delete();
        }

        if ($receta->exists()) {
            $receta->delete();
        }

        $pro->delete();

        $this->ResetInt();
        $this->dispatch('noty', msg: 'Producto Eliminado');
    }

    public function ResetInt()
    {
        $this->producto = '';
        $this->marca = '';
        $this->linea = '';
        $this->categoria = '';
        $this->forma_venta = '';
        $this->comun = '';
        $this->status = '';
        $this->search = '';
        $this->resetValidation();
    }
}
