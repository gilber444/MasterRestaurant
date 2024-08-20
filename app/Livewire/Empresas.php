<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Departamento;
use App\Models\Distritos;
use App\Models\Empresas as Empresa;
use App\Models\Municipio;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Empresas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $pagination = 10;
    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $empresa, $direccion, $telefono, $responsable, $registro, $giro, $nit, $tipoContribuyente, $image, $razon, $actividadSelectId, $actividadSelectName, $actividad, $depto, $muni, $distrito, $correo, $municipios = [], $distritos = [];



    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empresas Activas';
    }

    public function render()
    {
        $empresas = Empresa::with(['actividadEconomicas', 'departamentos', 'municipios', 'distritos'])
        ->when(strlen($this->search) > 0, function ($query) {
            $query->where('empresa', 'like', '%' . $this->search . '%');
        })
        ->orderBy('empresa', 'asc')
        ->paginate($this->pagination);


        $actividades = ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect();
    $departamentos = Departamento::orderBy('departamento', 'asc')->get() ?? collect();
    $municipios = Municipio::orderBy('municipio', 'asc')->get() ?? collect();
    $distritos = Distritos::orderBy('distrito', 'asc')->get() ?? collect();

        return view('livewire.empresas.empresas', [
            'empresas' => $empresas,
            'actividades' => $actividades,
            'departamentos' => $departamentos,
            'municipios' => $municipios,
            'distritos' => $distritos
        ]);

    }

    protected function rules()
    {
        $id = $this->selected_id ? $this->selected_id : null;

        return [
            'empresa' => [
                'required',
                'min:2',
                Rule::unique('empresas', 'empresa')->ignore($id),
            ],
            'razon' => 'required|min:3',
            'registro' => 'required',
            'actividadSelectId' => 'required|not_in:Elegir Actividad Economica',
            'depto' => 'required|not_in:Elegir Departamento',
            'muni' => 'required|not_in:Elegir Municipio',
            'distrito' => 'required|not_in:Elegir Distrito',
            'nit' => [
                'required',
                Rule::unique('empresas', 'nit')->ignore($id),
                'numeric',
                'regex:/^\d{8}$|^\d{14}$/', // Acepta solo 8 o 14 dígitos
            ]
        ];
    }

    protected function messages()
    {
        return [
            'empresa.required' => 'El nombre de la empresa es requerido',
            'empresa.unique' => 'La empresa ya existe',
            'empresa.min' => 'La empresa debe tener al menos dos caracteres',
            'razon.required' => 'La razón social es requerida',
            'razon.min' => 'La razón social debe tener al menos dos caracteres',
            'registro.required' => 'El número de registro es requerido',
            'actividadSelectId.not_in' => 'La actividad económica es requerida',
            'depto.not_in' => 'El departamento es requerido',
            'muni.not_in' => 'El municipio es requerido',
            'distrito.not_in' => 'El distrito es requerido',
            'nit.required' => 'El número de NIT es requerido',
            'nit.unique' => 'El número de NIT ya existe',
            'nit.digits' => 'El número de NIT debe tener exactamente 14 dígitos',
            'nit.numeric' => 'El número de NIT solo puede contener números',
            'dui.required' => 'El número de DUI es requerido',
            'dui.unique' => 'El número de DUI ya existe',
            'dui.digits' => 'El número de DUI debe tener exactamente 8 dígitos',
            'dui.numeric' => 'El número de DUI solo puede contener números',
            'correo.required' => 'El correo electrónico es requerido',
            'correo.email' => 'El correo electrónico debe tener un formato válido',
        ];
    }


    public function Store()
    {
        //dd($this->actividadSelectId);
        $this->validate($this->rules(), $this->messages());

        $empe = Empresa::create([
            'empresa' => $this->empresa,
            'razon' => $this->razon,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'responsable' => $this->responsable,
            'registro' => $this->registro,
            'giro' => $this->actividadSelectName,
            'nit' => $this->nit,
            'tipoContribuyente' => $this->tipoContribuyente,
            'actividad' => $this->actividadSelectId,
            'desActividad' => $this->actividadSelectName,
            'correo' => $this->correo,
            'departamento' => $this->depto,
            'municipio' => $this->muni,
            'distrito' => $this->distrito
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/empresas', $customFileName);
            $empe->image = $customFileName;
            $empe->save();
        }

        $this->dispatch('noty', msg: 'Empresa registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit(Empresa $empresa)
    {
        $this->selected_id = $empresa->id;
        $this->empresa = $empresa->empresa;
        $this->direccion = $empresa->direccion;
        $this->telefono = $empresa->telefono;
        $this->responsable = $empresa->responsable;
        $this->registro = $empresa->registro;
        $this->giro = $empresa->giro;
        $this->nit = $empresa->nit;
        $this->tipoContribuyente = $empresa->tipoContribuyente;
        $this->razon = $empresa->razon;
        $this->actividadSelectId = $empresa->actividad;
        $this->actividadSelectName = $empresa->desActividad;
        $this->correo = $empresa->correo;
        $this->depto = $empresa->departamento;
        $this->muni = $empresa->municipio;
        $this->distrito = $empresa->distrito;

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $empresas = Empresa::find($this->selected_id);
        $empresas->empresa = $this->empresa;
        $empresas->razon = $this->razon;
        $empresas->direccion = $this->direccion;
        $empresas->telefono = $this->telefono;
        $empresas->responsable = $this->responsable;
        $empresas->registro = $this->registro;
        $empresas->giro = $this->actividadSelectName;
        $empresas->nit = $this->nit;
        $empresas->tipoContribuyente = $this->tipoContribuyente;
        $empresas->correo=$this->correo;
        $empresas->departamento = $this->depto;
        $empresas->municipio = $this->muni;
        $empresas->distrito = $this->distrito;
        $empresas->actividad =$this->actividadSelectId;
        $empresas->desActividad = $this->actividadSelectName;
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
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {

        Empresa::find($id)->delete();
        $this->dispatch('noty', msg: 'Empresa eliminada con exito');
        $this->ResetInt();
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->empresa = '';
        $this->razon = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->responsable = '';
        $this->registro = '';
        $this->giro = '';
        $this->nit = '';
        $this->tipoContribuyente = '';
        $this->image = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->depto = '';
        $this->muni = '';
        $this->distrito = '';
        $this->correo = '';
        $this->actividadSelectId='';
        $this->actividadSelectName = '';
        $this->resetValidation();
        $this->resetPage();
    }

    public function renderImage($filename)
    {
        $path = 'public/empresas/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response()->file(storage_path("app/{$path}"));
    }

    public function updateDepto()
    {
        $this->municipios = Municipio::where('departamento', $this->depto)->get();
    }

    public function updateMuni()
    {
        $this->distritos = Distritos::where('municipio', $this->muni)->get();
    }
}
