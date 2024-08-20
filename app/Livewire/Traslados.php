<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Traslados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo, 
    $valor, $status, $pagination = 10;
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Traslados';
    }
    public function render()
    {
        return view('livewire.traslados.traslados');
    }
}
