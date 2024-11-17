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
use App\Models\kardex;
use App\Models\Municipio;
use App\Models\Producto;
use App\Models\ProductoCategoria;
use App\Models\ProductosMarca;
use App\Models\ProductoUnidadMedida;
use App\Models\Proveedores;
use App\Models\Sucursales;
use App\Models\tempCompra;
use App\Models\TipoEstablecimiento;
use App\Models\TipoPersona;
use App\Models\UnidadMedida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\Rule;

class NuevaCompra extends Component
{
    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo,
        $estado, $fechaCompra, $pagination = 10, $productoSelectID, $productoSelectName, $cant = [], $cost = [],
        $factura, $correlativo, $serie, $condicionPago, $vendedor, $fechaPago,
        $proveedor, $observaciones, $sucursal, $sucursales;

    public $compra, $producto, $inventario, $unidad, $cantidad, $costo, $total, $user;

    //productos
    public $codigoBarra, $valor, $status, $mensajeError, $costoS1, $codigo_barra,
        $product, $categoria, $marca, $unidad_medida, $unidad_medida_mh, $image, $presentacion, $imageChange, $allImages = [], $csiva, $civa;

    //Agregar proveedor
    public  $nombre, $razon_social, $tipoPersona, $departamento, $municipio, $distrito, $actividad, $direccion, $telefono, $correo, $registro, $nit, $tipoPersonas, $actividadEconomica, $departamentos, $municipios, $distritos, $tipo;

    public function mount()
    {
        $this->pageTitle = 'Nuevo';
        $this->componentName = 'Producto';
        $this->tipoPersonas = TipoPersona::all();
        $this->actividadEconomica = ActividadEconomica::all();
        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
        $this->sucursales = Sucursales::all();
        $this->Carrito();
    }
    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.compras.nueva_compra', [
            'productos' => $this->Allproductos(),
            'proveedores' => Proveedores::orderBy('nombre', 'asc')->get(),
            'facturas' => Factura::orderBy('factura', 'asc')->get(),
            'Condicion' => CondicionOperacion::orderBy('valor', 'asc')->get(),
            'sucursales' => Sucursales::orderBy('nombre', 'asc')->get(),
            'items' => tempCompra::where('user', $user_id)->get(),

            //Agregar producto
            'unidades' => $this->UMexterno(),
            'unidadesInterno' => $this->UMinterno(),
            'categorias' => $this->Categorias(),
            'marcas' => $this->Marcas(),

            //Agregar proveedor 
            'municipios' => Municipio::orderBy('municipio', 'asc')->get() ?? collect(),
            'departamentos' => Departamento::orderBy('departamento', 'asc')->get() ?? collect(),
            'distritos' => Distritos::orderBy('distrito', 'asc')->get() ?? collect(),
            'actividadEconomica' => ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect(),
            'tipoPersonas' => TipoPersona::orderBy('valor', 'asc')->get() ?? collect(),
        ]);
    }

    //Agregar producto desde nueva compra
    public function UMexterno()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = UnidadMedida::where('status', 'activo')
                ->orderBy('codigo', 'asc');
        } else {
            $query = UnidadMedida::where('status', 'activo')
                ->orderBy('codigo', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    public function UMinterno()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductoUnidadMedida::where('estado', '1')
                ->orderBy('id', 'asc');
        } else {
            $query = ProductoUnidadMedida::where('estado', '1')
                ->orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    public function Categorias()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductoCategoria::where('estado', '1')
                ->orderBy('id', 'asc');
        } else {
            $query = ProductoCategoria::where('estado', '1')
                ->orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    public function Marcas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductosMarca::where('estado', '1')
                ->orderBy('id', 'asc');
        } else {
            $query = ProductosMarca::where('estado', '1')
                ->orderBy('id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    protected function rule()
    {
        $rules = [
            'codigo_barra' => "nullable|unique:productos,codigo_barra,{$this->selected_id}",
            'product' => "required|min:3",
            'categoria' => "required|min:1",
            'marca' => "required|min:1",
            'unidad_medida' => "required|min:1",
            'unidad_medida_mh' => "required|min:1",
        ];

        return $rules;
    }

    protected function message()
    {
        return [
            'codigo_barra.unique' => 'Ya existe el codigo_barra',
            'product.required' => 'El nombre del producto es requerido',
            'product.unique' => 'Ya existe el nombre del producto',
            'product.min' => 'El producto debe tener mas de 1 caracteres',
            'marca.required' => 'El nombre de la marca es requerido',
            'marca.unique' => 'Ya existe el nombre de la marca',
            'marca.min' => 'El nombre de la marca debe tener mas de 1 caracteres',
            'civa.required' => 'El precio de la civa es requerido',
            'civa.min' => 'El precio de la civa debe tener mas de 1 caracteres',
            'csiva.required' => 'El precio de la csiva es requerido',
            'csiva.min' => 'El precio de la csiva debe tener mas de 1 caracteres',
        ];
    }

    public function StoreProducto()
    {
        $this->validate($this->rule(), $this->message());

        DB::beginTransaction();
        try {
            $createProducto = Producto::create([
                'codigo_barra' => empty($this->codigo_barra) ? null : $this->codigo_barra,
                'producto' => $this->product,
                'categoria' => $this->categoria,
                'marca' => $this->marca,
                'unidad_medida' => $this->unidad_medida,
                'unidad_medida_mh' => $this->unidad_medida_mh,
                'presentacion' => $this->presentacion,
                'csiva' => $this->csiva,
                'civa' => $this->csiva * 1.13,
            ]);

            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/productos', $customFileName);
                $createProducto->image = $customFileName;
                $createProducto->save();
            }

            $sucursales = Sucursales::with('Rempresa')->get();

            foreach ($sucursales as $s) {
                $inventario = Inventario::create([
                    'empresa' => $s->Rempresa->id,
                    'sucursal' => $s->id,
                    'producto' => $createProducto->id,
                    'existencia' => '0.0',
                ]);

                $kardex = kardex::create([
                    'empresa' => $s->Rempresa->id,
                    'sucursal' => $s->id,
                    'producto' => $createProducto->id,
                    'inventario' => $inventario->id,
                    'fecha' => date('Y-m-d'),
                    'hora' => date('H:i:s'),
                    'descripcion' => 'Ingreso de nuevo producto a inventario',
                    'ingreso' => '0.0',
                    'totalingreso' => '0.0',
                    'egreso' => '0.0',
                    'totalegreso' => '0.0',
                    'costoUmovimiento' => 0.0,
                    'costoUnitario' => 0.0,
                    'saldo' => '0.0',
                    'saldototal' => '0.0',
                ]);
            }

            DB::commit();
            $this->dispatch('noty', msg: 'Producto registrado con exito');
            return redirect()->route('nueva_compra');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('noty-error', msg: 'Error al registrar producto' . $th);
        }
    }

    #[On('ResetProducto')]
    public function ResetProducto()
    {
        $this->codigo_barra = '';
        $this->producto = '';
        $this->categoria = 0;
        $this->marca = '';
        $this->unidad_medida = 0;
        $this->unidad_medida_mh = 0;
        $this->image = '';
        $this->imageChange = '';
        $this->civa = 0;
        $this->csiva = 0;
        $this->presentacion = '';
        $this->resetValidation();
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
                'regex:/^\d{14}$/', // Acepta solo 8 o 14 dígitos
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

    //Agregar nueva compra
    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Producto::where('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('producto', 'like', "%{$this->search}%")
                ->orderBy('producto', 'asc');
        } else {
            $query = Producto::orderBy('producto', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
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

            if ($tmp->producto != $id) {
                $createTemp = tempCompra::create([
                    'codigo' => $query->codigo_barra,
                    'producto' => $query->id,
                    'medida' => $query->unidad_medida,
                    'nombre' => $query->producto,
                    'cantidad' => 1,
                    'costo' => $query->csiva,
                    'total' => $query->csiva,
                    'user' => $user_id,
                ]);
            } else {
                $tmp->cantidad = $tmp->cantidad + 1;
                $tmp->total = ($tmp->cantidad + 1) * $tmp->costo;
                $tmp->save();
            }
        } else {
            $createTemp = tempCompra::create([
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
        $item = tempCompra::find($id);
        $item->delete();
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

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());
    
        $user_id = Auth::user()->id;
        $items = TempCompra::where('user', $user_id)->get();
    
        if ($items->isEmpty()) {
            session()->flash('error', 'No hay productos para procesar.');
            return;
        }
    
        $saldo = 0;
        $total = 0;
    
        try {
            foreach ($items as $item) {
                $saldo += $item->total;
                $total += $item->total;
            }
    
            $ultimoNumeroCompra = Compra::orderBy('numero', 'desc')->select('numero')->first();
            $nuevoNumeroCompra = $ultimoNumeroCompra ? ($ultimoNumeroCompra->numero + 1) : 1;
    
            $condi = CondicionOperacion::find($this->condicionPago);
    
            $estado = ($condi && $condi->valor === 'Contado') ? 'Cancelado' : 'Pendiente';
    
            $compra = Compra::create([
                'numero' => $nuevoNumeroCompra,
                'factura' => $this->factura,
                'correlativo' => $this->correlativo,
                'serie' => $this->serie,
                'fechaCompra' => $this->fechaCompra,
                'saldo' => $saldo,
                'total' => $total,
                'condicionPago' => $this->condicionPago,
                'vendedor' => $this->vendedor,
                'fechaPago' =>  $this->condicionPago == 'Contado' ? now()->toDateString() : $this->fechaPago,
                'proveedor' => $this->proveedor,
                'sucursal' => $this->sucursal,
                'observaciones' => $this->observaciones,
                'user' => $user_id,
                'estado' => $estado,
            ]);
    
            foreach ($items as $item) {
                //$establecimiento = TipoEstablecimiento::where('valor', 'Bodega')->first();
                //$bodega = Sucursales::where('tipo', $establecimiento->id)->first();
                $inventario = Inventario::where('producto', $item->producto)->where('sucursal', $this->sucursal)->first();
    
                $producto = Producto::where('id', $item->producto)->first();
                $producto->csiva = $item->costo;
                $producto->civa = $item->costo * 1.13;
                $producto->save();
    
                DetalleCompra::create([
                    'compra' => $compra->id,
                    'producto' => $item->producto,
                    'inventario' => $inventario->id,
                    'medida' => $item->medida,
                    'cantidad' => $item->cantidad,
                    'costo' => $item->costo,
                    'total' => $item->total,
                ]);
    
                $nuevaExistencia = $inventario->existencia + $item->cantidad;
                $inventario->existencia = $nuevaExistencia;
                $inventario->save();
    
                $ultimoKardex = Kardex::where('producto', $item->producto)
                    ->where('inventario', $inventario->id)->orderBy('id', 'desc')->first();
    
                if ($ultimoKardex) {
                    $saldo = $nuevaExistencia;
                    $saldot = $ultimoKardex->saldototal + ($item->costo * $item->cantidad);
                    $costoUnitario = $saldot / $saldo;
                } else {
                    $saldo = $nuevaExistencia;
                    $saldot = $item->costo * $item->cantidad;
                }
    
                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => $this->sucursal,
                    'producto' => $item->producto,
                    'inventario' => $inventario->id,
                    'descripcion' => 'Compra',
                    'fecha' => date('Y-m-d'),
                    'hora' => date('H:i:s'),
                    'ingreso' => $item->cantidad,
                    'totalingreso' => $item->costo * $item->cantidad,
                    'egreso' => 0.00,
                    'totalegreso' => 0.00,
                    'costoUmovimiento' => $item->costo,
                    'costoUnitario' => $costoUnitario,
                    'saldo' => $saldo,
                    'saldototal' => $saldot,
                ]);
            }
    
            TempCompra::where('user', $user_id)->delete();
    
            DB::commit();
    
            $this->dispatch('noty', msg: 'Compra guardada con éxito');
            $this->ResetInt();
            return redirect()->route('compras');
        } catch (\Exception $e) {
            DB::rollBack();
    
            $this->dispatch('noty-error', 'Error al guardar la compra: ' . $e->getMessage());
        }
    }
    

    public function storeFecha()
    {
        if ($this->condicionPago) {
            $condi = CondicionOperacion::find($this->condicionPago);

            if ($condi) {
                if ($condi->valor === 'Contado') {
                    $this->fechaPago = now()->toDateString();
                } else {
                    $this->fechaPago = $this->fechaPago;
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
        $this->factura = '';
        $this->correlativo = '';
        $this->serie = '';
        $this->fechaCompra = '';
        $this->condicionPago = '';
        $this->vendedor = '';
        $this->fechaPago = '';
        $this->proveedor = '';
        $this->sucursal = '';
        $this->observaciones = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
