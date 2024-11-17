<?php

namespace App\Livewire;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\kardex;
use App\Models\Proveedores;
use App\Models\Sucursales;
use App\Models\TipoEstablecimiento;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Compras extends Component
{
    use WithPagination;

    public $detalleCompras = [], $proveedores, $records, $search, $selected_id, $pageTitle, $componentName;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Compras';
    }

    public function render()
{
    $query = Compra::with(['Rproveedor:id,nombre', 'Rusuario:id,name', 'Rcondicion:id,valor'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->whereHas('Rproveedor', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('Rusuario', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('Rcondicion', function ($query) {
                $query->where('valor', 'like', '%' . $this->search . '%');
            })
            ->orWhere('proveedor', 'like', '%' . $this->search . '%')
            ->orWhere('fechaCompra', 'like', '%' . $this->search . '%')
            ->orWhere('correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('condicionPago', 'like', '%' . $this->search . '%')
            ->orWhere('vendedor', 'like', '%' . $this->search . '%')
            ->orWhere('estado', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'desc');

    $proveedores = Proveedores::orderBy('nombre', 'asc')->get();

    $this->records = $query->count();

    $compras = $query->paginate(10);

    return view('livewire.compras.compras', [
        'compras' => $compras,
        'proveedores' => $proveedores,
    ]);
}


    #[On('confirmar')]
    public function confirmar($id)
    {
        $a = Compra::find($id);

        $a->update([
            'estado' => 'Cancelado'
        ]);

        $this->resetPage();
        $this->dispatch('noty', msg: 'COMPRA CONFIRMADA CON ÉXITO');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $c = Compra::find($id);

        $c->update([
            'estado' => 'Eliminado'
        ]);

        $c->delete();
        $this->dispatch('noty', msg: 'COMPRA ELIMINADA CON ÉXITO');
    }

    public function anular(Compra $compra)
    {
        $compra->update([
            'estado' => 'Anulado'
        ]);

        $detalle = DetalleCompra::where('compra', $compra->id)->get();

        foreach ($detalle as $det) {

            $establecimiento = TipoEstablecimiento::where('valor', 'Bodega')->first();
                $bodega = Sucursales::where('tipo', $establecimiento->id)->first();
                $inventario = Inventario::where('producto', $det->producto)->where('sucursal', $bodega->id)->first();

            $newExist = $inventario->existencia - $det->cantidad;

            $inventario->update([
                'existencia' => $newExist
            ]);

            $ultiR = kardex::where('producto', $det->producto)->where('inventario', $det->inventario)->latest()->first();

            $saldo = $newExist;
            $saldototal = $ultiR->saldototal - ($det->costo * $det->cantidad);
            Kardex::create([
                'empresa' => Auth::user()->empresa,
                'sucursal' => $inventario->sucursal,
                'producto' => $det->producto,
                'inventario' => $inventario->id,
                'descripcion' => 'Anulacion la compra ' . $compra->id,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'ingreso' => 0.00,
                'totalingreso' => 0.00,
                'egreso' => $det->cantidad,
                'totalegreso' => $det->costo * $det->cantidad,
                'costoUmovimiento' => $ultiR->costoUnitario,
                'costoUnitario' => $ultiR->costoUnitario,
                'saldo' => $saldo,
                'saldototal' => $saldototal,
            ]);
        }

        $this->resetPage();
        $this->dispatch('noty', msg: 'COMPRA ANULADA CON ÉXITO');
    }

    // #[On('DestroyP')]
    // public function DestroyP($detalleId)
    // {
    //     $detalle = DetalleCompra::find($detalleId);

    //     $compra = Compra::find($detalle->compra);

    //     $empresa = Auth::user()->empresa;

    //     $sucursal = Sucursales::whereHas('tipoEstablecimientos', function ($query) {
    //         $query->where('valor', 'Bodega');
    //     })->where('empresa', $empresa)
    //         ->first();

    //     $inventario = Inventario::where('producto', $detalle->producto)->where('sucursal', $sucursal->id)->first();

    //     $newExist = $inventario->existencia - $detalle->cantidad;
    //     $inventario->update(['existencia' => $newExist]);

    //     $ultiR = Kardex::where('producto', $detalle->producto)
    //         ->where('inventario', $detalle->inventario)
    //         ->latest()
    //         ->first();

    //     $saldo = $newExist;
    //     $saldototal = $ultiR->saldototal - ($detalle->costo * $detalle->cantidad);

    //     Kardex::create([
    //         'empresa' => Auth::user()->empresa,
    //         'sucursal' => $sucursal->id,
    //         'producto' => $detalle->producto,
    //         'inventario' => $inventario->id,
    //         'descripcion' => 'Eliminacion de producto de la compra ' . $compra->id,
    //         'fecha' => date('Y-m-d'),
    //         'hora' => date('H:i:s'),
    //         'ingreso' => 0.00,
    //         'totalingreso' => 0.00,
    //         'egreso' => $detalle->cantidad,
    //         'totalegreso' => $detalle->costo * $detalle->cantidad,
    //         'costoUmovimiento' => $ultiR->costoUnitario,
    //         'costoUnitario' => $ultiR->costoUnitario,
    //         'saldo' => $saldo,
    //         'saldototal' => $saldototal,
    //     ]);

    //     $detalle->delete();
    //     $this->dispatch('refreshModal');
    //     $this->resetPage();
    //     $this->dispatch('noty', msg: 'PRODUCTO ELIMINADO CON ÉXITO');
    // }

    public function cargarProductosCompras($compraId)
    {
        $this->detalleCompras = DetalleCompra::with(['Rproductos', 'Rmedida', 'Rcompra'])
            ->where('compra', $compraId)
            ->get()
            ->map(function ($detalle) {
                return [
                    'codigo_barra' => $detalle->Rproductos->codigo_barra,
                    'id' => $detalle->id,
                    'producto' => $detalle->Rproductos->producto,
                    'unidad' => $detalle->Rmedida->valor,
                    'cantidad' => $detalle->cantidad,
                    'costo' => $detalle->costo,
                    'total' => $detalle->total,
                    'estado' => $detalle->Rcompra->estado,
                ];
            });

        $this->dispatch('open-modal');
    }
}
