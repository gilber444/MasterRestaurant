<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Compra;
use App\Models\CondicionOperacion;
use App\Models\Departamento;
use App\Models\DetalleCompra;
use App\Models\Distritos;
use App\Models\Factura;
use App\Models\Inventario;
use App\Models\Municipio;
use App\Models\Producto;
use App\Models\Proveedores;
use App\Models\Sucursales;
use App\Models\tempCompra;
use App\Models\TipoPersona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarCompras extends Component
{
    public $search, $compra, $records, $compraId, $factura, $correlativo, $serie, $condicionPago, $vendedor, $fechaPago, $fechaCompra, $sucursal, $sucursales,
        $proveedor, $observaciones, $pagination = 10,
        $productos = [], $cant = [], $cost = [], $selected_id;

    //Agregar proveedor
    public  $nombre, $razon_social, $tipoPersona, $departamento, $municipio, $distrito, $actividad, $direccion, $telefono, $correo, $registro, $nit, $tipoPersonas, $actividadEconomica, $departamentos, $municipios, $distritos, $tipo;

    public function mount($selected_id)
    {
        $this->tipoPersonas = TipoPersona::all();
        $this->actividadEconomica = ActividadEconomica::all();
        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
        $this->sucursales = Sucursales::all();

        $this->selected_id = $selected_id;
        $compra = Compra::find($this->selected_id);

        $this->proveedor = $compra->proveedor;
        $this->sucursal = $compra->sucursal;
        $this->vendedor = $compra->vendedor;
        $this->fechaCompra = $compra->fechaCompra;
        $this->fechaPago = $compra->fechaPago;
        $this->condicionPago = $compra->condicionPago;
        $this->observaciones = $compra->observaciones;
        $this->factura = $compra->factura;
        $this->correlativo = $compra->correlativo;
        $this->serie = $compra->serie;
        $this->compraId = $compra->id;

        $detalleCompra = DetalleCompra::where('compra', $selected_id)->get();

        foreach ($detalleCompra as $det) {
            $producto = Producto::where('id', $det->producto)->first();

            $tempProduct = tempCompra::where('producto', $producto->id)
                ->where('user', $compra->user)
                ->first();

            if (!$tempProduct) {
                tempCompra::create([
                    'codigo' => $producto->codigo_barra,
                    'producto' => $producto->id,
                    'medida' => $producto->unidad_medida,
                    'nombre' => $producto->producto,
                    'cantidad' => $det->cantidad,
                    'costo' => $producto->csiva,
                    'total' => $det->cantidad * $producto->csiva,
                    'user' => $compra->user,
                ]);
            }
        }

        $this->productos = $this->Allproductos();
        $this->Carrito();
    }


    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.compras.editar_compras', [
            'productos' => $this->Allproductos(),
            'proveedores' => Proveedores::orderBy('nombre', 'asc')->get(),
            'facturas' => Factura::orderBy('factura', 'asc')->get(),
            'Condicion' => CondicionOperacion::orderBy('valor', 'asc')->get(),
            'sucursales' => Sucursales::orderBy('nombre', 'asc')->get(),
            'items' => tempCompra::where('user', $user_id)->get(),

            //Agregar proveedor 
            'municipios' => Municipio::orderBy('municipio', 'asc')->get() ?? collect(),
            'departamentos' => Departamento::orderBy('departamento', 'asc')->get() ?? collect(),
            'distritos' => Distritos::orderBy('distrito', 'asc')->get() ?? collect(),
            'actividadEconomica' => ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect(),
            'tipoPersonas' => TipoPersona::orderBy('valor', 'asc')->get() ?? collect(),
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

        $productos = $query->paginate($this->pagination);

        return $productos->items();
    }

    #[On('Temporal')]
    public function Temporal($id)
    {
        $user_id = Auth::user()->id;
        $query = Producto::find($id);

        $tmp = tempCompra::where('user', $user_id)
            ->where('producto', $id)
            ->first();

        if ($tmp) {
            $tmp->cantidad += 1;
            $tmp->total = $tmp->cantidad * $tmp->costo;
            $tmp->save();
        } else {
            tempCompra::create([
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
        $items = tempCompra::where('user', $user_id)->get();

        foreach ($items as $item) {
            $this->cant[$item->id] = $item->cantidad;
            $this->cost[$item->id] = $item->costo;
        }
    }

    public function deleteItem($id)
    {
        $detalleCompra = DetalleCompra::find($id);

        if ($detalleCompra) {
            $detalleCompra->delete();

            tempCompra::where('producto', $detalleCompra->producto)
                ->where('user', Auth::user()->id)
                ->delete();
        } else {
            $tempCompra = tempCompra::where('id', $id)
                ->where('user', Auth::user()->id)
                ->first();

            if ($tempCompra) {
                $tempCompra->delete();
            }
        }

        $this->Carrito();
    }


    public function updateCantidad($id)
    {
        $item = tempCompra::find($id);

        $cantidad = floatval($this->cant[$item->id]);
        if ($cantidad == 0 || $cantidad == '') {
            $item->cantidad = 1;
            $item->total = floatval($item->costo);
            $item->save();
        } else {
            $item->cantidad = $cantidad;
            $item->total = $cantidad * floatval($item->costo);
            $item->save();
        }
        $this->Carrito();
    }

    public function updateCosto($id)
    {
        $item = tempCompra::find($id);
        $query = Producto::where('id', $item->producto)->first();

        $costo = floatval($this->cost[$item->id]);
        if ($costo == 0 || $costo == '') {
            $item->costo = $query->csiva;
            $item->total = $query->csiva * floatval($item->cantidad);
            $item->save();
        } else {
            $item->costo = $costo;
            $item->total = $costo * floatval($item->cantidad);
            $item->save();
        }

        $this->Carrito();
    }

    //Agregar Proveedor 
    protected function ruless()
    {
        $id = $this->selected_id ? $this->selected_id : null;
        $rules = [
            'nombre' => [
                'required',
                'min:2',
                Rule::unique('proveedores', 'nombre')->ignore($id),
            ],
            'razon_social' => [
                'required',
                'min:2',
                Rule::unique('proveedores', 'razon_social')->ignore($id),
            ],
            'tipoPersona' => 'required',
            'departamento' => 'required',
            'municipio' => 'required',
            'distrito' => 'required',
            'actividad' => 'required',
            'telefono' => "required|unique:proveedores,telefono,{$this->selected_id}|regex:/^\d{4}-\d{4}$/",
            'registro' => "required|unique:proveedores,registro,{$this->selected_id}|min:3",
            'nit' => [
                'required',
                Rule::unique('proveedores', 'nit')->ignore($id),
                'numeric',
                'regex:/^\d{14}$/',
            ],
            'tipo' => 'required',
        ];

        return $rules;
    }

    protected function messagess()
    {
        return [
            'nombre.required' => 'El Nombre del Proveedor es requerido',
            'nombre.unique' => 'El Nombre del Proveedor ya existe',
            'nombre.min' => 'El Nombre del Proveedor debe tener mas de 3 caracteres',
            'razon_social.required' => 'La Razon social del Proveedor es requerido',
            'razon_social.unique' => 'La Razon social del Proveedor ya existe',
            'razon_social.min' => 'La Razon social del Proveedor debe tener mas de 3 caracteres',
            'tipoPersona' => 'El tipo de persona es Requerido',
            'departamento' => 'El departamento es Requerido',
            'municipio' => 'El municipio es Requerido',
            'distrito' => 'El distrito es Requerido',
            'actividad' => 'La Actividad economica es requerida',
            'telefono.required' => 'El Numero de telefono es requerido',
            'telefono.unique' => 'El numero de telefono ya existe',
            'telefono.regex' => 'El formato del teléfono no es válido. Debe ser en formato "9999-9999".',
            'registro.required' => 'El Numero de registro es requerido',
            'registro.unique' => 'El Numero de registro ya existe',
            'registro.min' => 'El numero de registro debe tener mas de 3 caracteres',
            'nit.required' => 'El número de NIT es requerido',
            'nit.unique' => 'El número de NIT ya existe',
            'nit.digits' => 'El número de NIT debe tener exactamente 14 dígitos',
            'nit.numeric' => 'El número de NIT solo puede contener números',
            'tipo.required' => 'El tipo de proveedor es requerido',
        ];
    }

    public function StoreProveedor()
    {
        $this->validate($this->ruless(), $this->messagess());

        $pro = Proveedores::create([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
            'tipoPersona' => $this->tipoPersona,
            'departamento' => $this->departamento,
            'municipio' => $this->municipio,
            'distrito' => $this->distrito,
            'actividad' => $this->actividad,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'registro' => $this->registro,
            'nit' => $this->nit,
            'tipo' => $this->tipo,
        ]);

        $this->dispatch('noty', msg: 'Proveedor registrado con éxito');
        return redirect()->route('nueva_compra');
        $this->dispatch('close-modal');
        $this->ResetInt();
    }

    #[On('ResetProveedor')]
    public function ResetProveedor()
    {
        $this->nombre = '';
        $this->razon_social = '';
        $this->tipoPersona = '';
        $this->departamento = '';
        $this->municipio = '';
        $this->distrito = '';
        $this->actividad = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->correo = '';
        $this->registro = '';
        $this->nit = '';
        $this->tipo = '';
        $this->search = '';
        $this->resetValidation();
    }

    public function updateDepartamento()
    {
        $this->municipios = Municipio::where('departamento', $this->departamento)->get();
    }

    public function updateMunicipio()
    {
        $this->distritos = Distritos::where('municipio', $this->municipio)->get();
    }

    //compra
    protected function rules()
    {
        $rules = [
            'correlativo' => 'required',
            'serie' => 'required',
            'fechaCompra' => 'required',
            'fechaPago' => 'required',
            'condicionPago' => 'required',
            'proveedor' => 'required',
            'factura' => 'required',
            'sucursal' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'correlativo.required' => 'El correlativo es requerido',
            'serie.required' => 'Serie es requerido',
            'fechaCompra.required' => 'La fecha de la compra es requerida',
            'fechaPago.required' => 'La fecha de pago es requerida',
            'condicionPago.required' => 'La condición de pago es requerida',
            'proveedor.required' => 'El nombre del proveedor es requerido',
            'factura.required' => 'El tipo de factura es requerida',
            'sucursal.required' => 'La sucursal es requerida',
        ];
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $user_id = Auth::user()->id;

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            $compra = Compra::find($this->compraId);
            if (!$compra) {
                session()->flash('error', 'La compra no existe.');
                return;
            }

            // $sucursalAnterior = $compra->sucursal;

            // Si la sucursal cambió, ajustar el inventario
            // if ($sucursalAnterior != $this->sucursal) {
            //     $detCompra = DetalleCompra::where('compra', $this->compraId);

            //     Restar la cantidad de productos en la sucursal anterior
            //     foreach ($detCompra as $det) {
            //         $inventarioAnterior = Inventario::where('producto', $det->producto)
            //             ->where('sucursal', $sucursalAnterior)
            //             ->first();

            //         if ($inventarioAnterior) {
            //             $inventarioAnterior->existencia -= $det->cantidad;
            //             $inventarioAnterior->save();
            //         }
            //     }

            //     Sumar la cantidad de productos en la nueva sucursal
            //     foreach ($detCompra as $det) {
            //         $inventarioNuevo = Inventario::where('producto', $det->producto)
            //             ->where('sucursal', $this->sucursal)
            //             ->first();

            //         if ($inventarioNuevo) {
            //             $inventarioNuevo->existencia += $det->cantidad;
            //             $inventarioNuevo->save();
            //         }
            //     }
            // }

            // Actualizar los datos de la compra
            $compra->proveedor = $this->proveedor;
            $compra->vendedor = $this->vendedor;
            $compra->fechaCompra = $this->fechaCompra;

            $this->updateFecha();

            $compra->fechaPago = $this->fechaPago;

            $condi = CondicionOperacion::find($this->condicionPago);
            if ($condi->valor == 'Contado') {
                $compra->estado = 'Cancelado';
            } else {
                $compra->estado = 'Pendiente';
            }

            $compra->factura = $this->factura;
            $compra->correlativo = $this->correlativo;
            $compra->sucursal = $this->sucursal;
            $compra->serie = $this->serie;
            $compra->condicionPago = $this->condicionPago;
            $compra->observaciones = $this->observaciones;
            $compra->user = $user_id;

            $compra->save();

            // Limpiar temporal
            tempCompra::where('user', $user_id)->delete();

            // Confirmar la transacción
            DB::commit();

            $this->dispatch('noty', msg: 'Compra actualizada con éxito');
            $this->ResetInt();
            return redirect()->route('compras');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();
            $this->dispatch('noty-error', msg: 'Error al actualizar la compra: ' . $e->getMessage());
        }
    }

    public function updateFecha()
    {
        // Actualizar la fecha de pago según la condición de pago
        if ($this->condicionPago) {
            $condi = CondicionOperacion::find($this->condicionPago);

            if ($condi) {
                if ($condi->valor == 'Contado') {
                    $this->fechaPago = Carbon::now()->format('Y-m-d'); // Establecer la fecha de hoy en formato d-m-Y
                } else {
                    $this->fechaPago = $this->fechaPago; // Dejar vacía si no es contado
                }
            }
        }
    }



    public function Limpiar()
    {
        $user = Auth::user()->id;

        DB::table('temp_compras')->where('user', $user)->delete();

        return redirect()->route('compras');
    }

    public function ResetInt()
    {
        $this->proveedor = '';
        $this->vendedor = '';
        $this->correlativo = '';
        $this->factura = '';
        $this->fechaCompra = '';
        $this->fechaPago = '';
        $this->serie = '';
        $this->condicionPago = '';
        $this->sucursal = '';
        $this->observaciones = '';
        $this->search = '';
        $this->resetValidation();
    }
}
