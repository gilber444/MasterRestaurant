<?php

namespace App\Livewire;

use App\Models\Cotizaciones as ModelsCotizaciones;
use App\Models\DetalleCotizacion;
use App\Models\Proveedores;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Cotizaciones extends Component
{
    use WithPagination;

    public $detalleCotizaciones = [], $records, $search, $selected_id, $pageTitle, $componentName;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cotizaciones';
    }

    public function render()
{
    $query = ModelsCotizaciones::with(['Rproveedor:id,nombre', 'Rusuario:id,name'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->whereHas('Rproveedor', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('Rusuario', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('proveedor', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc');

    $proveedores = Proveedores::orderBy('nombre', 'asc')->get();

    $this->records = $query->count();

    $cotizaciones = $query->paginate(10);

    return view('livewire.compras.cotizaciones', [
        'cotizaciones' => $cotizaciones,
        'proveedores' => $proveedores,
    ]);
}

    #[On('destroy')]
    public function destroy($id)
    {
        $c = ModelsCotizaciones::find($id);

        $c->update([
            'estado' => 'Eliminado'
        ]);

        $c->delete();
        $this->dispatch('noty', msg: 'COTIZACION ELIMINADA CON ÉXITO');
    }


    #[On('anular')]
    public function anular($id)
    {
        $c = ModelsCotizaciones::find($id);

        $c->update([
            'estado' => 'Anulado'
        ]);

        $this->dispatch('noty', msg: 'COTIZACION ANULADA CON ÉXITO');
    }

    #[On('actualizar')]
    public function actualizar($id)
    {
        $c = ModelsCotizaciones::find($id);

        $c->update([
            'estado' => 'Realizado'
        ]);

        $this->dispatch('noty', msg: 'COTIZACION ACTUALIZADA CON ÉXITO');
    }

    public function cargarProductosCotizacion($cotizacionId)
    {
        $this->detalleCotizaciones = DetalleCotizacion::with(['Rproductos', 'Rmedida', 'Rcotizacion'])
            ->where('cotizacion', $cotizacionId)
            ->get()
            ->map(function ($detalle) {
                return [
                    'id' => $detalle->id,
                    'codigo_barra' => $detalle->Rproductos->codigo_barra,
                    'producto' => $detalle->Rproductos->producto,
                    'unidad' => $detalle->Rmedida->valor,
                    'cantidad' => $detalle->cantidad,
                    'estado' => $detalle->Rcotizacion->estado,
                ];
            });

        $this->dispatch('open-modal');
    }

    public function cargarCotizacionParaImpresion($cotizacionId)
{
    $this->detalleCotizaciones = DetalleCotizacion::with(['Rproductos', 'Rmedida', 'Rcotizacion'])
            ->where('cotizacion', $cotizacionId)
            ->get()
            ->map(function ($detalle) {
                return [
                    'id' => $detalle->id,
                    'codigo_barra' => $detalle->Rproductos->codigo_barra,
                    'producto' => $detalle->Rproductos->producto,
                    'unidad' => $detalle->Rmedida->valor,
                    'cantidad' => $detalle->cantidad,
                    'estado' => $detalle->Rcotizacion->estado,
                ];
            });

        $this->dispatch('open-impression-modal');
}

}
