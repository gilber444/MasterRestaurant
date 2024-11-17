<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Cargo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class Cargos extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName,$codigo,
    $valor, $status, $pagination = 10, $nombre, $estado;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cargos';
    }
    public function render()
    {
        return view('livewire.cargos.cargos', [
            'cargos' => $this->Allcargos()
        ]);
    }

    public function Allcargos()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Cargo::where('nombre', 'like', "%{$this->search}%")
                ->orderBy('created_at', 'asc');

        } else {
            $query = Cargo::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->nombre = '';
        $this->estado = '';
        $this->resetValidation();
    }
}
