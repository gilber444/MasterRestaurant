<?php

namespace App\Livewire;

use App\Models\Ajuste;
use App\Models\Sucursales as ModelSucursal;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Ajustes extends Component
{
    use WithPagination;

    public $detalleAjustes = [], $productos, $sucursales, $producto, $sucursalOrigen, 
    $cantidad, $detalle, $estado, $tipo, $search, $selected_id, $pageTitle, $componentName;

    private $pagination = 7; 

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ajustes';
    }
 
    public function render()
    {
        $ajustes = Ajuste::with(['Rsucursal'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('sucursal', 'like', '%' . $this->search . '%');
        })
        ->orderBy('sucursal', 'asc')
        ->paginate($this->pagination);

        return view('livewire.ajustes.ajustes', [
            'ajustes' => $ajustes,
        ]);
    }    


    public function Update($id){

        $ajuste = Ajuste::where('id', $id)->latest()->first();
        
        $ajuste->update([
            'status' => 'Realizado'
        ]);

        $this->dispatch('noty', msg: 'Ajuste Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }


    #[On('destroy')]

    public function destroy($id)
    {
        $a = Ajuste::find($id);

        $a->update([
            'status' => 'Eliminado'
        ]);

        $a->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'AJUSTE ELIMINADO CON ÉXITO');
    }

    protected $listeners = [
        'store' => 'Store',
        'edit' => 'Edit'
    ];

}

