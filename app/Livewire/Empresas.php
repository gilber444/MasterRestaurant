<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Departamentos;
use App\Models\Distritos;
use App\Models\Empresas as Empresa;
use App\Models\Municipios;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Empresas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $empresa, $razon, $direccion, $pagination = 10,
    $departamento, $municipio, $distrito, $correo,$telefono, $responsable, $registro, $giro, $nit, $actividad, $tipoContribuyente, $image, $actividadSelectName;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empresas Activas';
    }

    public function render()
    {
        $empresas = Empresa::with(['actividadEconomicas', 'departamento', 'municipio', 'distrito'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('empresa', 'like', '%' . $this->search . '%');
        })
        ->orderBy('empresa', 'asc')
        ->paginate($this->pagination);

        
        $actividades = ActividadEconomica::orderBy('valor', 'asc')->get();
        $departamentos = Departamentos::orderBy('departamento', 'asc')->get() ;
        $municipios = Municipios::orderBy('municipio', 'asc')->get();
        $distritos = Distritos::orderBy('distrito', 'asc')->get();

        return view('livewire.empresas.empresas', ['empresas' => $empresas, 'actividades' => $actividades, 'departamentos' => $departamentos, 'municipios' => $municipios, 'distritos' => $distritos]);
        //return view('livewire.empresas.empresas', ['empresas' => $empresas,  ,
        //,  ,
        // ]);
    }

    protected function rules()
    {
        $rules = [
            'empresa' => 'required|min:2|unique:empresas,empresa',
            'razon' => 'required|min:3',
            'registro' => 'required',
            'actividad' => 'required|not_in:Elegir Actividad Economica',
            'departamento' => 'required|not_in:Elegir Departamento',
            'municipio' => 'required|not_in:Elegir Municipio',
            'distrito' => 'required|not_in:Elegir Distrito',
            'nit' => 'required'
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
        'empresa.required' => 'El nombre de la empresa es requerido',
        'empresa.unique' => 'La empresa ya existe',
        'empresa.min' => 'La empresa debe tener al menos dos caracteres',
        'razon.required' => 'La razon social es Requerido',
        'razon.min' => 'La razon social debe tener al menos dos caracteres',
        'registro.required' => 'El numero de registro es Requerido',
        'actividad.not_in' => 'La actividad economica es Requerida',
        'departamento.not_in' => 'El departamento es Requerido',
        'municipio.not_in' => 'El municipio es Requerido',
        'distrito.not_in' => 'El distrito es Requerido',
        'nit.required' => 'El numero de NIT es requerido'
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $empe = Empresas::create([
            'empresa' => $this->empresa,
            'razon' => $this->razon,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'responsable' => $this->responsable,
            'registro' => $this->registro,
            'giro' => $this->giro,
            'nit' => $this->nit,
            'actividad' => $this->actividad,
            'departamento' => $this->departamento,
            'municipio' => $this->municipio,
            'distrito' => $this->distrito,
            'correo' => $this->correo,
            'tipoContribuyente' => $this->tipoContribuyente,
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/empresas', $customFileName);
            $empe->image = $customFileName;
            $empe->save();
        }

        $this->dispatch('noty', msg: 'Empresa registrada con exito');
        $this->resetUI();
        $this->dispatch('close-modal');
    }

    public function Edit(Empresas $empresa)
    {
        $this->selected_id = $empresa->id;
        $this->empresa = $empresa->empresa;
        $this->razon = $empresa->razon;
        $this->direccion = $empresa->direccion;
        $this->telefono = $empresa->telefono;
        $this->responsable = $empresa->responsable;
        $this->registro = $empresa->registro;
        $this->giro = $empresa->giro;
        $this->nit = $empresa->nit;
        $this->actividad = $empresa->actividad;
        $this->departamento = $empresa->departamento;
        $this->municipio = $empresa->municipio;
        $this->distrito = $empresa->distrito;
        $this->correo = $empresa->correo;
        $this->tipoContribuyente = $empresa->tipoContribuyente;

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $empresas = Empresas::find($this->selected_id);
        $empresas->empresa = $this->empresa;
        $empresas->razon = $this->razon;
        $empresas->direccion = $this->direccion;
        $empresas->telefono = $this->telefono;
        $empresas->responsable = $this->responsable;
        $empresas->registro = $this->registro;
        $empresas->giro = $this->giro;
        $empresas->nit = $this->nit;
        $empresas->actividad = $this->actividad;
        $empresas->departamento = $this->departamento;
        $empresas->municipio = $this->municipio;
        $empresas->distrito = $this->distrito;
        $empresas->correo = $this->correo;
        $empresas->tipoContribuyente = $this->tipoContribuyente;
        $empresas->save();

        //dd($this->image);
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAS('public/empresas', $customFileName);
            $imagetemp = $empresas->image;
            $empresas->image = $customFileName;
            $empresas->save();

            if($imagetemp !=null)
            {
                if(file_exists('storage/empresas/' . $imagetemp)){
                    unlink('storage/empresas/' . $imagetemp);
                }
            }
        }

        $this->dispatch('noty', msg: 'Empresa Actualizada con exito');
        $this->resetUI();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {
        $sucursalesCount = Empresas::find($id)->sucursales->count();

        if($sucursalesCount > 0)
        {
            $this->dispatch('noty', 'No se puede eliminar la empresa porque tiene sucursales asociadas');
            return;
        }

        Empresas::find($id)->delete();
        $this->dispatch('noty', msg: 'Empresa eliminada con exito');
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->empresa = '';
        $this->razon = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->responsable = '';
        $this->registro = '';
        $this->giro = '';
        $this->nit = '';
        $this->correo = '';
        $this->departamento = 'Elegir Departamento';
        $this->municipio = 'Elegir Municipio';
        $this->distrito = 'Elegir distrito';
        $this->actividad = 'Elegir Actividad Economica';
        $this->tipoContribuyente = '';
        $this->image = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function renderImagen($filename)
    {
        $path = 'public/empresas/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response()->file(storage_path("app/{$path}"));
    }
}
