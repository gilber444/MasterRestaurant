<?php

namespace App\Livewire;

use App\Models\Municipio;
use App\Models\Distritos as Distrito;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Distritos extends Component
{
    use WithPagination;

    public  $codigo, $distrito, $status, $municipio, $municipios, $records, $search, $selected_id, $pageTitle, $componentName, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Distritos';
        $this->municipios = Municipio::all();
    }

    public function render()
    {
        $distritos = Distrito::with(['municipios'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('distrito', 'like', '%' . $this->search . '%');
        })
        ->orderBy('distrito', 'asc')
        ->paginate($this->pagination);

        $municipios = Municipio::orderBy('municipio', 'asc')->get() ?? collect();

        return view('livewire.distritos.distritos', [
            'distritos' => $distritos,
            'municipios' => $municipios,
        ]);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|unique:distritos,codigo,{$this->selected_id}|min:1",
            'distrito' => "required|unique:distritos,distrito,{$this->selected_id}|min:3",
            'municipio' => 'required',
            'status' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'codigo.required' => 'El codigo es requerido',
            'codigo.min'=> 'El codigo debe tener mas de 1 caracteres',
            'distrito.required' => 'El nombre del distrito es requerido',
            'distrito.min'=> 'El nombre del distrito debe tener mas de 3 caracteres',
            'municipio.required' => 'El nombre del municipio es requerido',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $dis = Distrito::create([
            'codigo' => $this->codigo,
            'distrito' => $this->distrito,
            'municipio' => $this->municipio,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Distrito registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $dis = Distrito::find($id);
        $this->codigo = $dis->codigo;
        $this->distrito = $dis->distrito;
        $this->municipio = $dis->municipio;
        $this->status = $dis->status;
        $this->selected_id = $dis->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $dis = Distrito::find($this->selected_id);
        $dis->codigo = $this->codigo;
        $dis->distrito = $this->distrito;
        $dis->municipio = $this->municipio;
        $dis->status = $this->status;
        $dis->save();

        $this->dispatch('noty', msg: 'Distrito Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $dis = Distrito::find($id);
        $dis->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'DISTRITO ELIMINADO CON ÉXITO');
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->codigo = '';
        $this->distrito = '';
        $this->municipio = '';
        $this->status = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
