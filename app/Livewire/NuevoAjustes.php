<?php

namespace App\Livewire;

use App\Models\Ajuste;
use App\Models\DetalleAjuste;
use App\Models\Inventario;
use App\Models\kardex;
use App\Models\Producto;
use App\Models\Sucursales;
use App\Models\TempAjuste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class NuevoAjustes extends Component
{
    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo,
        $valor, $status, $sucursal, $tipo, $detalle, $fecha, $pagination = 10, $productoSelectID, $productoSelectName, $cant = [];

    public $ajuste, $producto, $inventario, $unidad, $cantidad, $costo, $total, $user;

    public function mount()
    {
        $this->Carrito();
    }
    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.ajustes.nuevo_ajustes', [
            'productos' => $this->Allproductos(),
            'sucursales' => $this->AllSucursales(),
            'items' => TempAjuste::where('user', $user_id)->get()
        ]);
    }

    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Producto::where('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('producto', 'like', "%{$this->search}%")
                ->orderBy('producto', 'asc');
        } else {
            $query = Producto::where('presentacion', '1')
                ->with('RunidadMedidaMH')
                ->orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    public function AllSucursales()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Sucursales::where('nombre', 'like', "%{$this->search}%")
                ->orWhere('nombre', 'like', "%{$this->search}%")
                ->orderBy('nombre', 'asc');
        } else {
            $query = Sucursales::orderBy('nombre', 'desc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    #[On('Temporal')]
    public function Temporal($id){
        $user_id = Auth::user()->id;
        $query = Producto::find($id);
        $tmp = TempAjuste::where('user', $user_id)
        ->where('producto', $id)
        ->first();

        if ($tmp) {    
            
            if($tmp->producto != $id){
                $createTemp = TempAjuste::create([
                    'codigo'=> $query->codigo_barra,
                    'producto' => $query->id,
                    'medida' => $query->unidad_medida,       
                    'nombre' => $query->producto,
                    'cantidad' => 1,
                    'costo' => $query->csiva,
                    'total' => $query->csiva,
                    'user' => $user_id,
                ]);
            }
            else{
                $tmp->cantidad = $tmp->cantidad + 1;
                $tmp->total = ($tmp->cantidad + 1) * $tmp->costo;
                $tmp->save();
            }
        }
        else{
            $createTemp = TempAjuste::create([
                'codigo'=> $query->codigo_barra,
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
        $item = TempAjuste::find($id);
        $item->delete();
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

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $user_id = Auth::user()->id;
        $items = TempAjuste::where('user', $user_id)->get();

        if ($items->isEmpty()) {
            session()->flash('error', 'No hay productos para procesar.');
            return;
        }

        // try {
        //     DB::beginTransaction();

            $ajuste = Ajuste::create([
                'sucursal' => $this->sucursal,
                'tipo' => $this->tipo,
                'fecha' => $this->fecha,
                'detalle' => $this->detalle,
                'user' => $user_id,
                'status' => 'Pendiente',
            ]);

            foreach ($items as $item) {
                $inventario = Inventario::where('producto', $item->producto)->where('sucursal', $this->sucursal)->first();

                DetalleAjuste::create([
                    'ajuste' => $ajuste->id,
                    'producto' => $item->producto,
                    'inventario' => $inventario->id,
                    'unidad' => $item->medida,
                    'cantidad' => $item->cantidad,
                    'costo' => $item->costo,
                    'total' => $item->total,
                ]);

                if ($this->tipo == 'Ingreso') {
                    $nuevaExistencia = $inventario->existencia + $item->cantidad;
                    $inventario->existencia = $nuevaExistencia;
                    $inventario->save();
                
                    $ultimoKardex = Kardex::where('producto', $item->producto)
                        ->where('inventario', $inventario->id)->orderBy('id', 'desc')->first();
                
                    if ($ultimoKardex) {
                        $saldo = $nuevaExistencia;
                        $saldot = $ultimoKardex->saldototal + ($item->costo * $item->cantidad);
                    } else {
                        $saldo = $nuevaExistencia;
                        $saldot = $item->costo * $item->cantidad;
                    }
                
                    Kardex::create([
                        'empresa' => Auth::user()->empresa,
                        'sucursal' => $this->sucursal,
                        'producto' => $item->producto,
                        'inventario' => $inventario->id,
                        'descripcion' => 'Ingreso por Ajuste',
                        'fecha' => date('Y-m-d'),
                        'hora' => date('H:i:s'),
                        'ingreso' => $item->cantidad,
                        'totalingreso' => $item->costo * $item->cantidad,
                        'egreso' => 0.00,
                        'totalegreso' => 0.00,
                        'costoUmovimiento' => $ultimoKardex->costoUnitario,
                        'costoUnitario' => $ultimoKardex->costoUnitario,
                        'saldo' => $saldo,
                        'saldototal' => $saldot,
                    ]);
                } else {
                    $nuevaExistencia = $inventario->existencia - $item->cantidad;
                    $inventario->existencia = $nuevaExistencia;
                    $inventario->save();
                
                    $ultimoKardex = Kardex::where('producto', $item->producto)
                    ->where('inventario', $inventario->id)->first();
                
                    if ($ultimoKardex) {
                        $saldo = $nuevaExistencia;
                        $saldot = $ultimoKardex->saldototal - ($item->costo * $item->cantidad);
                    } else {
                        $saldo = 0.0;
                        $saldot = 0.0;
                    }
                
                    Kardex::create([
                        'empresa' => Auth::user()->empresa,
                        'sucursal' => $this->sucursal,
                        'producto' => $item->producto,
                        'inventario' => $inventario->id,
                        'descripcion' => 'Egreso por Ajuste',
                        'fecha' => date('Y-m-d'),
                        'hora' => date('H:i:s'),
                        'ingreso' => 0.00,
                        'totalingreso' => 0.00,
                        'egreso' => $item->cantidad,
                        'totalegreso' => $item->costo * $item->cantidad,
                        'costoUmovimiento' => $ultimoKardex->costoUnitario,
                        'costoUnitario' => $ultimoKardex->costoUnitario,
                        'saldo' => $saldo,
                        'saldototal' => $saldot,
                    ]);
                }
            }

            TempAjuste::where('user', $user_id)->delete();

            //DB::commit();
            $this->dispatch('noty', msg: 'Ajuste guardado con exito');
            $this->ResetInt();
            return redirect()->route('ajustes');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     $this->dispatch('noty-error', 'Error al crear el ajuste: ' . $e->getMessage());
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
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
