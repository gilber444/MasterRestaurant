<?php

namespace App\Livewire;

use App\Models\Empresas;
use App\Models\Parametros as ModelsParametros;
use App\Models\Sucursales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Parametros extends Component
{
    use WithPagination;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $sucursal, $caja, $token, $full, $slip, $multiple, $centralizada, $tiquet, $tcorrelativo, $tresolucion, $tserie, $consumidor, $concorrelativo, $conresolucion, $conserie, $credito, $crecorrelativo, $creresolucion, $creserie, $notaCredito, $ncCorrelativo, $ncResolucion, $ncSerie, $notaDebito, $ndCorrelativo, $ndResolucion, $ndSerie, $cotizacion, $cocorrelativo, $tasa, $ventamin, $estado, $empresas, $empresa, $sucursales, $dte, $dteAutomatico, $tiquedte;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cajas Activas';
        $this->sucursal = 'Elegir...';
        $this->empresas = [];
        $this->sucursales = [];

        // Obtener el usuario autenticado
        $user = Auth::user();

        if ($user->profile == 'Super') {
            // Si el usuario es super, obtiene todas las empresas
            $this->empresas = Empresas::all();

        } else {
            // Si no es super, solo obtiene su empresa
            $this->empresas = Empresas::where('id', $user->empresa)->get();
            // También filtra las sucursales para esa empresa
            $this->empresa = $user->empresa;
            $this->updateEmpresa();
        }
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $parametros = ModelsParametros::where('caja', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $parametros = ModelsParametros::join('sucursales as s', 's.id', 'parametros.sucursal')
                ->select('parametros.*', 's.nombre')
                ->orderBy('caja', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.parametros.parametros', ['parametros' => $parametros]);
    }

    protected function rules()
    {
        $id = $this->selected_id ? $this->selected_id : null;

        return [
            'caja' => [
                'required',
                'min:1',
                $id ? Rule::unique('parametros', 'caja')->ignore($id) : 'unique:parametros,caja'
            ],
            'token' => 'required',
            'sucursal' => 'required|not_in:Elegir'
        ];
    }

    protected function messages()
    {
        return [
            'caja.required' => 'El numero de la caja es requerido',
            'caja.unique' => 'El numero de la caja ya existe',
            'caja.min' => 'El numero de caja tiene que tener mas de un caracter',
            'token.requited' => 'El nombre de la sucursal es requerido',
            'sucursal.not_in' => 'Elige un nombre de empresa diferente de elegir'
        ];
    }

    public function Store()
    {

        $this->validate($this->rules(), $this->messages());

        $para = ModelsParametros::create([
            'empresa' => $this->empresa,
            'sucursal' => $this->sucursal,
            'caja' => $this->caja,
            'token' => $this->token,
            'full' => $this->full,
            'slip' => $this->slip,
            'multiple' => $this->multiple,
            'centralizada' => $this->centralizada,
            'ticket' => $this->tiquet,
            'tcorrelativo' => $this->tcorrelativo,
            'tresolucion' => $this->tresolucion,
            'tserie' => $this->tserie,
            'consumidor' => $this->consumidor,
            'concorrelativo' => $this->concorrelativo,
            'conresolucion' => $this->conresolucion,
            'conserie' => $this->conserie,
            'credito' => $this->credito,
            'crecorrelativo' => $this->crecorrelativo,
            'creresolucion' => $this->creresolucion,
            'creserie' => $this->creserie,
            'notacredito' => $this->notaCredito,
            'nccorrelativo' => $this->ncCorrelativo,
            'ncresolucion' => $this->ncResolucion,
            'ncserie' => $this->ncSerie,
            'notadebito' => $this->notaDebito,
            'ndcorrelativo' => $this->ndCorrelativo,
            'ndresolucion' => $this->ndResolucion,
            'ndserie' => $this->ndSerie,
            'cotizacion' => $this->cotizacion,
            'cocorrelativo' => $this->cocorrelativo,
            'tasa' => $this->tasa,
            'ventamin' => $this->ventamin,
            'dte' => $this->dte,
            'dteAutomatico' =>$this->dteAutomatico,
            'tiquedte' => $this->tiquedte,
            'estado' => $this->estado,
        ]);

        $this->dispatch('noty', msg: 'Parametros registrados con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function ResetInt()
    {
        $this->selected_id = '';
        $this->sucursal = '';
        $this->caja = '';
        $this->token = '';
        $this->tiquet = '';
        $this->full = '';
        $this->slip = '';
        $this->multiple = '';
        $this->centralizada = '';
        $this->tcorrelativo = '';
        $this->tresolucion = '';
        $this->tserie = '';
        $this->consumidor = '';
        $this->concorrelativo = '';
        $this->conresolucion = '';
        $this->conserie = '';
        $this->credito = '';
        $this->crecorrelativo = '';
        $this->creresolucion = '';
        $this->creserie = '';
        $this->notaCredito = '';
        $this->ncCorrelativo = '';
        $this->ncResolucion = '';
        $this->ncSerie = '';
        $this->notaDebito = '';
        $this->ndCorrelativo = '';
        $this->ndResolucion = '';
        $this->ndSerie = '';
        $this->cotizacion = '';
        $this->cocorrelativo = '';
        $this->tasa = '';
        $this->ventamin = '';
        $this->dte = '';
        $this->dteAutomatico = '';
        $this->estado = '';
        $this->tiquedte = '';
        $this->resetValidation();
        $this->resetPage();
    }

    public function updateEmpresa()
    {
        $this->sucursales = Sucursales::where('empresa', $this->empresa)->orderBy('nombre', 'asc')->get();
    }

    public function Edit(ModelsParametros $parametro)
    {
        $this->selected_id = $parametro->id;
        $this->sucursal = $parametro->sucursal;
        $this->caja = $parametro->caja;
        $this->token = $parametro->token;
        $this->full = $parametro->full;
        $this->slip = $parametro->slip;
        $this->multiple = $parametro->multiple;
        $this->centralizada = $parametro->centralizada;
        $this->tiquet = $parametro->ticket;
        $this->tcorrelativo = $parametro->tcorrelativo;
        $this->tresolucion = $parametro->tresolucion;
        $this->tserie = $parametro->tserie;
        $this->consumidor = $parametro->consumidor;
        $this->concorrelativo = $parametro->concorrelativo;
        $this->conresolucion = $parametro->conresolucion;
        $this->conserie = $parametro->conserie;
        $this->credito = $parametro->credito;
        $this->crecorrelativo = $parametro->crecorrelativo;
        $this->creresolucion = $parametro->creresolucion;
        $this->creserie = $parametro->creserie;
        $this->notaCredito = $parametro->notacredito;
        $this->ncCorrelativo = $parametro->nccorrelativo;
        $this->ncResolucion = $parametro->ncresolucion;
        $this->ncSerie = $parametro->ncserie;
        $this->notaDebito = $parametro->notadebito;
        $this->ndCorrelativo = $parametro->ndcorrelativo;
        $this->ndResolucion = $parametro->ndresolucion;
        $this->ndSerie = $parametro->ndserie;
        $this->cotizacion = $parametro->cotizacion;
        $this->cocorrelativo = $parametro->cocorrelativo;
        $this->tasa = $parametro->tasa;
        $this->ventamin = number_format($parametro->ventamin, 2);
        $this->estado = $parametro->estado;
        $this->empresa = $parametro->empresa;
        $this->dte = $parametro->dte;
        $this->dteAutomatico = $parametro->dteAutomatico;
        $this->tiquedte = $parametro->tiquedte;
        $this->updateEmpresa();

        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $rules = [
            'caja' => 'required|min:1|unique:parametros,caja,' . $this->selected_id,
            'sucursal' => 'required|not_in:Elegir',
        ];

        $messages = [
            'caja.required' => 'El numero de la caja es requerido',
            'caja.unique' => 'El numero de la caja ya existe',
            'caja.min' => 'El numero de caja tiene que tener más de un caracter',
            'sucursal.required' => 'El nombre de la sucursal es requerido',
            'sucursal.not_in' => 'Elige un nombre de sucursal diferente de elegir',
        ];

        $this->validate($rules, $messages);
        $parametros = ModelsParametros::find($this->selected_id);
        $parametros->sucursal = $this->sucursal;
        $parametros->caja = $this->caja;
        $parametros->token = $this->token;
        $parametros->full = $this->full;
        $parametros->slip = $this->slip;
        $parametros->multiple = $this->multiple;
        $parametros->centralizada = $this->centralizada;
        $parametros->ticket = $this->tiquet;
        $parametros->tcorrelativo = $this->tcorrelativo;
        $parametros->tresulucion = $this->tresolucion;
        $parametros->tserie = $this->tserie;
        $parametros->consumidor = $this->consumidor;
        $parametros->concorrelativo = $this->concorrelativo;
        $parametros->conresolucion = $this->conresolucion;
        $parametros->conserie = $this->conserie;
        $parametros->credito = $this->credito;
        $parametros->crecorrelativo = $this->crecorrelativo;
        $parametros->creresolucion = $this->creresolucion;
        $parametros->creserie = $this->creserie;
        $parametros->notacredito = $this->notaCredito;
        $parametros->nccorrelativo = $this->ncCorrelativo;
        $parametros->ncresolucion = $this->ncResolucion;
        $parametros->ncserie = $this->ncSerie;
        $parametros->notadebito = $this->notaDebito;
        $parametros->ndcorrelativo = $this->ndCorrelativo;
        $parametros->ndresolucion = $this->ndResolucion;
        $parametros->ndserie = $this->ndSerie;
        $parametros->cotizacion = $this->cotizacion;
        $parametros->cocorrelativo = $this->cocorrelativo;
        $parametros->tasa = $this->tasa;
        $parametros->ventamin = $this->ventamin;
        $parametros->dte= $this->dte;
        $parametros->dteAutomatico = $this->dteAutomatico;
        $parametros->tiquedte = $this->tiquedte;
        $parametros->estado = $this->estado;
        $parametros->save();

        $this->dispatch('noty', msg: 'Se actualizó los datos del parámetro con éxito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]
    public function destroy($id)
    {

        ModelsParametros::find($id)->delete();
        $this->dispatch('noty', msg: 'Caja eliminada con exito');
        $this->ResetInt();
    }
}
