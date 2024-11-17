<?php

namespace App\Livewire;


use App\Models\UnidadMedida;
use App\Models\ProductoCategoria;
use App\Models\Producto;
use App\Models\ProductoUnidadMedida;
use App\Models\ProductosMarca;
use App\Models\Sucursales as ModelSucursales;
use App\Models\Inventario;
use App\Models\kardex;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo,
    $valor, $status, $pagination = 10, $mensajeError,$costoS1, $activateNewSection, $codigo_barra,
    $producto, $categoria, $marca, $unidad_medida, $unidad_medida_mh, $image,$presentacion,$imageChange, $allImages = [], $csiva, $civa;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Producto';
    }
    public function render()
    {
        //dd($this->Allproductos());
        return view('livewire.productos.productos',[
            'unidades' => $this->UMexterno(),
            'unidadesInterno' => $this->UMinterno(),
            'categorias' => $this->Categorias(),
            'productos' => $this->Allproductos(),
            'marcas'=> $this->Marcas()
        ]);
    }

    // consulta de Unidades de medida Ministerio de Hacienda
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

    // consulta los productos ingresados en la base de datos
    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Producto::where('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('producto', 'like', "%{$this->search}%")
                ->orderBy('codigo_barra', 'asc');

        } else {
            $query = Producto::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'codigo_barra' => "nullable|unique:productos,codigo_barra,{$this->selected_id}",
            'producto' => "required|min:3",
            'categoria' => "required|min:1",
            'marca' => "required|min:1",
            'unidad_medida' => "required|min:1",
            'unidad_medida_mh' => "required|min:1",
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'codigo_barra.unique' => 'Ya existe el codigo_barra',
            'producto.required' => 'El nombre del producto es requerido',
            'producto.unique' => 'Ya existe el nombre del producto',
            'producto.min'=> 'El producto debe tener mas de 1 caracteres',
            'marca.required' => 'El nombre de la marca es requerido',
            'marca.unique' => 'Ya existe el nombre de la marca',
            'marca.min'=> 'El nombre de la marca debe tener mas de 1 caracteres',
            'civa.required' => 'El precio de la civa es requerido',
            'civa.min'=> 'El precio de la civa debe tener mas de 1 caracteres',
            'csiva.required' => 'El precio de la csiva es requerido',
            'csiva.min'=> 'El precio de la csiva debe tener mas de 1 caracteres',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        DB::beginTransaction();
        try {
            $createProducto = Producto::create([
                'codigo_barra' => empty($this->codigo_barra) ? null : $this->codigo_barra,
                'producto' => $this->producto,
                'categoria' => $this->categoria,
                'marca' => $this->marca,
                'unidad_medida' => $this->unidad_medida,
                'unidad_medida_mh' => $this->unidad_medida_mh,
                'presentacion' => $this->presentacion,
                'civa' => $this->civa,
                'csiva' => $this->csiva,
            ]);

            if($this->image)
            {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/productos', $customFileName);
                $createProducto->image = $customFileName;
                $createProducto->save();
            }

            $sucursales = ModelSucursales::with('Rempresa')->get();

            foreach($sucursales as $s){
                $inventario = Inventario::create([
                    'empresa'=> $s->Rempresa->id,
                    'sucursal'=>$s->id,
                    'producto'=>$createProducto->id,
                    'existencia'=>'0.0',
                ]);

                $kardex = kardex::create([
                    'empresa'=> $s->Rempresa->id,
                    'sucursal'=>$s->id,
                    'producto'=>$createProducto->id,
                    'inventario'=>$inventario->id,
                    'fecha'=>date('Y-m-d'),
                    'hora'=>date('H:i:s'),
                    'descripcion'=>'Ingreso de nuevo producto a inventario',
                    'ingreso'=>'0.0',
                    'totalingreso'=>'0.0',
                    'egreso'=>'0.0',
                    'totalegreso'=>'0.0',
                    'saldo'=>'0.0',
                    'saldototal'=>'0.0',
                ]);
            }

            DB::commit();
            $this->Edit($createProducto->id, true);
            $this->dispatch('noty', msg: 'Producto registrado con exito');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('noty-error', msg: 'Error al registrar producto'. $th);
        }

    }

    public function Edit($id, $activateNewSection = true)
    {
        $selectProducto = Producto::find($id);
        $this->codigo_barra = $selectProducto->codigo_barra;
        $this->producto = $selectProducto->producto;
        $this->categoria = $selectProducto->categoria;
        $this->marca = $selectProducto->marca;
        $this->unidad_medida = $selectProducto->unidad_medida;
        $this->unidad_medida_mh = $selectProducto->unidad_medida_mh;
        $this->presentacion = $selectProducto->presentacion;
        $this->civa = $selectProducto->civa;
        $this->csiva = $selectProducto->csiva;
        $this->selected_id = $selectProducto->id;
        $this->activateNewSection = $activateNewSection;
        $this->image = $selectProducto->image;

        $this->allImages = Storage::disk('public')->files('productos');
        usort($this->allImages, function ($a, $b) {
            return Storage::disk('public')->lastModified($b) - Storage::disk('public')->lastModified($a);
        });


        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $updateProducto = Producto::find($this->selected_id);
        if(empty($this->codigo_barra)){
            $updateProducto->codigo_barra = null;
        }else{
            $updateProducto->codigo_barra = $this->codigo_barra;
        }
        $updateProducto->producto = $this->producto;
        $updateProducto->categoria = $this->categoria;
        $updateProducto->marca = $this->marca;
        $updateProducto->unidad_medida = $this->unidad_medida;
        $updateProducto->unidad_medida_mh = $this->unidad_medida_mh;
        $updateProducto->presentacion = $this->presentacion;
        $updateProducto->civa = $this->civa;
        $updateProducto->csiva = $this->csiva;
        if (!empty($this->imageChange)) {
            $updateProducto->image = $this->imageChange;
        } else {
            if ($this->image && is_file($this->image)) {
                $customFileName = uniqid() . '_.' . pathinfo($this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                $this->image->storeAs('public/productos', $customFileName);
                $imagetemp = $updateProducto->image;
                $updateProducto->image = $customFileName;

            }
        }

        $updateProducto->save();
        $this->resetPage();
        $this->dispatch('noty', msg: 'PRODUCTO Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');

        return redirect()->route(route: 'productos');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // if ($producto->HInventarios()->exists()) {
        //     $this->dispatch('noty-error', msg: 'NO POSIBLE ELIMINAR EL PRODUCTO - este registro se esta usando en otro modulo.');
        //     return;
        // }

        // $producto->delete();

        $producto->deleted_at = now(); 
        $producto->save();

        $this->resetPage();
        $this->ResetInt();
        $this->dispatch('noty', msg: 'PRODUCTO ELIMINADO CON ÉXITO');
    }

    #[On('ResetInt')]
    public function ResetInt()
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
        $this->activateNewSection = false;
    }


    public function actualizarCostoSinIva1()
    {
        if (!is_numeric($this->civa))
        {
            $this->mensajeError = "Ingrese solo valores numéricos para el costo sin IVA.";
            $this->civa = null; // Reiniciar el valor del costo con IVA
        }
        else
        {
        // Realizar el cálculo para obtener el costo con IVA
            $costoSinIva = $this->civa * 1.13; // Suponiendo un IVA del 13%
            // Asignar el valor del costo con IVA a la propiedad correspondiente
            $this->csiva = number_format($costoSinIva, 6);
            // Limpiar el mensaje de error
            $this->mensajeError = null;
        }
    }

    public function renderImage($filename)
    {

        $path = 'public/productos/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response()->file(storage_path("app/{$path}"));
    }

    public function eliminarImagen($imgDelete)
    {
        $imagePath = 'productos/' . $imgDelete;

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);

            // Actualizar la lista de imágenes después de la eliminación
            $this->allImages = Storage::disk('public')->files('productos');

            // Reiniciar la página si es necesario
            $this->resetPage();

            // Enviar notificación de éxito
            $this->dispatch('noty', msg: 'Imagen eliminada exitosamente.');
        } else {
            // Manejar el caso donde la imagen no existe
            $this->dispatch('noty', msg: 'La imagen no fue encontrada.');
        }
    }
}
