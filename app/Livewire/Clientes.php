<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Distritos;
use App\Models\IdentificacionReceptor;
use App\Models\Municipio;
use App\Models\TipoPersona;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;

    public $nombreCliente, $nit, $dui, $registro, $correo, $telefono, $celular, $direccion, $departamento, $municipio, $tipoPersona, $homologado, $distrito, $actividad, $departamentos, $municipios, $distritos, $tipoPersonas, $identificacion, $identificacions, $actividadEconomica, $tipoCliente, $records, $search, $selected_id, $pageTitle, $componentName, $pagination = 10;

    public $disableDui = false;
    public $disableHomologado = false;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
        $this->tipoPersonas = TipoPersona::all();
        $this->actividadEconomica = ActividadEconomica::all();
        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
        $this->identificacions = IdentificacionReceptor::all();
    }

    public function render()
    {
        $query = Cliente::with(['RtipoPersona', 'Rdepartamento', 'Rmunicipio', 'Rdistrito', 'Ractividad', 'Ridentificacion'])
            ->Where('registro', 'like', '%' . $this->search . '%')
            ->when(strlen($this->search) > 0, function ($query) {
                $query->where('nombreCliente', 'like', '%' . $this->search . '%')
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
                    ->orWhereHas('Ridentificacion', function ($query) {
                        $query->where('valor', 'like', '%' . $this->search . '%');
                    })

                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhere('nit', 'like', '%' . $this->search . '%')
                    ->orWhere('dui', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');
        $this->records = $query->count();

        $clientes = $query->paginate(10);

        return view('livewire.clientes.clientes', [
            'clientes' => $clientes,
            'municipios' => Municipio::orderBy('municipio', 'asc')->get() ?? collect(),
            'departamentos' => Departamento::orderBy('departamento', 'asc')->get() ?? collect(),
            'distritos' => Distritos::orderBy('distrito', 'asc')->get() ?? collect(),
            'actividadEconomica' => ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect(),
            'tipoPersonas' => TipoPersona::orderBy('valor', 'asc')->get() ?? collect(),
            'Identificacions' => IdentificacionReceptor::orderBy('valor', 'asc')->get() ?? collect(),
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
            'nombreCliente' => [
                'required',
                'min:2',
                Rule::unique('clientes', 'nombreCliente')->ignore($id),
            ],
            'actividad' => 'required',
            'tipoPersona' => 'required',
            'departamento' => 'required',
            'municipio' => 'required',
            'distrito' => 'required',
            'tipoCliente' => 'required',
            'identificacion' => 'required',
            'direccion' => 'required|string|max:255',
            'celular' => [
                'nullable',
                "unique:clientes,celular,{$this->selected_id}",
                'regex:/^\d{4}-\d{4}$/',
            ],
            'correo' => 'nullable|email|max:255',
            'telefono' => [
                'nullable',
                "unique:clientes,telefono,{$this->selected_id}",
                'regex:/^\d{4}-\d{4}$/',
            ],
            'registro' => [
                'required',
                "unique:clientes,registro,{$this->selected_id}",
                'min:3',
            ],
            'homologado' => 'required',
            'nit' => [
                'nullable',
                Rule::unique('clientes', 'nit')->ignore($id),
                'regex:/^\d{14}$/',
            ],
            'dui' => 'nullable|regex:/^\d{8}-\d{1}$/',
        ];

        return $rules;
    }


    protected function messages()
    {
        return [
            'nombreCliente.required' => 'El nombre del cliente es obligatorio.',
            'actividad.required' => 'La actividad económica es obligatoria.',
            'tipoPersona.required' => 'El tipo de persona es obligatorio.',
            'departamento.required' => 'El departamento es obligatorio.',
            'municipio.required' => 'El municipio es obligatorio.',
            'distrito.required' => 'El distrito es obligatorio.',
            'tipoCliente.required' => 'El tipo de cliente es obligatorio.',
            'identificacion.required' => 'La identificacion del cliente es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'telefono.unique' => 'El numero de telefono ya existe',
            'telefono.regex' => 'El formato del teléfono no es válido. Debe ser en formato "9999-9999".',
            'celular.unique' => 'El numero de celular ya existe',
            'celular.regex' => 'El formato del celular no es válido. Debe ser en formato "9999-9999".',
            'correo.email' => 'El correo debe ser una dirección de email válida.',
            'registro.max' => 'El número de registro no debe exceder 255 caracteres.',
            'homologado.required' => 'El estado homologado es obligatorio.',
            'nit.regex' => 'El Numero del nit debe tener 14 digitos',
            'dui.regex' => 'El formato del DUI debe ser 00000000-0.',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Cliente::create([
            'nombreCliente' => $this->nombreCliente,
            'actividad' => $this->actividad,
            'tipoPersona' => $this->tipoPersona,
            'departamento' => $this->departamento,
            'municipio' => $this->municipio,
            'distrito' => $this->distrito,
            'tipoCliente' => $this->tipoCliente,
            'identificacion' => $this->identificacion,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'correo' => $this->correo,
            'registro' => $this->registro,
            'homologado' => $this->homologado,
            'nit' => $this->nit,
            'dui' => $this->dui,
        ]);


        $this->dispatch('noty', msg: 'Cliente registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function storeHomologado($homologado)
    {
        if ($homologado === 'SI') {
            $this->nit = '';
        }
    }
    public function storePersona($id)
    {
        $Persona = TipoPersona::find($id);

        if ($Persona && $Persona->valor === 'Persona Jurídica') {
            $this->dui = '';
            $this->homologado = '';
            $this->disableDui = true;
            $this->disableHomologado = true;
        } else {
            $this->disableDui = false;
            $this->disableHomologado = false;
        }
    }

    public function Edit($id)
    {
        $data = Cliente::find($id);
        $this->nombreCliente = $data->nombreCliente;
        $this->tipoPersona = $data->tipoPersona;
        $this->departamento = $data->departamento;
        $this->municipio = $data->municipio;
        $this->distrito = $data->distrito;
        $this->tipoCliente = $data->tipoCliente;
        $this->identificacion = $data->identificacion;
        $this->actividad = $data->actividad;
        $this->direccion = $data->direccion;
        $this->telefono = $data->telefono;
        $this->celular = $data->celular;
        $this->correo = $data->correo;
        $this->registro = $data->registro;
        $this->homologado = $data->homologado;
        $this->nit = $data->nit;
        $this->dui = $data->dui;
        $this->selected_id = $data->id;
        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $data = Cliente::find($this->selected_id);
        $data->nombreCliente = $this->nombreCliente;
        $data->tipoPersona = $this->tipoPersona;
        $data->departamento = $this->departamento;
        $data->municipio = $this->municipio;
        $data->distrito = $this->distrito;
        $data->tipoCliente = $this->tipoCliente;
        $data->identificacion = $this->identificacion;
        $data->actividad = $this->actividad;
        $data->direccion = $this->direccion;
        $data->telefono = $this->telefono;
        $data->celular = $this->celular;
        $data->correo = $this->correo;
        $data->registro = $this->registro;
        $data->homologado = $this->homologado;
        $data->nit = $this->nit;
        $data->dui = $this->dui;
        $data->save();

        $this->dispatch('noty', msg: 'Cliente Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $data = Cliente::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'CLIENTE ELIMINADO CON ÉXITO');
    }

    public function ResetInt()
    {
        $this->nombreCliente = '';
        $this->tipoPersona = '';
        $this->departamento = '';
        $this->municipio = '';
        $this->distrito = '';
        $this->tipoCliente = '';
        $this->identificacion = '';
        $this->actividad = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->celular = '';
        $this->correo = '';
        $this->registro = '';
        $this->homologado = '';
        $this->nit = '';
        $this->dui = '';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
    }
}
