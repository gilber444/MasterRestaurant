<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empleado;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class Empleados extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName,$codigo,
    $valor, $status, $pagination = 10, $nombre, $nacimiento, $dui, $nit, $seguro, $afp, $ingreso, $salario, $cargo, $updateEmpleado;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
    }

    public function render()
    {
        return view('livewire.empleados.empleados', [
            'empleados' => $this->Allempleados()
        ]);
    }

    public function Allempleados()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Empleado::where('nombre', 'like', "%{$this->search}%")
                ->orWhere('dui', 'like', "%{$this->search}%")
                ->orderBy('nombre', 'asc');

        } else {
            $query = Empleado::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'nombre' => "required|min:1",
            'nacimiento' => "required|min:1",
            'ingreso' => "required|min:1",
        ];


        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerida',
            'nombre.min'=> 'El nombre debe tener mas de 1 caracteres',
            'nacimiento.required' => 'la fecha de nacimiento es requerida',
            'nacimiento.min'=> 'la fecha nacimiento debe tener mas de 1 caracteres',
            'ingreso.required' => 'la fecha de ingreso es requerida',
            'ingreso.min'=> 'la fecha de ingreso debe tener mas de 1 caracteres',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $createEmpleado = Empleado::create([
            'nombre' => $this->nombre,
            'nacimiento' => $this->nacimiento,
            'dui' => $this->dui,
            'nit' => $this->nit,
            'seguro' => $this->seguro,
            'afp' => $this->afp,
            'ingreso' => $this->ingreso,
            'salario' => $this->salario,
            // 'cargo' => $this->cargo,
        ]);

        $createEmpleado->save();

        $this->dispatch('noty', msg: 'Producto registrado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');

        return redirect()->route(route: 'empleados');
    }

    public function Edit($id)
    {
        $selectEmpleado = Empleado::find($id);
        $this->nombre = $selectEmpleado->nombre;
        $this->nacimiento = $selectEmpleado->nacimiento;
        $this->dui = $selectEmpleado->dui;
        $this->nit = $selectEmpleado->nit;
        $this->seguro = $selectEmpleado->seguro;
        $this->afp = $selectEmpleado->afp;
        $this->ingreso = $selectEmpleado->ingreso;
        $this->salario = $selectEmpleado->salario;
        // $this->cargo = $selectEmpleado->cargo;
        $this->selected_id = $selectEmpleado->id;

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $updateEmpleado = Empleado::find($this->selected_id);
        $updateEmpleado->nombre = $this->nombre;
        $updateEmpleado->nacimiento = $this->nacimiento;
        $updateEmpleado->dui = $this->dui;
        $updateEmpleado->nit = $this->nit;
        $updateEmpleado->seguro = $this->seguro;
        $updateEmpleado->afp = $this->afp;
        $updateEmpleado->ingreso = $this->ingreso;
        $updateEmpleado->salario = $this->salario;

        // $updateEmpleado->cargo = $this->cargo;

        $updateEmpleado->save();

        $this->dispatch('noty', msg: 'UNIDAD Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');

        return redirect()->route(route: 'empleados');
    }

    

    #[On('destroy')]

    public function destroy($id)
    {
        $deleteUnidad = Empleado::findOrFail($id);
        $deleteUnidad->delete();

        $this->resetPage();
        $this->ResetInt();
        $this->dispatch('noty', msg: 'UNIDAD ELIMINADA CON ÉXITO');
    }



    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->nombre = '';
        $this->nacimiento = '';
        $this->dui = '';
        $this->nit = '';
        $this->seguro = '';
        $this->afp = '';
        $this->ingreso = '';
        $this->salario = '';
        $this->cargo = '';
        $this->resetValidation();
    }
}
