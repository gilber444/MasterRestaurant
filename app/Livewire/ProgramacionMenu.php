<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\ProgramacionMenu as ProgramacionMenuQuery;
class ProgramacionMenu extends Component
{
    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName,$codigo,
    $valor, $status, $pagination = 10;

    use WithPagination;
    use WithFileUploads;
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Programacion del Menu';
    }
    public function render()
    {
        return view('livewire.programacion_menu.programacion_menu', [
            'programacion' => $this->Allprogramacion()
        ]);
    }

    public function Allprogramacion()
    {
        if (!empty($this->search)) {

            $this->resetPage();
            $searchDate = null;

            // Verifica si la fecha está en el formato 'd/m/Y'
            $format = 'd/m/Y';
            $dateTime = \DateTime::createFromFormat($format, $this->search);
            
            if ($dateTime && $dateTime->format($format) === $this->search) {
                // Si la fecha es válida, conviértela al formato 'Y-m-d'
                $searchDate = $dateTime->format('Y-m-d');
            }
            $query = ProgramacionMenuQuery::with('RProductoMenu')
                ->orWhereHas('RProductoMenu', function($query) {
                    $query->where('producto', 'like', "%{$this->search}%"); // Asegúrate de usar el nombre correcto de la columna
                })
                ->orWhere('id', 'like', "%{$this->search}%");
                if ($searchDate) {
                    $query->orWhere('fecha', 'like', "%{$searchDate}%");
                }
                $query->orderBy('fecha', 'desc');

        } else {
            $query = ProgramacionMenuQuery::orderBy('fecha', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $producto = ProgramacionMenuQuery::findOrFail($id);

        $producto->delete();

        $this->resetPage();
        $this->dispatch('noty', msg: 'PRODUCTO ELIMINADO CON ÉXITO');
    }

}
