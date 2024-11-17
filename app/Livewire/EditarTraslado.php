<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Sucursales;
use App\Models\Temptraslado;
use App\Models\Traslado;
use App\Models\TrasladoDetalle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class EditarTraslado extends Component
{
    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo, 
    $valor, $status, $pagination = 10, $sorigen, $sdestino, $correlativo, $fecha, $detalle, $cant=[], $hasProcessed = false, $idTraslado, $trasladoId;
    public function mount($idTraslado)
    {
        Temptraslado::where('user', Auth::user()->id)->delete();
        $this->trasladoId = $idTraslado; // uso en update()
        
        $sessionKeys = session()->all();
        foreach ($sessionKeys as $key => $value) {
            // Si la clave comienza con 'processed_', eliminarla
            if (strpos($key, 'processed_') === 0) {
                session()->forget($key);
            }
        }
        
        $selectTraslado = Traslado::find($idTraslado);
        if ($selectTraslado && $selectTraslado->solicitante != Auth::user()->id) {
            // Redirigir a la vista de traslados si el solicitante no coincide
            return redirect()->route('traslados');
        }

        $this->sorigen = $selectTraslado->sorigen;
        $this->sdestino = $selectTraslado->sdestino;
        $this->correlativo = $selectTraslado->correlativo;
        $this->fecha = $selectTraslado->fecha;
        $this->detalle = $selectTraslado->detalle;
        $this->selected_id = $selectTraslado->id;


        $trasladoDetalles = TrasladoDetalle::where('traslado', $idTraslado)->get();

        foreach ($trasladoDetalles as $detalle) {
            $productoDetalle = Producto::where('id', $detalle->producto)->first();
            Temptraslado::create([
                'codigo' => $productoDetalle->codigo_barra,
                'producto' => $productoDetalle->id, 
                'medida' => $productoDetalle->unidad_medida, 
                'nombre' => $productoDetalle->producto, 
                'cantidad' => $detalle->cantidad, 
                'costo' => $productoDetalle->csiva, 
                'total' => $detalle->cantidad * $productoDetalle->csiva, 
                'user' => $selectTraslado->solicitante, 
            ]);
        }
    

        $this->Carrito();
    }
    public function render()
    {
        
        $user_id = Auth::user()->id;
        return view('livewire.editar_traslado.editartraslado', [
            'productos' => $this->Allproductos(),
            'sucursales' => $this->AllSucursales(),
            'items' => Temptraslado::where('user', $user_id)->get()
        ]);
    }

    public function Allproductos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Producto::where('codigo_barra', 'like', "%{$this->search}%")
                ->orWhere('codigo_barra', 'like', "%{$this->search}%")
                ->orderBy('codigo_barra', 'asc');

        } else {
            $query = Producto::where('presentacion', '1')
            ->with('RunidadMedidaMH')
            ->orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    public function AllSucursales(){
        if (!empty($this->search)) {

            $this->resetPage();

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

    public function Temporal($id){
        $user_id = Auth::user()->id;
        $query = Producto::find($id);
        $tmp = Temptraslado::where('user', $user_id)
        ->where('producto', $id)
        ->first();

        if ($tmp) {    
            
            if($tmp->producto != $id){
                $createTemp = Temptraslado::create([
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
                $tmp->cantidad = $tmp->cantidad+1;
                $tmp->total = ($tmp->cantidad+1)*$tmp->costo;
                $tmp->save();
            }
        }
        else{
            $createTemp = Temptraslado::create([
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

    public function Carrito(){
        $user_id = Auth::user()->id;
        $items = Temptraslado::where('user', $user_id)->get();

        foreach($items as $item){
            $this->cant[$item->id] = $item->cantidad;
        }
    }

    public function deleteItem($id){
        $item = Temptraslado::find($id);
        $item->delete();
        $this->Carrito();

    }

    public function updateCantidad($id){
        $item = Temptraslado::find($id);
        $item->cantidad = $this->cant[$item->id];
        $item->total = $this->cant[$item->id] * $item->costo;
        $item->save();

        $this->Carrito();
    }

    public function guardarTraslado($trasladoId){
        $user_id = Auth::user()->id;
        $items = Temptraslado::where('user', $user_id)->get();

        foreach($items as $item) {
            if (Producto::find($item->producto)) {
                TrasladoDetalle::create([
                    'producto' => $item->producto,
                    'cantidad' => $item->cantidad,
                    'traslado' => $trasladoId,
                ]);
            }
        }
    }   

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->sorigen = '';
        $this->sdestino = '';
        $this->fecha = '';
        $this->detalle = '';
        $this->resetValidation();
    }

    public function resetProcess()
    {
        return redirect()->route('traslados');
    }

    // CRUD
    protected function rules()
    {
        $rules = [
            'sorigen' => "required|min:1",
            'sdestino' => "required|min:1",
            'fecha' => "required|min:1",
            'detalle' => "required|min:5",
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'sorigen.required' => 'El origen es requerido',
            'sorigen.min'=> 'Selecciona la sucursal destino',

            'sdestino.required' => 'El destino es requerido',
            'sdestino.min'=> 'Selecciona la sucursal destino',

            'fecha.required' => 'La fecha es requerido',
            'fecha.min'=> 'La fecha debe tener mas de 1 caracter',

            'detalle.required' => 'El detalle es requerido',
            'detalle.min'=> 'El detalle debe tener mas de 5 caracteres',
        ];
    }

    public function Update(){

        $this->validate($this->rules(), $this->messages());
        $updateTraslado = Traslado::find($this->trasladoId);
        $updateTraslado->sorigen = $this->sorigen;
        $updateTraslado->sdestino = $this->sdestino;
        $updateTraslado->fecha = $this->fecha;
        $updateTraslado->detalle = $this->detalle;

        TrasladoDetalle::where('traslado', $this->trasladoId)->delete();

        $this->guardarTraslado($this->trasladoId);

        Temptraslado::where('user', Auth::user()->id)->delete();

        $this->dispatch('noty', msg: 'Translado Actualizado con exito');
        $this->ResetInt();
        return redirect()->route('traslados');
    }
}
