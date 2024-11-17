<?php

namespace App\Livewire;

use App\Models\Departamento;
use App\Models\Distritos;
use App\Models\Municipio;
use App\Models\Sucursales;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Municipios extends Component
{
    use WithPagination;

    public  $codigo, $municipio, $status, $departamento, $departamentos, $records, $search, $selected_id, $pageTitle, $componentName, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Municipio';
        $this->departamentos = Departamento::all();
    }

    public function render()
    {
        $municipios = Municipio::with(['departamentos'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('municipio', 'like', '%' . $this->search . '%');
        })
        ->orderBy('municipio', 'asc')
        ->paginate($this->pagination);

        $departamentos = Departamento::orderBy('departamento', 'asc')->get() ?? collect();

        return view('livewire.municipios.municipios', [
            'departamentos' => $departamentos,
            'municipios' => $municipios,
        ]);
    }


    protected function rules()
    {
        $rules = [
            'codigo' => "required|min:1",
            'municipio' => "required|min:3",
            'departamento' => 'required',
            'status' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'codigo.required' => 'El codigo es requerido',
            'codigo.min'=> 'El codigo debe tener mas de 1 caracteres',
            'municipio.required' => 'El nombre del municipio es requerido',
            'municipio.unique' => 'Ya existe el nombre del municipio',
            'municipio.min'=> 'El nombre del municipio debe tener mas de 3 caracteres',
            'departamento.required' => 'El nombre del departamento es requerido',
            'status.required' => 'El estado es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $muni = Municipio::create([
            'codigo' => $this->codigo,
            'municipio' => $this->municipio,
            'departamento' => $this->departamento,
            'status' => $this->status
        ]);

        $this->dispatch('noty', msg: 'Municipio registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id)
    {
        $muni = Municipio::find($id);
        $this->codigo = $muni->codigo;
        $this->municipio = $muni->municipio;
        $this->departamento = $muni->departamento;
        $this->status = $muni->status;
        $this->selected_id = $muni->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $muni = Municipio::find($this->selected_id);
        $muni->codigo = $this->codigo;
        $muni->municipio = $this->municipio;
        $muni->departamento = $this->departamento;
        $muni->status = $this->status;
        $muni->save();

        $this->dispatch('noty', msg: 'Municipio Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $municipio = Municipio::find($id);

        $empresa = Empresas::where('municipio', $municipio->id);
        $distrito = Distritos::where('municipio', $municipio->id);
        $sucursal = Sucursales::where('municipio', $municipio->id);
        if ($empresa || $distrito || $sucursal) {
            $this->dispatch('noty', msg: 'NO SE PUEDE ELIMINAR: EL MUNICIPIO ESTÁ ASOCIADO A UNA EMPRESA, DISTRITO Y SUCURSALES');
            return;
        }

        $municipio->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'MUNICIPIO ELIMINADO CON ÉXITO');
    }

    protected $listeners = [
        'store' => 'Store',
        'edit' => 'Edit'
    ];

    public function ResetInt()
    {
        $this->codigo = '';
        $this->municipio = '';
        $this->departamento = '';
        $this->status = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
