<?php

namespace App\Livewire;

use App\Models\Categorias;
use App\Models\FormaVenta;
use App\Models\Lineas;
use App\Models\Marcas;
use App\Models\Precios;
use App\Models\Producto;
use App\Models\ProductoMenu;
use App\Models\ProductoUnidadMedida;
use App\Models\RecetaProductos;
use Livewire\Attributes\On;
use Livewire\Component;

class EditarProducto extends Component
{
    public $componentName, $producto, $marca, $linea, $categoria, $forma_venta, $comun, $pagination = 10,
        $medidas, $productos;

    public $unidad, $status, $costo, $costoIva, $utilidad, $precioVenta, $precioVentaIva, $mensajeError;

    public $selected_id, $activateNewSection = false;
    //variables para actualizar los precios
    public $lineaP, $cantidadP, $categoriaP, $cantidadesU = [], $categoriaU = [], $lineaU = [], $costoU = [], $costoIvaU = [], $utilidadU = [], $precioVentaU = [], $precioVentaIvaU = [];
    //variables para la receta
    public $producto_primaryU = [], $unidadesU = [], $cantidadU = [], $totalU = [], $cantidad, $producto_primary, $nombreUnidad, $unidadMedida, $Totales, $total;
    //para no cambiar de precios a productos
    public $activeTab = 'navs-home-card';

    public function mount($id)
    {
        if ($id) {
            $this->selected_id = $id;
            $this->activateNewSection = true;
        }

        $this->componentName = 'Editar Producto';

        $this->productos = ProductoMenu::find($id);
        $this->selected_id = $id;



        //carga los datos de la receta al guardar
        $this->cantidad = 1;

        $this->producto = $this->productos->producto;
        $this->linea = $this->productos->linea;
        $this->categoria = $this->productos->categoria;
        $this->forma_venta = $this->productos->forma_venta;
        $this->comun = $this->productos->comun;
        $this->status = $this->productos->status;
        $this->marca = $this->productos->marca;

        //carga los precios al actualizar
        foreach (Precios::where('producto', $id)->get() as $pre) {
            $this->lineaU[$pre->id] = $pre->lineaP;
            $this->categoriaU[$pre->id] = $pre->categoriaP;
            $this->cantidadesU[$pre->id] = number_format($pre->cantidadP, 2);
            $this->costoU[$pre->id] = number_format($pre->costo, 2);
            $this->costoIvaU[$pre->id] = number_format($pre->costoIva, 2);
            $this->utilidadU[$pre->id] = number_format($pre->utilidad, 2);
            $this->precioVentaU[$pre->id] = number_format($pre->precioVenta, 2);
            $this->precioVentaIvaU[$pre->id] = number_format($pre->precioVentaIva, 2);
        }

        //carga las recetas en el actualizar
        foreach (RecetaProductos::where('producto', $id)->get() as $pro) {
            $this->producto_primaryU[$pro->id] = $pro->producto_primary;
            $unidad = ProductoUnidadMedida::find($pro->unidad);
            $this->unidadesU[$pro->id] = $unidad ? $unidad->nombre : 'Desconocido';
            $this->cantidadU[$pro->id] = $pro->cantidad;
            $producto = Producto::find($pro->producto_primary);
            if ($producto) {
                $this->totalU[$pro->id] = number_format($producto->csiva * $this->cantidadU[$pro->id], 2);
            } else {
                $this->totalU[$pro->id] = 0;
            }
            $this->Totales += $this->totalU[$pro->id];
        }
        //carga los datos al agregar el precio
        $this->cantidadP = 1;
        $this->costo = $this->Totales;

        $this->calcularCantidad();
        $this->calcularCostoIva();
        $this->recalcularTotales();
        $this->updateCostoPrecio();
    }

    public function render()
    {
        return view('livewire.producto_menus.EditarProducto', [
            'activeTab' => $this->activeTab,
            'Marcas' => Marcas::orderBy('marca', 'asc')->get(),
            'lineas' => Lineas::orderBy('linea', 'asc')->get(),
            'unidades' => ProductoUnidadMedida::orderBy('nombre', 'asc')->get(),
            'categorias' => Categorias::orderBy('categoria', 'asc')->get(),
            'FormaVentas' => FormaVenta::orderBy('forma_venta', 'asc')->get(),
            'Producto_Primary' => Producto::orderBy('producto', 'asc')->get(),
        ]);
    }

    public function Update()
    {
        // Validar datos antes de guardar
        $this->validate([
            'producto' => 'required|string|max:255',
            'marca' => 'required|exists:marcas,id',
            'linea' => 'required|exists:lineas,id',
            'categoria' => 'required|exists:categorias,id',
            'forma_venta' => 'required|exists:forma_ventas,id',
            'comun' => 'required|in:SI,NO',
        ], [
            'producto.required' => 'El nombre del producto es obligatorio',
            'marca.required' => 'Debe seleccionar una marca',
            'linea.required' => 'Debe seleccionar una línea',
            'categoria.required' => 'Debe seleccionar una categoría',
            'forma_venta.required' => 'Debe seleccionar una forma de venta',
            'comun.required' => 'Debe indicar si el producto es en común',
        ]);

        $producto = ProductoMenu::find($this->selected_id);

        if ($producto) {
            $producto->update([
                'producto' => $this->producto,
                'marca' => $this->marca,
                'linea' => $this->linea,
                'categoria' => $this->categoria,
                'forma_venta' => $this->forma_venta,
                'comun' => $this->comun,
                'status' => $this->status,
            ]);

            $this->dispatch('noty', msg: 'Producto Actualizado');
        } else {
            $this->dispatch('noty', msg: 'Producto no encontrado');
        }

        return redirect()->route('producto_menus');
    }

    //Receta
    protected function rules()
    {
        return [
            'producto_primary' => 'required',
            'cantidad' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    protected function messages()
    {
        return [
            'producto_primary.required' => 'El producto es requerido',
            'cantidad.required' => 'La cantidad es requerida',
            'cantidad.numeric' => 'La cantidad debe ser un número válido, entero o decimal con dos decimales',
        ];
    }

    public function StoreReceta()
    {
        $this->validate($this->rules(), $this->messages());

        RecetaProductos::create([
            'producto' => $this->selected_id,
            'producto_primary' => $this->producto_primary,
            'unidad' => $this->unidad,
            'cantidad' => $this->cantidad,
        ]);

        $this->resetUIReceta();
        $this->dispatch('noty', msg: 'Producto registrado en la receta');
        $this->Totales = number_format($this->Totales + $this->total, 2);
        return redirect()->route('EditarProducto', ['id' => $this->selected_id]);
    }

    public function UpdateReceta($id)
    {
        $this->validate([
            'producto_primaryU.' . $id => 'required',
            'cantidadU.' . $id => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ], [
            'producto_primaryU.' . $id . '.required' => 'El producto es requerido',
            'cantidadU.' . $id . '.required' => 'La cantidad es requerida',
            'cantidadU.' . $id . '.numeric' => 'La cantidad debe ser un número válido, entero o decimal con dos decimales',
        ]);

        $receta = RecetaProductos::find($id);

        $producto = Producto::with('RunidadMedida')->find($this->producto_primaryU[$id]);

        if ($producto) {
            $unidadMedidaId = $producto->RunidadMedida->id;

            $receta->update([
                'producto_primary' => $this->producto_primaryU[$id],
                'unidad' => $unidadMedidaId,
                'cantidad' => $this->cantidadU[$id],
            ]);
        }
        $this->updateCostoPrecio();
        $this->dispatch('noty', msg: 'Producto Actualizado');
    }

    public function storeUnidad()
    {
        if ($this->producto_primary) {
            $prod = Producto::with('RunidadMedida')
                ->find($this->producto_primary);

            if ($prod && $prod->unidad_medida) {
                $this->nombreUnidad = $prod->RunidadMedida->nombre;
                $this->unidad = $prod->unidad_medida;

                $this->unidad = $prod->unidad_medida;
                $cantidad = 1;
                $csiva = floatval($prod->csiva);

                $this->total = number_format($cantidad * $csiva, 2);
            }
        }
    }

    public function storeCantidad()
    {
        if ($this->producto_primary) {
            $prod = Producto::find($this->producto_primary);

            if ($prod) {
                $this->total = number_format($this->cantidad * $prod->csiva, 2);
            }
            $this->recalcularTotales();
        }
    }

    public function updateUnidad($productId)
    {
        $producto = Producto::with('RunidadMedida')->find($this->producto_primaryU[$productId]);
        if ($producto) {
            $this->unidadesU[$productId] = $producto->RunidadMedida->nombre;

            $this->unidad = $producto->RunidadMedida->id;
            $this->cantidadU[$productId] = 1;
            $this->totalU[$productId] = number_format($this->cantidadU[$productId] * $producto->csiva, 2);
            $this->recalcularTotales();
        }
    }

    public function updateTotal($id)
    {
        $cantidad = $this->cantidadU[$id];
        if (empty($cantidad)) {
            $this->dispatch('noty', msg: 'Ingrese la cantidad');
            $this->totalU[$id] = 0;
            $this->recalcularTotales();
            return;
        }

        $producto = Producto::find($this->producto_primaryU[$id]);

        if ($producto) {
            $this->totalU[$id] = number_format($producto->csiva * $cantidad, 2);
            $this->recalcularTotales();
        }
    }

    public function recalcularTotales()
    {
        $total = 0;

        foreach ($this->totalU as $key => $valor) {
            $total += floatval($valor);
        }
        $this->Totales = $total;
    }

    public function updateCostoPrecio()
    {
        $total = 0;

        foreach ($this->totalU as $key => $valor) {
            $total += floatval($valor);
        }
        $this->Totales = $total;
        $this->costo = number_format($this->Totales, 2);
        $this->costoIva = number_format($this->costo * 1.13, 2);
    }

    public function DestroyReceta($id)
    {
        $receta = RecetaProductos::find($id);
        if ($receta) {
            $receta->delete();
            $this->resetUIReceta();
            $this->dispatch('noty', msg: 'PRODUCTO ELIMINADO DE LA RECETA');
        } else {
            $this->dispatch('noty', msg: 'RECETA NO ENCONTRADA');
        }
        $this->Totales = number_format($this->Totales - $this->totalU[$id], 2);
        $this->cantidad = 1;
    }

    public function resetUIReceta()
    {
        $this->producto_primary = '';
        $this->unidad = '';
        $this->cantidad = '';
        $this->resetValidation();
    }

    //Precios
    public function StorePrecio()
    {
        $rules = [
            'producto' => 'required',
            'lineaP' => 'required',
            'categoriaP' => 'required',
            'cantidadP' => 'required|numeric|min:0.01',
            'utilidad' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0.01',
            'costoIva' => 'required|numeric|min:0.01',
            'precioVenta' => 'required|numeric|min:0.01',
            'precioVentaIva' => 'required|numeric|min:0.01'
        ];

        $messages = [
            'producto.required' => 'El producto es requerido',
            'lineaP.required' => 'La linea es requerida',
            'categoriaP.required' => 'La categoria es requerida',
            'cantidadP.required' => 'La cantidad es requerida',
            'cantidadP.numeric' => 'La cantidad debe ser un número válido',
            'cantidadP.min' => 'La cantidad debe ser mayor a 0',
            'utilidad.required' => 'La Utilidad es requerida',
            'utilidad.numeric' => 'La Utilidad debe ser un número válido',
            'utilidad.min' => 'La Utilidad no puede ser negativa',
            'costo.required' => 'El costo es requerido',
            'costo.numeric' => 'El costo debe ser un número válido',
            'costo.min' => 'El costo debe ser mayor a 0',
            'costoIva.required' => 'El costo con IVA es requerido',
            'costoIva.numeric' => 'El costo con IVA debe ser un número válido',
            'costoIva.min' => 'El costo con IVA debe ser mayor a 0',
            'precioVenta.required' => 'El precio venta es requerido',
            'precioVenta.numeric' => 'El precio de venta debe ser un número válido',
            'precioVenta.min' => 'El precio de venta debe ser mayor a 0',
            'precioVentaIva.required' => 'El precio venta con IVA es requerido',
            'precioVentaIva.numeric' => 'El precio de venta con IVA debe ser un número válido',
            'precioVentaIva.min' => 'El precio de venta con IVA debe ser mayor a 0'
        ];


        $this->validate($rules, $messages);

        $precio = Precios::create([
            'producto' => $this->selected_id,
            'lineaP' => $this->lineaP,
            'categoriaP' => $this->categoriaP,
            'cantidadP' => $this->cantidadP,
            'costo' => $this->costo,
            'costoIva' => $this->costoIva,
            'utilidad' => $this->utilidad,
            'precioVenta' => $this->precioVenta,
            'precioVentaIva' => $this->precioVentaIva,
        ]);
        $this->setActiveTab('navs-profile-card');
        $this->ResetIntPrecios();
        $this->dispatch('noty', msg: 'Precio registrado');
        return redirect()->route('EditarProducto', ['id' => $this->selected_id]);
    }

    public function UpdatePrecios($id)
    {
        $rules = [
            'lineaU.' . $id => 'required',
            'categoriaU.' . $id => 'required',
            'cantidadesU.' . $id => 'required|numeric|min:0.01',
            'utilidadU.' . $id => 'required|numeric|min:0',
            'costoU.' . $id => 'required|numeric|min:0.01',
            'costoIvaU.' . $id => 'required|numeric|min:0.01',
            'precioVentaU.' . $id => 'required|numeric|min:0.01',
            'precioVentaIvaU.' . $id => 'required|numeric|min:0.01'
        ];

        $messages = [
            'lineaU.' . $id . '.required' => 'La linea es requerida',
            'categoriaU.' . $id . '.required' => 'La categoria es requerida',
            'cantidadesU.' . $id . '.required' => 'La cantidad es requerida',
            'cantidadesU.' . $id . '.numeric' => 'La cantidad debe ser un número válido',
            'cantidadesU.' . $id . '.min' => 'La cantidad debe ser mayor a 0',
            'utilidadU.' . $id . '.required' => 'La Utilidad es requerida',
            'utilidadU.' . $id . '.numeric' => 'La Utilidad debe ser un número válido',
            'utilidadU.' . $id . '.min' => 'La Utilidad no puede ser negativa',
            'costoU.' . $id . '.required' => 'El costo es requerido',
            'costoU.' . $id . '.numeric' => 'El costo debe ser un número válido',
            'costoU.' . $id . '.min' => 'El costo debe ser mayor a 0',
            'costoIvaU.' . $id . '.required' => 'El costo con IVA es requerido',
            'costoIvaU.' . $id . '.numeric' => 'El costo con IVA debe ser un número válido',
            'costoIvaU.' . $id . '.min' => 'El costo con IVA debe ser mayor a 0',
            'precioVentaU.' . $id . '.required' => 'El precio venta es requerido',
            'precioVentaU.' . $id . '.numeric' => 'El precio de venta debe ser un número válido',
            'precioVentaU.' . $id . '.min' => 'El precio de venta debe ser mayor a 0',
            'precioVentaIvaU.' . $id . '.required' => 'El precio venta con IVA es requerido',
            'precioVentaIvaU.' . $id . '.numeric' => 'El precio de venta con IVA debe ser un número válido',
            'precioVentaIvaU.' . $id . '.min' => 'El precio de venta con IVA debe ser mayor a 0'
        ];

        $this->validate($rules, $messages);


        $precio = Precios::find($id);

        $precio->update([
            'lineaP' => $this->lineaU[$id],
            'categoriaP' => $this->categoriaU[$id],
            'cantidadP' => $this->cantidadesU[$id],
            'costo' => $this->costoU[$id],
            'costoIva' => $this->costoIvaU[$id],
            'utilidad' => $this->utilidadU[$id],
            'precioVenta' => $this->precioVentaU[$id],
            'precioVentaIva' => $this->precioVentaIvaU[$id],
        ]);
        $this->setActiveTab('navs-profile-card');
        $this->dispatch('noty', msg: 'Precio Actualizado');
    }

    public function ResetIntPrecios()
    {
        $this->lineaP = '';
        $this->categoriaP = '';
        $this->cantidadP = '';
        $this->costo = '';
        $this->costoIva = '';
        $this->utilidad = '';
        $this->precioVenta = '';
        $this->precioVentaIva = '';
        $this->resetValidation();
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $precio = Precios::find($id);
        if ($precio) {
            $precio->delete();
            $this->ResetIntPrecios();
            $this->dispatch('noty', msg: 'PRECIO ELIMINADO');
        } else {
            $this->dispatch('noty', msg: 'PRECIO NO ENCONTRADO');
        }
    }

    public function calcularCantidad()
    {
        if (!is_numeric($this->cantidadP)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
        } else {
            $costo = floatval($this->cantidadP) * floatval($this->Totales);
            $costoIva = (floatval($this->cantidadP) * floatval($this->Totales)) * 1.13;
            $this->mensajeError = null;
            $this->costo = number_format($costo, 2);
            $this->costoIva = number_format($costoIva, 2);

            if (!empty($this->utilidad)) {
                $precioVenta = (($this->utilidad / 100) * $costoIva) + $costoIva;
                $this->precioVenta = number_format($precioVenta, 2);

                $precioVentaIva = $precioVenta * 1.13;
                $this->precioVentaIva = number_format($precioVentaIva, 2);
            } else {
                $this->precioVenta = '';
                $this->precioVentaIva = '';
            }
        }
    }

    // Función auxiliar para resetear los inputs
    private function resetInputs()
    {
        $this->costo = '';
        $this->costoIva = '';
        $this->utilidad = '';
        $this->precioVenta = '';
        $this->precioVentaIva = '';
    }

    public function calcularCostoIva()
    {
        if (!is_numeric($this->costo)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->costo = '';
        } else {
            $costoIVA = ($this->cantidadP * $this->costo) * 1.13;
            $this->mensajeError = null;
            $this->costoIva = number_format($costoIVA, 2);
        }
    }

    public function calcularCosto()
    {
        if (!is_numeric($this->costoIva)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->costoIva = number_format($this->costo * 1.13, 2);
        } else {
            if ($this->costoIva < $this->costo) {
                $this->dispatch('noty', msg: 'El costo con iva no puede ser menor al costo');
                $this->costoIva = number_format($this->costo * 1.13, 2);
            } else {
                $costo = $this->costoIva / 1.13;
                $this->mensajeError = null;
                $this->costo = number_format($costo, 2);
            }
        }
    }

    public function calcularPrecioVenta()
    {
        if (!is_numeric($this->utilidad)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->precioVenta = '';
            $this->precioVentaIva = '';
        } else {
            $precioVenta = (($this->utilidad / 100) * $this->costoIva) + $this->costoIva;
            $precioVentaIva = $precioVenta * 1.13;
            $this->mensajeError = null;
            $this->precioVenta = number_format($precioVenta, 2);
            $this->precioVentaIva = number_format($precioVentaIva, 2);
        }
    }

    public function calcularPrecioVentaIva_Utilidad()
    {
        if (!is_numeric($this->precioVenta)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->precioVentaIva = '';
            $this->utilidad = '';
            return;
        } else {
            if ($this->precioVenta < $this->costoIva) {
                $this->dispatch('noty', msg: 'El precio de venta no puede ser menor que el costo con iva');
                $this->precioVentaIva = '';
                $this->utilidad = '';
                return;
            } else {
                $utilidad = (($this->precioVenta - $this->costoIva) / $this->costoIva) * 100;
                $precioVentaIva = $this->precioVenta * 1.13;
                $this->mensajeError = null;
                $this->utilidad = number_format($utilidad);
                $this->precioVentaIva = number_format($precioVentaIva, 2);
            }
        }
    }

    public function calcularPrecioVenta_Utilidad()
    {
        if (!is_numeric($this->precioVentaIva)) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->precioVenta = '';
            $this->utilidad = '';
        } else {
            if ($this->precioVentaIva < $this->costoIva) {
                $this->dispatch('noty', msg: 'El precio de venta con iva no puede ser menor al costo con iva');
                $this->precioVenta = '';
                $this->utilidad = '';
            } else {
                $precioVenta = ($this->precioVentaIva / 1.13);
                $utilidad = ((($this->precioVentaIva / 1.13) - $this->costoIva) / $this->costoIva) * 100;
                $this->mensajeError = null;
                $this->precioVenta = number_format($precioVenta, 2);
                $this->utilidad = number_format($utilidad);
            }
        }
    }

    //para actualizar los datos de los precios de update
    public function calcularCantidadUpdate($id)
    {
        $pre = Precios::find($id);
        if (!is_numeric($this->cantidadesU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->cantidadesU[$id] = $pre->cantidadP;
        } else {
            $costoUnitario = $pre->costo;
            $this->costoU[$id] = number_format($costoUnitario, 2);

            $costoTotal = $this->cantidadesU[$id] * $costoUnitario;
            $this->costoU[$id] = number_format($costoTotal, 2);
        
            $costoTotalIva = $costoTotal * 1.13;
            $this->costoIvaU[$id] = number_format($costoTotalIva, 2);
        
            $utilidadPorcentaje = $pre->utilidad / 100; 
            $precioVenta = ($utilidadPorcentaje * $costoTotalIva) + $costoTotalIva;
            $this->precioVentaU[$id] = number_format($precioVenta, 2);
        
            $precioVentaIva = $precioVenta * 1.13;
            $this->precioVentaIvaU[$id] = number_format($precioVentaIva, 2);
        }
    }

    public function calcularCostoIvaUpdate($id)
    {
        if (!is_numeric($this->costoU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->costoU[$id] = '';
        } else {
            $costoIVA = $this->costoU[$id] * 1.13;
            $this->costoIvaU[$id] = number_format($costoIVA, 2);
        }
    }

    public function calcularCostoUpdate($id)
    {
        $pre = Precios::find($id);
        if (!is_numeric($this->costoIvaU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->costoIvaU[$id] = number_format($this->costoU[$id] * 1.13, 2);
            return;
        } else {
            if ($this->costoIvaU[$id] < $pre->costoIva) {
                $this->dispatch('noty', msg: 'El Costo con iva no puede ser menor al costo');
                $this->costoIvaU[$id] = number_format($this->costoU[$id] * 1.13, 2);
            } else {
            $costo = $this->costoIvaU[$id] / 1.13;
            $this->mensajeError = null;
            $this->costoU[$id] = number_format($costo, 2);
            }
        }
    }

    public function calcularPrecioVentaUpdate($id)
    {
        if (!is_numeric($this->utilidadU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            return;
        } else {
            $precioVenta = (($this->utilidadU[$id] / 100) * $this->costoIvaU[$id]) + $this->costoIvaU[$id];
            $precioVentaIva = $precioVenta * 1.13;
            $this->mensajeError = null;
            $this->precioVentaU[$id] = number_format($precioVenta, 2);
            $this->precioVentaIvaU[$id] = number_format($precioVentaIva, 2);
        }
    }

    public function calcularPrecioVentaIva_UtilidadUpdate($id)
    {
        if (!is_numeric($this->precioVentaU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numérico.');
            $this->precioVentaIvaU[$id] = number_format((($this->utilidadU[$id] / 100) * $this->costoIvaU[$id]) + $this->costoIvaU[$id]);
            return;
        } else{
            if ($this->precioVentaU[$id] < $this->costoIvaU[$id]) {
                $this->dispatch('noty', msg: 'El precio de venta no puede ser menor que el costo del producto.');
                $this->precioVentaU[$id] = number_format((($this->utilidadU[$id] / 100) * $this->costoIvaU[$id]) + $this->costoIvaU[$id], 2);
                return;
            } else {
                $precioVentaIva = $this->precioVentaU[$id] * 1.13;

                $utilidad = ((($this->precioVentaU[$id] / 1.13) - $this->costoIvaU[$id]) / $this->costoIvaU[$id]) * 100;
                $this->precioVentaIvaU[$id] = number_format($precioVentaIva, 2);
                $this->utilidadU[$id] = number_format($utilidad, 2);
            }
        }
    }


    public function calcularPrecioVenta_UtilidadUpdate($id)
    {
        if (!is_numeric($this->precioVentaIvaU[$id])) {
            $this->dispatch('noty', msg: 'Ingrese un valor numerico');
            $this->precioVentaIvaU[$id] = number_format($this->precioVentaU[$id] * 1.13, 2);
            return;
        } else {
            if ($this->precioVentaIvaU[$id] < $this->costoIvaU[$id]) {
                $this->dispatch('noty', msg: 'Precio de venta con iva menor al costo con iva del producto');
                $this->precioVentaIvaU[$id] = number_format($this->precioVentaU[$id] * 1.13, 2);
                return;
            } else {
                $precioVenta = ($this->precioVentaIvaU[$id] / 1.13);
                $utilidad = ((($this->precioVentaIvaU[$id] / 1.13) - $this->costoIvaU[$id]) / $this->costoIvaU[$id]) * 100;
                $this->mensajeError = null;
                $this->precioVentaU[$id] = number_format($precioVenta, 2);
                $this->utilidadU[$id] = number_format($utilidad, 2);
            }
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
}
