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
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class NuevoTraslados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id, $pageTitle, $modalAction, $componentName, $codigo, 
    $valor, $status, $pagination = 10, $productoSelectID, $productoSelectName, $cant=[], $sorigen, $sdestino, $fecha, $detalle;

    public function mount()
    {
        // Se eliminara todos los datos de la temptraslado para hacer un buen uso de la tabla temporal
        Temptraslado::where('user', Auth::user()->id)->delete();
        $this->Carrito();
    }
    public function render()
    {
        $user_id = Auth::user()->id;
        return view('livewire.nuevo_traslado.nuevotraslado',[
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

    public function resetProcess()
    {
        return redirect()->route('traslados');
    }

    /* CRUD Traslados*/

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

    public function Store(){
        $this->validate($this->rules(), $this->messages());

        $user_id = Auth::user()->id;
        $ultimoCorrelativo = Traslado::max('correlativo');
        $nuevoCorrelativo = $ultimoCorrelativo ? $ultimoCorrelativo + 1 : 1;


        $createTraslado = Traslado::create([
            'sorigen'=> $this->sorigen,
            'sdestino'=>$this->sdestino,
            'correlativo'=>$nuevoCorrelativo,
            'fecha'=>$this->fecha,
            'detalle'=>$this->detalle,
            'solicitante'=>$user_id,
            'autorizacion'=>$user_id,
            'fechaautorizado'=>null,
            'estado'=>'Solicitado',
        ]);

        $createTraslado->save();

        $trasladoId = $createTraslado->id;

        $this->guardarTraslado($trasladoId);

        Temptraslado::where('user', Auth::user()->id)->delete();

        $this->dispatch('noty', msg: 'Translado Solicitado con exito');
        $this->ResetInt();
        return redirect()->route('traslados');
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

}