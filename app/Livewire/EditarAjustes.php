<?php

namespace App\Livewire;

use App\Models\Ajuste;
use App\Models\DetalleAjuste;
use App\Models\Inventario;
use App\Models\kardex;
use App\Models\Producto;
use App\Models\Sucursales;
use App\Models\TempAjuste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarAjustes extends Component
{
    public $search, $ajuste, $records, $ajusteId, $sucursal, $tipo, $fecha, $pagination = 10,
        $detalle, $productos = [], $cant = [], $idAjuste;

    public function mount($idAjuste)
    {
        $this->idAjuste = $idAjuste;
        $ajuste = Ajuste::find($this->idAjuste);

        $this->sucursal = $ajuste->sucursal;
        $this->tipo = $ajuste->tipo;
        $this->fecha = $ajuste->fecha;
        $this->detalle = $ajuste->detalle;
        $this->ajusteId = $ajuste->id;

        $detalleAjuste = DetalleAjuste::where('ajuste', $idAjuste)->get();

        foreach ($detalleAjuste as $det) {
            $producto = Producto::where('id', $det->producto)->first();

            $tempExistente = TempAjuste::where('producto', $producto->id)
                ->where('user', $ajuste->user)
                ->first();

            if (!$tempExistente) {
                TempAjuste::create([
                    'codigo' => $producto->codigo_barra,
                    'producto' => $producto->id,
                    'medida' => $producto->unidad_medida,
                    'nombre' => $producto->producto,
                    'cantidad' => $det->cantidad,
                    'costo' => $producto->csiva,
                    'total' => $det->cantidad * $producto->csiva,
                    'user' => $ajuste->user,
                ]);
            }
        }

        $this->productos = $this->Allproductos();
        $this->Carrito();
    }


    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.ajustes.editar_ajustes', [
            'productos' => $this->Allproductos(),
            'sucursales' => $this->AllSucursales(),
            'items' => TempAjuste::where('user', $user_id)->get()
        ]);
    }

    public function Allproductos()
    {
        $query = Producto::with('RunidadMedidaMH')
            ->when($this->search, function ($query) {
                $query->where('codigo_barra', 'like', "%{$this->search}%")
                    ->orWhere('producto', 'like', "%{$this->search}%");
            })
            ->orderBy('producto', 'asc');

        $productosPaginated = $query->paginate($this->pagination);

        return $productosPaginated->items();
    }

    public function AllSucursales()
    {
        if (!empty($this->search)) {

            $query = Sucursales::where('nombre', 'like', "%{$this->search}%")
                ->orWhere('nombre', 'like', "%{$this->search}%")
                ->orderBy('nombre', 'asc');
        } else {
            $query = Sucursales::orderBy('nombre', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    #[On('Temporal')]
    public function Temporal($id)
    {
        $user_id = Auth::user()->id;
        $query = Producto::find($id);
        $tmp = TempAjuste::where('user', $user_id)
            ->where('producto', $id)
            ->first();

        if ($tmp) {
            $tmp->cantidad = $tmp->cantidad + 1;
            $tmp->total = ($tmp->cantidad + 1) * $tmp->costo;
            $tmp->save();
        } else {
            $createTemp = TempAjuste::create([
                'codigo' => $query->codigo_barra,
                'producto' => $query->id,
                'medida' => $query->unidad_medida,
                'nombre' => $query->producto,
                'cantidad' => 1,
                'costo' => $query->csiva,
                'total' => $query->csiva,
                'user' => $user_id,
            ]);
        }
        $this->Carrito();
    }

    public function Carrito()
    {
        $user_id = Auth::user()->id;
        $items = TempAjuste::where('user', $user_id)->get();

        foreach ($items as $item) {
            $this->cant[$item->id] = $item->cantidad;
        }
    }

    public function deleteItem($id)
    {
        $detalleAjuste = DetalleAjuste::find($id);

        if ($detalleAjuste) {
            $detalleAjuste->delete();

            TempAjuste::where('producto', $detalleAjuste->producto)
                ->where('user', Auth::user()->id)
                ->delete();
        } else {
            $tempAjuste = TempAjuste::where('id', $id)
                ->where('user', Auth::user()->id)
                ->first();

            if ($tempAjuste) {
                $tempAjuste->delete();
            }
        }

        $this->Carrito();
    }


    public function updateCantidad($id)
    {
        $item = TempAjuste::find($id);
        $item->cantidad = $this->cant[$item->id];
        $item->total = $this->cant[$item->id] * $item->costo;
        $item->save();

        $this->Carrito();
    }

    protected function rules()
    {
        $rules = [
            'sucursal' => 'required',
            'tipo' => 'required',
            'fecha' => 'required',
            'detalle' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'sucursal.required' => 'La sucursal es requerido',
            'tipo.required' => 'El tipo de ajuste es requerido',
            'fecha.required' => 'La fecha es requerido',
            'detalle.required' => 'El detalle es requerido',
        ];
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $user_id = Auth::user()->id;

        // try {
        //     DB::beginTransaction();

        $ajuste = Ajuste::find($this->ajusteId);
        if (!$ajuste) {
            session()->flash('error', 'El ajuste no existe.');
            DB::rollBack();
            return;
        }

        $ajuste->sucursal = $this->sucursal;
        $ajuste->tipo = $this->tipo;
        $ajuste->fecha = $this->fecha;
        $ajuste->detalle = $this->detalle;
        $ajuste->user = $user_id;
        $ajuste->status = 'Pendiente';
        $ajuste->save();

        $tempAjustes = TempAjuste::where('user', $user_id)->get();

        foreach ($tempAjustes as $tempAjuste) {
            $inventario = Inventario::where('producto', $tempAjuste->producto)
                ->where('sucursal', $this->sucursal)
                ->first();

            $detalleAjuste = DetalleAjuste::where('ajuste', $ajuste->id)
                ->where('producto', $tempAjuste->producto)
                ->first();

            if ($detalleAjuste) {
                $cantidadAnterior = $detalleAjuste->cantidad;

                $detalleAjuste->cantidad = $tempAjuste->cantidad;
                $detalleAjuste->costo = $tempAjuste->costo;
                $detalleAjuste->total = $detalleAjuste->cantidad * $detalleAjuste->costo;
                $detalleAjuste->save();

                if ($this->tipo == 'Ingreso') {
                    $inventario->existencia -= $cantidadAnterior;
                    $inventario->existencia += $tempAjuste->cantidad;
                } else {
                    $inventario->existencia += $cantidadAnterior;
                    $inventario->existencia -= $detalleAjuste->cantidad;
                }
            } else {
                $detalleAjuste = DetalleAjuste::create([
                    'ajuste' => $ajuste->id,
                    'producto' => $tempAjuste->producto,
                    'inventario' => $inventario->id,
                    'unidad' => $tempAjuste->medida,
                    'cantidad' => $tempAjuste->cantidad,
                    'costo' => $tempAjuste->costo,
                    'total' => $tempAjuste->total,
                ]);

                if ($this->tipo == 'Ingreso') {
                    $inventario->existencia += $tempAjuste->cantidad;
                } else {
                    $inventario->existencia -= $tempAjuste->cantidad;
                }
            }

            $inventario->save();

            $ultimoKardex = Kardex::where('producto', $detalleAjuste->producto)
                ->where('inventario', $inventario->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($this->tipo == 'Ingreso') {
                $saldo = $inventario->existencia;
                $saldot = $ultimoKardex->saldototal + ($tempAjuste->costo * $tempAjuste->cantidad);

                if ($cantidadAnterior > $tempAjuste->cantidad) {
                    $saldot = $ultimoKardex->saldototal - ($tempAjuste->cantidad * $tempAjuste->costo);
                } else {
                    $saldot = $ultimoKardex->saldototal + ($tempAjuste->cantidad * $tempAjuste->costo);
                }

                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => $this->sucursal,
                    'producto' => $detalleAjuste->producto,
                    'inventario' => $inventario->id,
                    'descripcion' => 'Ingreso por Ajuste',
                    'fecha' => date('Y-m-d'),
                    'hora' => date('H:i:s'),
                    'ingreso' => $tempAjuste->cantidad,
                    'totalingreso' => $tempAjuste->costo * $tempAjuste->cantidad,
                    'egreso' => 0.00,
                    'totalegreso' => 0.00,
                    'costoUmovimiento' => $ultimoKardex->costoUnitario,
                    'costoUnitario' => $ultimoKardex->costoUnitario,
                    'saldo' => $saldo,
                    'saldototal' => $saldot,
                ]);
            } else {
                $saldo = $inventario->existencia;
                $saldot = $ultimoKardex->saldototal - ($tempAjuste->costo * $tempAjuste->cantidad);

                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => $this->sucursal,
                    'producto' => $detalleAjuste->producto,
                    'inventario' => $inventario->id,
                    'descripcion' => 'Egreso por Ajuste',
                    'fecha' => date('Y-m-d'),
                    'hora' => date('H:i:s'),
                    'ingreso' => 0.00,
                    'totalingreso' => 0.00,
                    'egreso' => $tempAjuste->cantidad,
                    'totalegreso' => $tempAjuste->costo * $tempAjuste->cantidad,
                    'costoUmovimiento' => $ultimoKardex->costoUnitario,
                    'costoUnitario' => $ultimoKardex->costoUnitario,
                    'saldo' => $saldo,
                    'saldototal' => $saldot,
                ]);
            }
        }

        TempAjuste::where('user', $user_id)->delete();

        //DB::commit();

        $this->dispatch('noty', msg: 'Ajuste actualizado con éxito');
        $this->ResetInt();
        return redirect()->route('ajustes');

        // } catch (\Exception $e) {
        //     // Revertir la transacción en caso de error
        //     DB::rollBack();
        //     $this->dispatch('noty-error', ['msg' => 'Error al actualizar el ajuste: ' . $e->getMessage()]);
        // }
    }

    public function Limpiar()
    {
        $user = Auth::user()->id;

        DB::table('temp_ajustes')->where('user', $user)->delete();

        return redirect()->route('ajustes');
    }



    public function ResetInt()
    {
        $this->sucursal = '';
        $this->tipo = '';
        $this->fecha = '';
        $this->detalle = '';
        $this->search = '';
        $this->resetValidation();
    }
}
