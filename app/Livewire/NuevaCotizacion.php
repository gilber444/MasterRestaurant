<?php

namespace App\Livewire;

use App\Models\Cotizaciones;
use App\Models\DetalleCotizacion;
use App\Models\Producto;
use App\Models\ProductoCategoria;
use App\Models\ProductosMarca;
use App\Models\ProductoUnidadMedida;
use App\Models\Proveedores;
use App\Models\tempCotizacion;
use App\Models\UnidadMedida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class NuevaCotizacion extends Component
{
    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName,
        $estado, $fecha, $pagination = 10, $productoSelectID, $productoSelectName, $cant = [],
        $proveedor, $observaciones, $numero;

    public $cotizacion, $producto, $unidad, $cantidad, $user;

    //productos
    public $codigoBarra, $valor, $status, $mensajeError, $costoS1, $codigo_barra,
        $product, $categoria, $marca, $unidad_medida, $unidad_medida_mh, $image, $presentacion, $imageChange, $allImages = [], $csiva, $civa;

    public function mount()
    {
        $this->pageTitle = 'Nuevo';
        $this->componentName = 'Cotizacion';

        $this->Carrito();
    }
    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.compras.nueva_cotizacion', [
            'productos' => $this->Allproductos(),
            'items' => tempCotizacion::where('user', $user_id)->get(),
            'proveedores' => Proveedores::orderBy('nombre', 'asc')->get(),

            //Agregar producto
            'unidades' => $this->UMexterno(),
            'unidadesInterno' => $this->UMinterno(),
            'categorias' => $this->Categorias(),
            'marcas' => $this->Marcas(),
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
        $tmp = tempCotizacion::where('user', $user_id)
            ->where('producto', $id)
            ->first();

        if ($tmp) {

            if ($tmp->producto != $id) {
                $createTemp = tempCotizacion::create([
                    'codigo' => $query->codigo_barra,
                    'producto' => $query->id,
                    'medida' => $query->unidad_medida,
                    'nombre' => $query->producto,
                    'cantidad' => 1,
                    'user' => $user_id,
                ]);
            } else {
                $tmp->cantidad = $tmp->cantidad + 1;
                $tmp->save();
            }
        } else {
            $createTemp = tempCotizacion::create([
                'codigo' => $query->codigo_barra,
                'producto' => $query->id,
                'medida' => $query->unidad_medida,
                'nombre' => $query->producto,
                'cantidad' => 1,
                'user' => $user_id,
            ]);
        }
        $this->Carrito();
    }

    public function Carrito()
    {
        $user_id = Auth::user()->id;
        $items = tempCotizacion::where('user', $user_id)->get();

        foreach ($items as $item) {
            $this->cant[$item->id] = number_format($item->cantidad, 2, '.', '');
        }
    }

    public function deleteItem($id)
    {
        $item = tempCotizacion::find($id);
        $item->delete();
        $this->Carrito();
    }

    public function updateCantidad($id)
    {
        $item = tempCotizacion::find($id);

        $cantidad = floatval($this->cant[$item->id]);
        if ($cantidad == 0 || $cantidad == '') {
            $item->cantidad = 1;
            $item->save();
        } else {
            $item->cantidad = $cantidad;
            $item->save();
        }
        $this->Carrito();
    }

    protected function rules()
    {
        $rules = [
            'proveedor' => 'required',
            'fecha' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'proveedor.required' => 'El nombre del proveedor es requerido',
            'factura.required' => 'La fecha es requerida',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());
    
        $user_id = Auth::user()->id;
        $items = tempCotizacion::where('user', $user_id)->get();
    
        if ($items->isEmpty()) {
            session()->flash('error', 'No hay productos para procesar.');
            return;
        }
    
        try {    
            $ultimoNumeroCompra = Cotizaciones::orderBy('numero', 'desc')->select('numero')->first();
            $nuevoNumeroCompra = $ultimoNumeroCompra ? ($ultimoNumeroCompra->numero + 1) : 1;

    
            $cotizacion = Cotizaciones::create([
                'numero' => $nuevoNumeroCompra,
                'fecha' => $this->fecha,
                'proveedor' => $this->proveedor,
                'observaciones' => $this->observaciones,
                'user' => $user_id,
                'estado' => 'Pendiente',
            ]);
    
            foreach ($items as $item) {    
                DetalleCotizacion::create([
                    'cotizacion' => $cotizacion->id,
                    'producto' => $item->producto,
                    'medida' => $item->medida,
                    'cantidad' => number_format($item->cantidad,2),
                ]);
            }
    
            tempCotizacion::where('user', $user_id)->delete();
    
            DB::commit();
    
            $this->dispatch('noty', msg: 'Cotizacion guardada con éxito');
            $this->ResetInt();
            return redirect()->route('cotizaciones');
        } catch (\Exception $e) {
            DB::rollBack();
    
            $this->dispatch('noty-error', 'Error al guardar la Cotizacion: ' . $e->getMessage());
        }
    }

    public function Limpiar()
    {

        $user = Auth::user()->id;

        DB::table('temp_cotizacions')->where('user', $user)->delete();

        return redirect()->route('cotizaciones');
    }

    public function ResetInt()
    {
        $this->numero = '';
        $this->fecha = '';
        $this->proveedor = '';
        $this->observaciones = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
