<?php

namespace App\Livewire;

use App\Models\Parametros;
use App\Models\Marcas;
use App\Models\Actividades as ActividadesModel;
use App\Models\Apertura;
use App\Models\Cortes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Actividades extends Component
{
    public $caja, $records, $selectedCaja = [], $monto = [],  $actividadesMarcasIds,  $marcasOcupadas;

    public $estado, $sucursal, $empresa, $fechaApertura, $horaApertura, $inicio, $fin, $FcierreApertura, $HcierreApertura, $cajero;

    public function mount()
    {
        $this->actividadesMarcasIds = ActividadesModel::pluck('marca')->toArray(); // Carga los IDs de marcas en actividades
        $userId = Auth::id();
        $this->marcasOcupadas = ActividadesModel::where('user', $userId)
            ->pluck('marca')
            ->toArray();
    }
    public function render()
    {
        $cajas = Parametros::with('Rsucursales')->where('multiple', 'Si')->get();

        return view('livewire.actividades.actividades', [
            'data' => $cajas,
            'marcas' => $this->Allmarcas(),
            'cajas' => $this->Allcajas(),
            'actividadesMarcasIds' => $this->actividadesMarcasIds,
        ]);
    }

    public function Allmarcas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Marcas::orderBy('id', 'asc');
        } else {
            $query = Marcas::leftJoin('actividades', 'marcas.id', '=', 'actividades.marca') // Cambia a leftJoin
                ->select('marcas.*', 'actividades.fecha', 'actividades.hora', 'actividades.status', 'actividades.caja')
                ->orderBy('marcas.id', 'asc');
        }

        $this->records = $query->count();

        return $query->get();
    }

    public function Allcajas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Parametros::orderBy('id', 'asc');
        } else {
            // $query = Parametros::orderBy('id', 'asc');
            $query = Parametros::whereDoesntHave('Ractividades')->orderBy('id', 'asc');

        }

        $this->records = $query->count();

        return $query->get();
    }


    public function validar($marcaId)
    {
        // Definir reglas de validación
        $rules = [
            'selectedCaja.' . $marcaId => 'required|not_in:Elegir',
        ];
        foreach ($this->monto as $key => $value) {
            $rules['monto.' . $key] = 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0.01';
        }

        // Definir mensajes personalizados
        $messages = [
            'selectedCaja.' . $marcaId . '.required' => 'El número de caja es requerido para la marca',
            'selectedCaja.' . $marcaId . '.not_in' => 'Seleccione un número de caja diferente a "Elegir" para la marca',
            'monto.required' => 'El campo de monto de apertura es obligatorio.',
            'monto.numeric' => 'El monto de apertura debe ser un número.',
            'monto.regex' => 'El monto de apertura debe ser numérico y puede tener hasta dos decimales.',
            'monto.min' => 'El monto de apertura debe ser de al menos 0.01.',
        ];
        foreach ($this->monto as $key => $value) {
            $messages['monto.' . $key . '.required'] = 'El campo de monto de apertura es obligatorio.';
            $messages['monto.' . $key . '.numeric'] = 'El monto de apertura debe ser un número.';
            $messages['monto.' . $key . '.regex'] = 'El monto de apertura debe ser numérico y puede tener hasta dos decimales.';
            $messages['monto.' . $key . '.min'] = 'El monto de apertura debe ser de al menos 0.01.';
        }

        // Validar los datos
        $this->validate($rules, $messages);

        // Obtener caja seleccionada y verificar actividad
        $cajaSeleccionada = $this->selectedCaja[$marcaId];
        $caja = Parametros::with('Rsucursales')->find($cajaSeleccionada);

        $b = ActividadesModel::where('caja', $caja->id)
            ->where('sucursal', $caja->sucursal)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'Activo')
            ->first();

        $user = Auth::user();

        // Verificar si la caja ya fue aperturada
        if ($b) {
            if ($b->user == $user->id) {
                // Sesión para el usuario actual si la caja está abierta
                session(['empresa' => $caja->empresa]);
                session(['sucursal' => $caja->sucursal]);
                session(['caja' => $caja->id]);
                session(['actividad' => $b->id]);
                return redirect()->route('pos', ['id' => $marcaId]);
            } else {
                $this->dispatch('noty-error', msg: 'Esta caja ya fue aperturada por otro usuario y no se puede utilizar');
            }
        } else {
            $exists = ActividadesModel::where('user', $user->id)->exists();

            if ($exists) {
                $this->dispatch('noty-error', msg: 'No se puede abrir 2 cajas con el mismo usuario');
            } else {
                // Apertura de una nueva actividad
                $marca = Marcas::find($marcaId);
                $montoSeleccionado = $this->monto[$marcaId];

                $a = ActividadesModel::create([
                    'user' => $user->id,
                    'empresa' => $caja->empresa,
                    'sucursal' => $caja->sucursal,
                    'caja' => $caja->id,
                    'marca' => $marca->id,
                    'fecha' => now()->toDateString(),
                    'hora' => now()->toTimeString(),
                    'status' => 'Activo'
                ]);

                // Validar si la caja ya ha sido aperturada hoy
                $vali = Apertura::where('caja', session('caja'))
                    ->where('sucursal', session('sucursal'))
                    ->where('empresa', session('empresa'))
                    ->where('fechaApertura', $this->fechaApertura)
                    ->first();

                if ($vali) {
                    $this->dispatch('noty', msg: 'No se puede aperturar dos veces una caja');
                } else {
                    // Apertura de caja si no está aperturada
                    $aper = Apertura::create([
                        'caja' => $caja->id,
                        'sucursal' => $caja->sucursal,
                        'empresa' => $caja->empresa,
                        'fechaApertura' => now()->toDateString(),
                        'horaApertura' => now()->toTimeString(),
                        'inicio' => $montoSeleccionado,
                        'final' => null,
                        'FcierreApertura' => null,
                        'HcierreApertura' => null,
                        'estado' => 'Aperturado',
                        'cajero' => Auth::user()->id,
                    ]);

                    // Realiza Insert en Cortes
                    $ultimoCorte = Cortes::max('corte');
    
                    // Si no hay valores previos, empieza desde 1
                    $nuevoCorte = $ultimoCorte ? $ultimoCorte + 1 : 1;

                    $corte = Cortes::create( [
                        'caja' => $caja->id,
                        'sucursal' => $caja->sucursal,
                        'empresa' => $caja->empresa,
                        'corte' => $nuevoCorte,
                        'fecha' => now()->toDateString(),
                        'hora' => now()->toTimeString(),
                        'estado' => 'Activo'
                    ]);

                    // Restablecer la interfaz de apertura y redirigir
                    $this->resetUIApertura();
                    $this->dispatch('noty', msg: 'Caja Aperturada');
                    session(['empresa' => $caja->empresa]);
                    session(['sucursal' => $caja->sucursal]);
                    session(['caja' => $caja->id]);
                    session(['actividad' => $a->id]);
                    session(['monto' => $montoSeleccionado]);

                    return redirect()->route('pos', ['id' => $marcaId]);
                }
            }


        }
    }

    public function resetUIApertura()
    {
        $this->fechaApertura = '';
        $this->horaApertura = '';
        $this->monto = '';
    }


    public function validarOpen($marcaId, $cajaSeleccionada)
    {
        // Si pasa la validación, puedes manejar los datos aquí
        $caja = Parametros::with('Rsucursales')->find($cajaSeleccionada);

        //dd($caja);

        $b = ActividadesModel::where('caja', operator: $caja->id)
            ->where('sucursal', $caja->sucursal)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'Activo')
            ->first();

        $user = Auth::user();

        if ($b) {
            if ($b->user == $user->id) {
                session(['empresa' => $caja->empresa]);
                session(['sucursal' => $caja->sucursal]);
                session(['caja' => $caja->id]);
                session(['actividad' => $b->id]);

                return redirect()->route('pos', ['id' => $marcaId]);
            } else {
                $this->dispatch('noty-error', msg: 'Esta caja ya fue aperturada por otro usuario y no se puede utilizar');
            }
        }
    }
}
/*
<?php

namespace App\Http\Livewire;

use App\Models\Actividades;
use App\Models\Parametros;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActividadesController extends Component
{
    public $caja;

    public function render()
    {
        $cajas = Parametros::with('sucursales')->where('multiple', 'Si')->get();
        return view('livewire.actividades.actividades', ['data' => $cajas])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Validad()
    {
        $rules = [
            'caja' => 'required|not_in:Elegir'
        ];

        $messages = [
            'caja.required' => 'Numero de Caja es requerido',
            'caja.not_in:Elegir' => 'Seleccione un numero de caja diferente a elegit',
        ];

        $this->validate($rules, $messages);

        $caja = Parametros::with('sucursales')->find($this->caja);

        $b = Actividades::where('caja', $caja->id)
        ->where('sucursal', $caja->sucursales->id)
        ->whereDate('created_at', Carbon::today())
        ->where('status', 'Activo')
        ->first();

        $user = Auth::user();

        if($b)
        {
            if($b->user == $user->id)
            {
                session(['empresa' => $caja->sucursales->empresa]);
                session(['sucursal' => $caja->sucursal]);
                session(['caja' => $caja->id]);
                session(['actividad' => $b->id]);

                return redirect()->route('pos');
            }
            else
            {
                $this->emit('item-error', 'Esta caja ya fue aperturada por otro usuario y no se puede utilizar');

            }
        }
        else
        {
            $a = Actividades::create([
                'user' => $user->id,
                'empresa' => $caja->sucursales->empresa,
                'sucursal' => $caja->sucursal,
                'caja' => $caja->id,
                'status'=> 'Activo'
            ]);

                session(['empresa' => $caja->sucursales->empresa]);
                session(['sucursal' => $caja->sucursal]);
                session(['caja' => $caja->id]);
                session(['actividad' => $a->id]);
                return redirect()->route('pos');
        }

    }
}

 */
