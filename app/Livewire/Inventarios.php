<?php

namespace App\Livewire;

use App\Models\Inventario;
use App\Models\Sucursales;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Inventarios extends Component
{
    use WithPagination;

    public $search, $selected_id, $pageTitle, $componentName, $sucursalSeleccionada = 'Global', $ubicacion;

    private $pagination = 7;

    public function mount()
    {
        $user_id = Auth::user()->id;
        $this->pageTitle = 'Listado';
        $this->componentName = 'Existencias de Productos';
    }

    public function render()
    {
        $empresa = session('empresa');
        $sucursal = session('sucursal');
        $caja = session('caja');
        $rol = Auth::user()->profile;

        $data = Inventario::with([
            'Rempresa:id,empresa',
            'Rsucursal:id,nombre',
            'Rproductos:id,codigo_barra,producto,unidad_medida,categoria',
            'Rproductos.RunidadMedida:id,nombre',
            'Rproductos.RcategoriaProducto:id,categoria'
        ]);

        if ($rol === 'Administrador' || $rol === 'Super') {
            if (strlen($this->search) > 0) {
                // Búsqueda avanzada en múltiples campos y relaciones
                $data->where(function($query) {
                    $query->whereHas('Rproductos', function($q) {
                        $q->where('codigo_barra', 'like', '%' . $this->search . '%')
                        ->orWhere('producto', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rproductos.RunidadMedida', function($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rproductos.RcategoriaProducto', function($q) {
                        $q->where('categoria', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rsucursal', function($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('existencia', 'like', '%' . $this->search . '%');
                });
            } elseif (strlen($this->sucursalSeleccionada) > 0 && $this->sucursalSeleccionada !== 'Global') {
                $data->where('sucursal', $this->sucursalSeleccionada)->get();
            }
        }else{
            $data->where('sucursal', $sucursal);
        }
        $data = $data->paginate($this->pagination);
        //dd($data);
        $sucursales = Sucursales::orderBy('nombre', 'asc')->get();
        return view('livewire.inventarios.inventarios', [
            'data' => $data,
            'sucursales' => $sucursales,
            'empresa' => $empresa,
            'sucursal' => $sucursal,
            'caja' => $caja,
            'rol' => $rol
        ]);
    }
}
