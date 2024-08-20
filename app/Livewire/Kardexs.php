<?php

namespace App\Livewire;

use App\Models\kardex;
use App\Models\Producto;
use App\Models\Sucursales;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Kardexs extends Component
{
    use WithPagination;

    public  $fechaDesde = [], $fechaHasta = [], $search, $selected_id, $pageTitle, $componentName, $desde, $hasta, $producto, $kardes = [], $inicial = [], $pagination = 10, $sucursal=[];

    public function mount()
    {

        $this->pageTitle = 'Listado';
        $this->componentName = 'Kardex de Productos';
    }

    public function render()
    {
        $data = Producto::query()
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('producto', 'like', '%' . $this->search . '%')
                ->orWhere('codigo_barra', 'like', '%' . $this->search . '%');
        }, function ($query) {
            $query->orderBy('id', 'asc');
        })
        ->paginate($this->pagination);

        $sucursales = Sucursales::all();

        return view('livewire.kardexs.kardexs', [
            'data' => $data,
            'sucursales' => $sucursales
        ]);
    }

    public function Generar($id)
    {
        $rules = [
            'fechaDesde.' . $id => 'required|date',
            'fechaHasta.' . $id => 'required|date|after_or_equal:fechaDesde.' . $id,
            'sucursal.' . $id => 'required',
        ];

        $messages = [
            'fechaDesde.' . $id . '.required' => 'La fecha desde es obligatoria.',
            'fechaHasta.' . $id . '.required' => 'La fecha hasta es obligatoria.',
            'fechaDesde.' . $id . '.date' => 'La fecha desde debe ser una fecha válida.',
            'fechaHasta.' . $id . '.date' => 'La fecha hasta debe ser una fecha válida.',
            'fechaHasta.' . $id . '.after_or_equal' => 'La fecha hasta debe ser una fecha igual o posterior a la fecha desde.',
            'sucursal.' . $id . '.required' => 'La sucursal es obligatoria.',
        ];

        $this->validate($rules, $messages);

        $producto = Producto::find($id);
        $this->producto = $producto->producto;
        $this->desde = $this->fechaDesde[$id] ?? null;
        $this->hasta = $this->fechaHasta[$id] ?? null;
        $this->selected_id = $id;

        $this->inicial = Kardex::with(['Rsucursal:id,nombre'])
        ->where('producto', $id)
        ->whereDate('fecha', '<', Carbon::parse($this->desde))
        ->when($this->sucursal[$id] !== '*', function ($query) {
            return $query->where('sucursal', $this->sucursal[$this->selected_id]);
        })
        ->select('sucursal', 'fecha', 'descripcion', 'ingreso', 'egreso', 'saldo')
        ->orderByDesc('id')
        ->get();

        // Si no hay un registro, aseguramos que $this->inicial sea un objeto con las propiedades esperadas
        if (!$this->inicial) {
            $this->inicial = (object) [
                'fecha' => Carbon::parse($this->desde)->subDay()->format('d/m/Y'),
                'descripcion' => 'Inventario Inicial',
                'sucursal' => 'Sucursal',
                'ingreso' => 0,
                'egreso' => 0,
                'saldo' => 0
            ];
        }
        $this->kardes = Kardex::with(['Rsucursal:id,nombre'])
            ->where('producto', $id)
            ->whereBetween('fecha', [Carbon::parse($this->desde), Carbon::parse($this->hasta)])
            ->when($this->sucursal[$id] !== '*', function ($query) {
                return $query->where('sucursal', $this->sucursal[$this->selected_id]);
            })
            ->get();


        $this->dispatch('open-modal');
        $this->limpiarCampos($id);
    }

    public function limpiarCampos($id)
    {
        $this->sucursal[$id] = '';
        $this->fechaDesde[$id] = '';
        $this->fechaHasta[$id] = '';
        $this->resetValidation();
        $this->resetPage();
    }

}
