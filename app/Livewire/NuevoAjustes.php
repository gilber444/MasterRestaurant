<?php

namespace App\Livewire;

use App\Models\Producto;
use App\Models\Sucursales;
use Livewire\Component;

class NuevoAjustes extends Component
{
    public $search = '', $pageTitle, $selectedProducto = null, $productos = [], $componentName, $sucursales;

    public function mount()
    {
        $this->pageTitle = 'Nuevo';
        $this->componentName = 'Ajustes';
        $this->productos = Producto::with('categoriaProducto', 'unidadMedida')
            ->get()
            ->toArray();
    }

    public function render()
    {
        $producto = Producto::with(['categoriaProducto', 'unidadMedida'])
            ->where('producto', 'like', "%{$this->search}%")
            ->orWhereHas('categoriaProducto', function($query) {
                $query->where('categoria', 'like', "%{$this->search}%");
            })
            ->orWhereHas('unidadMedida', function($query) {
                $query->where('nombre', 'like', "%{$this->search}%");
            })
            ->orderBy('producto', 'asc')
            ->get();

        $sucursales = Sucursales::orderBy('nombre', 'asc')->get();

        return view('livewire.ajustes.nuevo_ajustes', [
            'productos' => $producto,
            'sucursal' => $sucursales,
        ]);
    }
    
    public function selectProduct($productId)
    {
        $this->selectedProducto = Producto::with('categoriaProducto', 'unidadMedida')->find($productId);
    }

    public function updatedProductos()
    {
        $this->emit('refreshSelect2');
    }
}
