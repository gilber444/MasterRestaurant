<?php

namespace App\Livewire;

use App\Models\Ajuste;
use App\Models\DetalleAjuste;
use App\Models\Inventario;
use App\Models\kardex;
use App\Models\Sucursales as ModelSucursal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Ajustes extends Component
{
    use WithPagination;

    public $detalleAjustes = [], $productos, $sucursales, $producto, $records,
        $cantidad, $detalle, $estado, $tipo, $search, $selected_id, $pageTitle, $componentName;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ajustes';
    }

    public function render()
    {
        $query = Ajuste::with(['Rsucursal:id,nombre', 'Rusuario:id,name'])
            ->where('status', 'like', '%' . $this->search . '%')
            ->when(strlen($this->search) > 0, function ($query) {
                $query->where('tipo', 'like', '%' . $this->search . '%')
                    ->orWhereHas('Rsucursal', function ($query) {
                        $query->where('nombre', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rusuario', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('detalle', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');

        $sucursales = ModelSucursal::orderBy('nombre', 'asc')->get();

        $this->records = $query->count();

        $ajustes = $query->paginate(10);

        return view('livewire.ajustes.ajustes', [
            'ajustes' => $ajustes,
            'sucursales' => $sucursales,
        ]);
    }

    public function anular(Ajuste $ajuste)
    {
        $ajuste->update([
            'status' => 'Anulado'
        ]);

        $detalle = DetalleAjuste::where('ajuste', $ajuste->id)->get();
        $sucursalId = $ajuste->sucursal;

        foreach ($detalle as $det) {

            if ($ajuste->tipo == 'Ingreso') {

                $inventario = Inventario::find($det->inventario);

                $newExist = $inventario->existencia - $det->cantidad;

                $inventario->update([
                    'existencia' => $newExist
                ]);

                $ultiR = kardex::where('producto', $det->producto)->where('inventario', $det->inventario)->latest()->first();

                $saldo = $newExist;
                $saldototal = $ultiR->saldototal - ($det->costo * $det->cantidad);
                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => $sucursalId,
                    'producto' => $det->producto,
                    'inventario' => $inventario->id,
                    'descripcion' => 'Anulacion del Ingreso por Ajuste ' . $ajuste->id,
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
            } else {
                $inventario = Inventario::find($det->inventario);

                $newExist = $inventario->existencia + $det->cantidad;

                $inventario->update([
                    'existencia' => $newExist
                ]);

                $ultiR = kardex::where('producto', $det->producto)->where('inventario', $det->inventario)->latest()->first();

                $saldo = $newExist;
                $saldototal = $ultiR->saldototal + ($det->costo * $det->cantidad);
                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => $sucursalId,
                    'producto' => $det->producto,
                    'inventario' => $det->inventario,
                    'descripcion' => 'Anulacion del Egreso por Ajuste ' . $ajuste->id,
                    'fecha' => date('Y-m-d'),
                    'hora' => date('H:i:s'),
                    'ingreso' => $det->cantidad,
                    'totalingreso' => $det->costo * $det->cantidad,
                    'egreso' => 0.00,
                    'totalegreso' => 0.00,
                    'costoUmovimiento' => $ultiR->costoUnitario,
                    'costoUnitario' => $ultiR->costoUnitario,
                    'saldo' => $saldo,
                    'saldototal' => $saldototal,
                ]);
            }
        }

        $this->resetPage();
        $this->dispatch('noty', msg: 'AJUSTE ANULADO CON ÉXITO');
    }


    #[On('destroy')]
    public function destroy($id)
    {
        $a = Ajuste::find($id);

        $a->update([
            'status' => 'Eliminado'
        ]);

        $a->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'AJUSTE ELIMINADO CON ÉXITO');
    }

    #[On('DestroyP')]
    public function DestroyP($detalleId)
    {
        $detalle = DetalleAjuste::find($detalleId);

        $ajuste = Ajuste::find($detalle->ajuste);

        $sucursalId = $ajuste->sucursal;

        $inventario = Inventario::find($detalle->inventario);

        if ($ajuste->tipo == 'Ingreso') {
            $newExist = $inventario->existencia - $detalle->cantidad;
            $inventario->update(['existencia' => $newExist]);

            $ultiR = Kardex::where('producto', $detalle->producto)
                ->where('inventario', $detalle->inventario)
                ->latest()
                ->first();

            $saldo = $newExist;
            $saldototal = $ultiR ? $ultiR->saldototal + ($detalle->costo * $detalle->cantidad) : 0;

            Kardex::create([
                'empresa' => Auth::user()->empresa,
                'sucursal' => $sucursalId,
                'producto' => $detalle->producto,
                'inventario' => $inventario->id,
                'descripcion' => 'Eliminacion del producto por ingreso ' . $ajuste->id,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'ingreso' => 0.00,
                'totalingreso' => 0.00,
                'egreso' => $detalle->cantidad,
                'totalegreso' => $detalle->costo * $detalle->cantidad,
                'costoUmovimiento' => $ultiR->costoUnitario,
                'costoUnitario' => $ultiR->costoUnitario,
                'saldo' => $saldo,
                'saldototal' => $saldototal,
            ]);
        } else {
            $newExist = $inventario->existencia + $detalle->cantidad;
            $inventario->update(['existencia' => $newExist]);

            $ultiR = Kardex::where('producto', $detalle->producto)
                ->where('inventario', $detalle->inventario)
                ->latest()
                ->first();

            $saldo = $newExist;
            $saldototal = $ultiR ? $ultiR->saldototal - ($detalle->costo * $detalle->cantidad) : 0;

            Kardex::create([
                'empresa' => Auth::user()->empresa,
                'sucursal' => $sucursalId,
                'producto' => $detalle->producto,
                'inventario' => $inventario->id,
                'descripcion' => 'Eliminacion del producto por Egreso ' . $ajuste->id,
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'ingreso' => $detalle->cantidad,
                'totalingreso' => $detalle->costo * $detalle->cantidad,
                'egreso' => 0.00,
                'totalegreso' => 0.00,
                'costoUmovimiento' => $ultiR->costoUnitario,
                'costoUnitario' => $ultiR->costoUnitario,
                'saldo' => $saldo,
                'saldototal' => $saldototal,
            ]);
        }

        $detalle->delete();
        $this->dispatch('refreshModal');
        $this->resetPage();
        $this->dispatch('noty', msg: 'PRODUCTO ELIMINADO CON ÉXITO');
    }


    #[On('confirmar')]
    public function confirmar($id)
    {
        $a = Ajuste::find($id);

        $a->update([
            'status' => 'Autorizado'
        ]);

        $this->resetPage();
        $this->dispatch('noty', msg: 'AJUSTE CONFIRMADO CON ÉXITO');
    }

    public function cargarProductosAjustes($ajusteId)
    {
        $this->detalleAjustes = DetalleAjuste::with(['Rproductos', 'Rmedidas', 'Rajustes'])
            ->where('ajuste', $ajusteId)
            ->get()
            ->map(function ($detalle) {
                return [
                    'producto_id' => $detalle->Rproductos->id,
                    'id' => $detalle->id,
                    'cantidad' => $detalle->cantidad,
                    'producto' => $detalle->Rproductos->producto,
                    'unidad' => $detalle->Rmedidas->valor,
                    'status' => $detalle->Rajustes->status,
                ];
            });

        $this->dispatch('open-modal');
    }
}