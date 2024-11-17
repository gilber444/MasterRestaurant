<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Departamento;
use App\Models\Distritos;
use App\Models\Municipio;
use App\Models\Proveedores as ModelsProveedores;
use App\Models\TipoPersona;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Proveedores extends Component
{
    use WithPagination;

    public  $nombre, $razon_social, $tipoPersona, $departamento, $municipio, $distrito, $actividad, $direccion, $telefono, $correo, $registro, $nit, $records, $search, $selected_id, $pageTitle, $tipoPersonas, $actividadEconomica, $departamentos, $municipios, $distritos, $tipo, $componentName, $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Proveedores';
        $this->tipoPersonas = TipoPersona::all();
        $this->actividadEconomica = ActividadEconomica::all();
        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
    }

    public function render()
    {
        $query = ModelsProveedores::with(['RtipoPersona', 'Rdepartamento', 'Rmunicipio', 'Rdistrito', 'RactividadEconomica'])
            ->Where('razon_social', 'like', '%' . $this->search . '%')
            ->when(strlen($this->search) > 0, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhereHas('RtipoPersona', function ($query) {
                        $query->where('valor', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rdepartamento', function ($query) {
                        $query->where('departamento', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rmunicipio', function ($query) {
                        $query->where('municipio', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('Rdistrito', function ($query) {
                        $query->where('distrito', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('RactividadEconomica', function ($query) {
                        $query->where('valor', 'like', '%' . $this->search . '%');
                    })

                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhere('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('tipoPersona', 'like', '%' . $this->search . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('registro', 'like', '%' . $this->search . '%')
                    ->orWhere('nit', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');
        $this->records = $query->count();

        $proveedores = $query->paginate(10);

        return view('livewire.proveedores.proveedores', [
            'proveedores' => $proveedores,
            'municipios' => Municipio::orderBy('municipio', 'asc')->get() ?? collect(),
            'departamentos' => Departamento::orderBy('departamento', 'asc')->get() ?? collect(),
            'distritos' => Distritos::orderBy('distrito', 'asc')->get() ?? collect(),
            'actividadEconomica' => ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect(),
            'tipoPersonas' => TipoPersona::orderBy('valor', 'asc')->get() ?? collect(),
        ]);
    }

    public function updateDepartamento()
    {
        $this->municipios = Municipio::where('departamento', $this->departamento)->get();
    }

    public function updateMunicipio()
    {
        $this->distritos = Distritos::where('municipio', $this->municipio)->get();
    }

    protected function rules()
    {
        $id = $this->selected_id ? $this->selected_id : null;
        $rules = [
            'nombre' => [
                'required',
                'min:2',
                Rule::unique('proveedores', 'nombre')->ignore($id),
            ],
            'razon_social' => [
                'required',
                'min:2',
                Rule::unique('proveedores', 'razon_social')->ignore($id),
            ],
            'tipoPersona' => 'required',
            'departamento' => 'required',
            'municipio' => 'required',
            'distrito' => 'required',
            'actividad' => 'required',
            'telefono' => "required|unique:proveedores,telefono,{$this->selected_id}|regex:/^\d{4}-\d{4}$/",
            'registro' => "required|unique:proveedores,registro,{$this->selected_id}|min:3",
            'nit' => [
                'required',
                Rule::unique('proveedores', 'nit')->ignore($id),
                'numeric',
                'regex:/^\d{14}$/',
            ],
            'tipo' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El Nombre del Proveedor es requerido',
            'nombre.unique' => 'El Nombre del Proveedor ya existe',
            'nombre.min' => 'El Nombre del Proveedor debe tener mas de 3 caracteres',
            'razon_social.required' => 'La Razon social del Proveedor es requerido',
            'razon_social.unique' => 'La Razon social del Proveedor ya existe',
            'razon_social.min' => 'La Razon social del Proveedor debe tener mas de 3 caracteres',
            'tipoPersona' => 'El tipo de persona es Requerido',
            'departamento' => 'El departamento es Requerido',
            'municipio' => 'El municipio es Requerido',
            'distrito' => 'El distrito es Requerido',
            'actividad' => 'La Actividad economica es requerida',
            'telefono.required' => 'El Numero de telefono es requerido',
            'telefono.unique' => 'El numero de telefono ya existe',
            'telefono.regex' => 'El formato del teléfono no es válido. Debe ser en formato "9999-9999".',
            'registro.required' => 'El Numero de registro es requerido',
            'registro.unique' => 'El Numero de registro ya existe',
            'registro.min' => 'El numero de registro debe tener mas de 3 caracteres',
            'nit.required' => 'El número de NIT es requerido',
            'nit.unique' => 'El número de NIT ya existe',
            'nit.digits' => 'El número de NIT debe tener exactamente 14 dígitos',
            'nit.numeric' => 'El número de NIT solo puede contener números',
            'tipo.required' => 'El Tipo de proveedor es requerido',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $pro = ModelsProveedores::create([
            'nombre' => $this->nombre,
            'razon_social' => $this->razon_social,
            'tipoPersona' => $this->tipoPersona,
            'departamento' => $this->departamento,
            'municipio' => $this->municipio,
            'distrito' => $this->distrito,
            'actividad' => $this->actividad,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'registro' => $this->registro,
            'nit' => $this->nit,
            'tipo' => $this->tipo,
        ]);

        $this->dispatch('noty', msg: 'Proveedor registrado con éxito');
        $this->dispatch('close-modal');
        $this->ResetInt();
    }

    public function Edit($id)
    {
        $data = ModelsProveedores::find($id);
        $this->nombre = $data->nombre;
        $this->razon_social = $data->razon_social;
        $this->tipoPersona = $data->tipoPersona;
        $this->departamento = $data->departamento;
        $this->municipio = $data->municipio;
        $this->distrito = $data->distrito;
        $this->actividad = $data->actividad;
        $this->direccion = $data->direccion;
        $this->telefono = $data->telefono;
        $this->correo = $data->correo;
        $this->registro = $data->registro;
        $this->nit = $data->nit;
        $this->tipo = $data->tipo;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsProveedores::find($this->selected_id);
        $data->nombre = $this->nombre;
        $data->razon_social = $this->razon_social;
        $data->tipoPersona = $this->tipoPersona;
        $data->departamento = $this->departamento;
        $data->municipio = $this->municipio;
        $data->distrito = $this->distrito;
        $data->actividad = $this->actividad;
        $data->direccion = $this->direccion;
        $data->telefono = $this->telefono;
        $data->correo = $this->correo;
        $data->registro = $this->registro;
        $data->nit = $this->nit;
        $data->tipo = $this->tipo;
        $data->save();

        $this->dispatch('noty', msg: 'Forma de Pago Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $data = ModelsProveedores::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'PROVEEDOR ELIMINADO CON ÉXITO');
    }

    public function ResetInt()
    {
        $this->nombre = '';
        $this->razon_social = '';
        $this->tipoPersona = '';
        $this->departamento = '';
        $this->municipio = '';
        $this->distrito = '';
        $this->actividad = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->correo = '';
        $this->registro = '';
        $this->nit = '';
        $this->tipo = '';
        $this->search = '';
        $this->resetValidation();
    }
}
