<?php

namespace App\Livewire;

use App\Models\Departamento;
use App\Models\Distritos;
use App\Models\Empresas;
use App\Models\Municipio;
use App\Models\Sucursales as ModelsSucursales;
use App\Models\TipoEstablecimiento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Sucursales extends Component
{
    use WithPagination;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $empresa, $numero, $nombre, $direccion, $telefono, $cajas, $departamentos, $depto, $municipios, $muni, $distritos, $distrito, $establecimientos, $tipo, $empresas;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Sucursales Activas';
        $this->empresa = 'Elegir...';

        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
        $this->establecimientos = TipoEstablecimiento::all();

        $user = Auth::user();

        if ($user->profile == 'Super') {
            // Si el usuario es super, obtiene todas las empresas
            $this->empresas = Empresas::all();
        } else {
            // Si no es super, solo obtiene su empresa
            $this->empresas = Empresas::where('id', $user->empresa)->get();
            $this->empresa = $user->empresa;
        }
    }

    public function render()
    {
        $sucursales = ModelsSucursales::when(
            strlen($this->search) > 0,
            function ($query) {
                return $query->where('nombre', 'like', '%' . $this->search . '%');
            },
            function ($query) {
                return $query->join('empresas as e', 'e.id', 'sucursales.empresa')->orderBy('nombre', 'asc');
            },
        )->paginate($this->pagination);

        return view('livewire.sucursales.sucursales', ['sucursales' => $sucursales, 'empresas' => Empresas::orderBy('empresa', 'asc')->get()]);
    }

    protected function rules()
    {
        $id = $this->selected_id ? $this->selected_id : null;

        return [
            'numero' => ['required', 'min:1', Rule::unique('sucursales', 'numero')->ignore($id)],
            'nombre' => ['required', 'min:3', Rule::unique('sucursales', 'nombre')->ignore($id)],
            'cajas' => 'required',
            'empresa' => 'required|not_in:Elegir',
        ];
    }

    protected function messages()
    {
        return [
            'numero.required' => 'El numero se la sucursal es requerido',
            'numero.unique' => 'El numero de la sucursal ya existe',
            'numero.min' => 'El numero de la sucursal tiene que tener mas de un caracter',
            'nombre.requited' => 'El nombre de la sucursal es requerido',
            'nombre.unique' => 'El nombre de la sucursal ya existe',
            'nombre.min' => 'El nombre de la sucirsal tiene que tener al menos 3 caracteres',
            'cajas.required' => 'El numero de cajas es requerido',
            'empresa.not_in' => 'Elige un nombre de empresa diferente de elegir',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $empe = ModelsSucursales::create([
            'numero' => $this->numero,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'cajas' => $this->cajas,
            'empresa' => $this->empresa,
            'tipo' => $this->tipo,
            'departamento' => $this->depto,
            'municipio' => $this->muni,
            'distrito' => $this->distrito,
        ]);

        $this->dispatch('noty', msg: 'Sucursal registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit(ModelsSucursales $sucursal)
    {
        $this->selected_id = $sucursal->id;
        $this->empresa = $sucursal->empresa;
        $this->direccion = $sucursal->direccion;
        $this->telefono = $sucursal->telefono;
        $this->cajas = $sucursal->cajas;
        $this->nombre = $sucursal->nombre;
        $this->numero = $sucursal->numero;
        $this->tipo = $sucursal->tipo;
        $this->depto = $sucursal->departamento;
        $this->muni = $sucursal->municipio;
        $this->distrito = $sucursal->distrito;

        $this->dispatch('open-modal');
    }

    public function ResetInt()
    {
        $this->empresa = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->nombre = '';
        $this->numero = '';
        $this->cajas = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->tipo = '';
        $this->depto = '';
        $this->muni = '';
        $this->distrito = '';
        $this->resetValidation();
    }

    public function updateDepto()
    {
        $this->municipios = Municipio::where('departamento', $this->depto)->get();
    }

    public function updateMuni()
    {
        $this->distritos = Distritos::where('municipio', $this->muni)->get();
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $sucursales = ModelsSucursales::find($this->selected_id);
        $sucursales->numero = $this->numero;
        $sucursales->nombre = $this->nombre;
        $sucursales->direccion = $this->direccion;
        $sucursales->telefono = $this->telefono;
        $sucursales->cajas = $this->cajas;
        $sucursales->empresa = $this->empresa;
        $sucursales->tipo = $this->tipo;
        $sucursales->departamento = $this->depto;
        $sucursales->municipio = $this->muni;
        $sucursales->distrito = $this->distrito;
        $sucursales->save();

        $this->dispatch('noty', msg: 'Sucursal Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        ModelsSucursales::find($id)->delete();
        $this->dispatch('noty', msg: 'Sucursal eliminada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }
}
