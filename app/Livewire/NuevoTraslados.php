<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Sucursales;

class NuevoTraslados extends Component
{
    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo, 
    $valor, $status, $pagination = 10;
    public function render()
    {
        return view('livewire.nuevo_traslado.nuevotraslado',[
            'productos' => $this->Allproductos(),
            'sucursales' => $this->AllSucursales()
        ]);
    }

    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Producto::where('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('codigo_barra', 'like', "%{$this->search}%")
                ->orderBy('codigo_barra', 'asc');

        } else {
            $query = Producto::where('presentacion', '1')
            ->with('unidadMedidaMH')
            ->orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    public function AllSucursales(){
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Sucursales::where('nombre', 'like', "%{$this->search}%")
                ->orWhere('nombre', 'like', "%{$this->search}%")
                ->orderBy('nombre', 'asc');

        } else {
            $query = Sucursales::orderBy('nombre', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

}
