<?php

namespace App\Livewire;

use App\Models\Producto;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use App\Models\Traslado;
use App\Models\TrasladoDetalle;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Temptraslado;

class Traslados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo, 
    $valor, $status, $pagination = 10, $sorigen, $sdestino, $correlativo, $fecha, $detalle, $detalleAjustes = [];
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Traslados';
    }
    public function render()
    {
        return view('livewire.traslados.traslados',[
            'traslados' => $this->Alltraslados(),
        ]);
    }

    public function Alltraslados()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Traslado::where('correlativo', 'like', "%{$this->search}%")
                ->orderBy('created_at', 'asc');

        } else {
            $query = Traslado::orderBy('correlativo', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    public function cambiarEstado($trasladoID, $nuevoEstado)
    {
        $user_id = Auth::user()->id;
        $traslado = Traslado::find($trasladoID);
        $trasladoExist = Traslado::where('id', $trasladoID)
        ->where('solicitante', $user_id)
        ->first();

        if ($trasladoExist) {
            $this->resetPage();
            $this->dispatch('noty-error', msg: 'EL SOLICITANTE NO PUEDE MODIFICAR EL ESTADO');
        }
        else{
            $traslado->estado = $nuevoEstado;
            if ($nuevoEstado === 'Autorizado') {
                $user_id = Auth::user()->id;
                $traslado->autorizacion = $user_id;
                $traslado->fechaautorizado = now();
            }
            $traslado->save();
            $this->resetPage();
            $this->dispatch('noty', msg: 'TRASLADO ACTUALIZADO');
        }

    }

    #[On('destroy')]

    public function destroy($id)
    {
        $traslado = Traslado::findOrFail($id);
        $trasladodetalle = TrasladoDetalle::where('traslado', $traslado->id);

        if ($trasladodetalle->count() <= 0) {
            $traslado->delete();

            TrasladoDetalle::where('traslado', $id)->delete();
    
            $this->resetPage();
            $this->dispatch('noty', msg: 'TRASLADO ELIMINADO CON ÉXITO');
        }
        else{
            $this->resetPage();
            $this->dispatch('noty-error', msg: 'EL TRASLADO NO SE PUEDE ELIMINAR YA QUE POSEE PRODUCTOS AGREGADOS');
        }

    }

    public function cargarProductosTraslado($cargaTraslado)
    {
        $this->detalleAjustes = TrasladoDetalle::with(['Rproducto', 'Rtraslado'])
            ->where('traslado', $cargaTraslado)
            ->get()
            ->map(function ($detalle) {
                return [
                    'producto_id' => $detalle->Rproducto->id,
                    'id' => $detalle->id,
                    'cantidad' => $detalle->cantidad,
                    'producto' => $detalle->Rproducto->producto,
                    'medida' => $detalle->Rproducto->RunidadMedida->nombre,
                    'categoria' => $detalle->Rproducto->RcategoriaProducto->categoria,
                ];
            });

        $this->dispatch('open-modal');
    }
}
