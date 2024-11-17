<?php

namespace App\Livewire;

use App\Models\ActividadEconomica;
use App\Models\Actividades;
use App\Models\Apertura;
use App\Models\Categorias;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\DetallePos;
use App\Models\Distritos;
use App\Models\Empresas;
use App\Models\Factura;
use App\Models\FormaPago;
use App\Models\IdentificacionReceptor;
use App\Models\Inventario;
use App\Models\kardex;
use App\Models\Lineas;
use App\Models\Municipio;
use App\Models\Parametros;
use App\Models\Pos as ModelsPos;
use App\Models\Precios;
use App\Models\ProductoMenu;
use App\Models\RecetaProductos;
use App\Models\Sucursales;
use App\Models\tempPos;
use App\Models\TipoPersona;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Pos extends Component
{
    use WithPagination;

    public $nombreCliente, $tipoCliente, $nit, $dui, $registro, $correo, $telefono, $celular, $direccion, $departamento, $municipio, $tipoPersona, $homologado, $distrito, $actividad, $departamentos, $municipios, $distritos, $tipoPersonas, $identificacion, $identificacions, $actividadEconomica, $selected_id, $pagination = 10;

    public $disableDui = false;
    public $disableHomologado = false;

    //para generar las ventas
    public $formas, $efectivo, $cambio, $factura, $comprobante, $tipoPedido, $idC, $nombreC, $fecha, $correlativo, $direccionV, $cant = [], $cost = [];

    //variables de apertura de caja
    public $estado, $sucursal, $empresa, $fechaApertura, $horaApertura, $inicio, $fin, $FcierreApertura, $HcierreApertura, $montoApertura, $cajero, $aperturas, $aperturas2, $valid, $corteActivo, $act = 0, $parametros;

    //variables
    public $pageTitle, $records, $search, $componentName, $lineas, $categorias, $cantidad = [], $platillos, $observaciones = [], $marcaId, $items, $estadoAcordeon = [], $detCaja, $facturas, $tipoFact = '', $receta, $existencias, $totalPagar, $duiC, $registroC;

    //para los cierres de caja
    public $showModalCorteZ = false, $showModalCorteZ2 = false,  $showModalCorteX = false,  $showModalAutenticate = false, $showModalAutenticate2 = false,  $showModalAutenticateX = false,
    $username, $password, $username2, $password2, $modalUpdated, $b100, $b100R, $b50, $b50R, $b20, $b20R, $b10, $b10R, $b5, $b5R, $b1, $b1R, $bd1, $bd1R, $b025, $b025R, $b010, $b010R, $b005, $b005R, $b001, $b001R, $totalEfectivo, $totalDiferencia, $totalTarjetas, $totalCheque, $totalCreditos, $totalVentas, $totalRemesas, $totalDevoluciones, $totalAnulaciones, $totalSumas, $totalSumaResta, $totalEfectivo2, $totalDiferencia2, $totalTarjetas2, $totalCheque2, $totalCreditos2, $totalVentas2, $totalRemesas2, $totalDevoluciones2, $totalAnulaciones2, $totalSumas2, $totalSumaResta2, $cortes, $cortes2;

    //para los cortes X
    public $usernamex, $passwordx, $totalEfectivox, $totalDiferenciax, $totalTarjetasx, $totalChequex, $totalCreditosx, $totalVentasx, $totalRemesasx, $totalDevolucionesx, $totalAnulacionesx, $totalSumasx, $totalSumaRestax, $cortesx;

    public function toggleAcordeon($id)
    {
        $this->estadoAcordeon[$id] = !($this->estadoAcordeon[$id] ?? false);
    }

    public function mount($id)
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ventas';
        $this->marcaId = $id;

        $this->Carrito();
        $this->cargaDatos();
        $this->actualizarTotal();

        $this->detCaja = Actividades::with(['Rusuario', 'Rmarca'])
            ->where('marca', $this->marcaId)
            ->where('user', Auth::user()->id)
            ->where('caja', session('caja'))
            ->get();

        $this->items = tempPos::where('user', Auth::user()->id)->where('marca', $this->marcaId)->get();

        $this->lineas = Lineas::where('marca', $this->marcaId)->get();
        $this->categorias = Categorias::whereIn('linea', $this->lineas->pluck('id'))->get();
        $this->platillos = Precios::with('Rproductos')
            ->where(function ($query) {
                $query->whereIn('categoriaP', $this->categorias->pluck('id'))
                    ->orWhereHas('Rproductos', function ($subQuery) {
                        $subQuery->where('comun', 'SI');
                    });
            })
            ->whereHas('Rproductos')
            ->whereNotNull('precioVentaIva')
            ->select('id', 'precioVentaIva', 'producto')
            ->get();


        foreach ($this->platillos as $p) {
            $tmp = tempPos::where('user', Auth::user()->id)
                ->where('producto', $p->Rproductos->id)
                ->where('marca', $this->marcaId)
                ->first();

            if ($tmp) {
                $this->cantidad[$p->id] = $tmp->cantidad;
            } else {
                $this->cantidad[$p->id] = 1;
            }
        }

        $this->valid = Apertura::where('empresa', session('empresa'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('estado', 'Aperturado')->where('fechaApertura', '<>', date('Y-m-d'))->count();

        $this->estado = Apertura::where('empresa', session('empresa'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('fechaApertura', date('Y-m-d'))->where('estado', 'Aperturado')->count();

        $this->aperturas = Apertura::where('empresa', session('empresa'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('fechaApertura', date('Y-m-d'))->where('estado', 'Aperturado')->first();

        $this->aperturas2 = Apertura::where('empresa', session('empresa'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('estado', 'Aperturado')->first();
    }

    public function increment($categoriaId)
    {
        $query = Precios::with('Rproductos')->find($categoriaId);

        $tmp = tempPos::where('user', Auth::user()->id)
            ->where('producto', $query->producto)
            ->first();

        if ($tmp) {
            $tmp->cantidad++;
            $tmp->total = $tmp->cantidad * $tmp->costo;
            $tmp->save();
            $this->cantidad[$categoriaId] = $tmp->cantidad;
            $this->items = tempPos::where('user', Auth::user()->id)->where('marca', $this->marcaId)->get();
        } else {
            $this->cantidad[$categoriaId]++;
        }
        $this->actualizarTotal();
    }

    public function decrement($categoriaId)
    {
        $query = Precios::with('Rproductos')->find($categoriaId);

        $tmp = tempPos::where('user', Auth::user()->id)
            ->where('producto', $query->producto)
            ->first();

        if ($tmp) {
            if ($this->cantidad[$categoriaId] >= 1) {
                $tmp->cantidad--;
                $tmp->total = $tmp->cantidad * $tmp->costo;
                $tmp->save();
                $this->cantidad[$categoriaId]--;

                if ($tmp->cantidad == 0) {
                    $tmp->delete();
                    $this->cantidad[$categoriaId] = 1;
                }

                $this->items = tempPos::where('user', Auth::user()->id)
                    ->where('marca', $this->marcaId)
                    ->get();
            }
        }
        $this->actualizarTotal();
    }

//     public function incrementT($itemId)
//     {
//         $item = $this->items->find($itemId);

//         if ($item) {
//             $item->cantidad++;
//             $item->total = $item->cantidad * $item->costo;
//             $item->save();
//             $this->cantidad[$itemId] = $item->cantidad;
//             $this->items = tempPos::where('user', Auth::user()->id)->where('marca', $this->marcaId)->get();
//         } else {
//             $item->cantidad++;
//         }
//         $this->actualizarTotal();
//     }

//     public function decrementT($itemId)
// {
//     // Busca el item usando el ID
//     $item = $this->items->find($itemId);

//     if ($item) {
//         // Asegúrate de que la cantidad sea al menos 1 antes de decrementar
//         if ($item->cantidad >= 1) {
//             // Decrementa la cantidad
//             $item->cantidad--;
//             $item->total = $item->cantidad * $item->costo;
//             $item->save();

//             // Actualiza el valor de cantidad en la lista local de items
//             $this->items = $this->items->map(function($i) use ($item) {
//                 if ($i->id == $item->id) {
//                     $i->cantidad = $item->cantidad;
//                     $i->total = $item->total;
//                 }
//                 return $i;
//             });

//             // Si la cantidad llega a 0, elimina el item y vuelve a cargar los items
//             if ($item->cantidad == 0) {
//                 $item->delete();
//                 $this->items = tempPos::where('user', Auth::user()->id)
//                     ->where('marca', $this->marcaId)
//                     ->get();
//             }
//         }
//     }
    
//     // Actualiza el total general después del cambio
//     $this->actualizarTotal();
// }


    public function CargaDatos()
    {
        $this->departamentos = Departamento::orderBy('departamento', 'asc')->get();
        $this->municipios = Municipio::orderBy('municipio', 'asc')->get() ?? collect();
        $this->distritos = Distritos::orderBy('distrito', 'asc')->get() ?? collect();

        //cliente
        $this->tipoPersonas = TipoPersona::all();
        $this->actividadEconomica = ActividadEconomica::all();
        $this->departamentos = Departamento::all();
        $this->municipios = Municipio::all();
        $this->distritos = Distritos::all();
        $this->identificacions = IdentificacionReceptor::all();



        $empresas = Empresas::find(session('empresa'));
        $sucursales = Sucursales::find(session('sucursal'));
        $this->parametros = Parametros::find(session('caja'));
        $parametros = Parametros::find(session('caja'));
    }

    public function render()
    {
        $query = ModelsPos::with(['RformaPago:id,valor', 'Rcliente:id,nombreCliente'])
            ->when(strlen($this->search) > 0, function ($query) {
                $query->whereHas('RformaPago', function ($query) {
                    $query->where('valor', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('Rcliente', function ($query) {
                        $query->where('nombreCliente', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhere('comprobante', 'like', '%' . $this->search . '%')
                    ->orWhere('nombreC', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');

        $formasPago = FormaPago::all();
        $clientes = Cliente::all();

        $this->records = $query->count();

        $pos = $query->paginate(10);

        return view('livewire.pos.pos', [
            'lineas' => $this->lineas,
            'ventas' => $pos,
            'formasPago' => $formasPago,
            'clientes' => $clientes,
            'municipios' => Municipio::orderBy('municipio', 'asc')->get() ?? collect(),
            'departamentos' => Departamento::orderBy('departamento', 'asc')->get() ?? collect(),
            'distritos' => Distritos::orderBy('distrito', 'asc')->get() ?? collect(),
            'actividadEconomica' => ActividadEconomica::orderBy('valor', 'asc')->get() ?? collect(),
            'tipoPersonas' => TipoPersona::orderBy('valor', 'asc')->get() ?? collect(),
            'Identificacions' => IdentificacionReceptor::orderBy('valor', 'asc')->get() ?? collect(),
        ]);
    }

    public function actualizarTotal()
    {
        $this->totalPagar = tempPos::where('user', Auth::user()->id)
            ->where('marca', $this->marcaId)
            ->sum('total');
    }

    public function CorteX()
    {
        $user = Auth::user();

        $apertura = Apertura::where('empresa', session('empresa'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('estado', 'Aperturado')->first();

        $totalEfectivo = Caja::where('fecha', date('Y-m-d'))->where('tipoPago', 1)->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('estado', 'Cancelado')->where('cajero', $user->id)->where('arqueado', false)->sum('total') ?? 0;

        $totalTarjetas = Caja::where('fecha', date('Y-m-d'))->where('tipoPago', 2)->where('sucursal', session('sucursal'))->where('estado', 'Cancelado')->where('caja', session('caja'))->where('cajero', $user->id)->where('arqueado', false)->sum('total') ?? 0;

        $totalCheque =
            Caja::where('fecha', date('Y-m-d'))
                ->where('tipoPago', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('estado', 'Cancelado')
                ->where('arqueado', false)
                ->sum('total') ?? 0;

        $totalCreditos =
            Caja::where('fecha', date('Y-m-d'))
                ->where('tipoPago', 4)
                ->where('estado', 'Cancelado')
                ->where('sucursal', session('sucursal'))
                ->where('cajero', $user->id)
                ->where('caja', session('caja'))
                ->where('arqueado', false)
                ->sum('total') ?? 0;

        $primerTicket =
            Caja::where('facturador', 1)
                ->where('sucursal', session('sucursal'))
                ->whereDate('fecha', date('Y-m-d'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->orderBy('id', 'asc')
                ->value('correlativo') ?? 0;

        $ultimoTicket =
            Caja::where('facturador', 1)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->value('correlativo') ?? 0;

        $gravadosT =
            Caja::where('facturador', 1)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('subtotal') ?? 0;

        $ivaT =
            Caja::where('facturador', 1)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('iva') ?? 0;

        $totalT =
            Caja::where('facturador', 1)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('total') ?? 0;

        $consumidorDesde =
            Caja::where('facturador', 2)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->orderBy('id', 'asc')
                ->value('correlativo') ?? 0;

        $consumidorHasta =
            Caja::where('facturador', 2)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->value('correlativo') ?? 0;

        $gravadosCon =
            Caja::where('facturador', 2)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('subtotal') ?? 0;

        $ivaCon =
            Caja::where('facturador', 2)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('iva') ?? 0;

        $totalCon =
            Caja::where('facturador', 2)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('total') ?? 0;

        $CreDesde =
            Caja::where('facturador', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->orderBy('id', 'asc')
                ->value('correlativo') ?? 0;

        $CreHasta =
            Caja::where('facturador', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->orderBy('id', 'desc')
                ->value('correlativo') ?? 0;

        $gravadosCre =
            Caja::where('facturador', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('subtotal') ?? 0;

        $ivaCre =
            Caja::where('facturador', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('iva') ?? 0;

        $totalCre =
            Caja::where('facturador', 3)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', '<>', 4)
                ->sum('total') ?? 0;

        $dteDesde =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->orderBy('id', 'asc')
                ->value('numero') ?? 0;

        $dteHasta =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->orderBy('id', 'desc')
                ->value('numero') ?? 0;

        $creditosDesde =
            Caja::where('tipoPago', 4)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->orderBy('id', 'asc')
                ->value('correlativo') ?? 0;

        $creditosHasta =
            Caja::where('tipoPago', 4)
                ->where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->orderBy('id', 'desc')
                ->value('correlativo') ?? 0;

        $gravadosCredi =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', 4)
                ->sum('subtotal') ?? 0;

        $ivaCredi =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', 4)
                ->sum('iva') ?? 0;

        $totalCredi =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Cancelado')
                ->where('tipoPago', 4)
                ->sum('total') ?? 0;

        $devoluciones =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('cajero', $user->id)
                ->where('arqueado', false)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Devolucion')
                ->sum('total') ?? 0;

        $anulaciones =
            Caja::where('sucursal', session('sucursal'))
                ->where('caja', session('caja'))
                ->where('arqueado', false)
                ->where('cajero', $user->id)
                ->whereDate('fecha', date('Y-m-d'))
                ->where('estado', 'Anulado')
                ->sum('total') ?? 0;

        $percecion =
            Caja::where('sucursal', session('sucursal'))
            ->where('caja', session('caja'))
            ->where('cajero', $user->id)
            ->where('arqueado', false)
            ->whereDate('fecha', date('Y-m-d'))
            ->where('estado', 'Anulado')
            ->sum('percepcion') ?? 0;

        $remesas = Remesas::where('fecha', date('Y-m-d'))
            ->where('sucursal', session('sucursal'))
            ->where('caja', session('caja'))
            ->where('cajero', $user->id)
            ->where('estado', 'Remesado')
            ->where('arqueado', false)
            ->sum('monto') ?? 0;

        $ultimoCodigo = Arqueos::where('caja', session('caja'))
            ->where('sucursal', session('sucursal'))
            ->latest('numero')
            ->first();

            if ($ultimoCodigo) {
                $numeroSiguiente = $ultimoCodigo->numero + 1;
            }
            else
            {
                $numeroSiguiente = 1;
            }

        $arqueo = Arqueos::create([
            'numero' => $numeroSiguiente,
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            'caja' => session('caja'),
            'sucursal' => session('sucursal'),
            'empresa' => session('empresa'),
            'cajero' => $user->id,
            'tipo' => 'X',
            'efectivo' => $totalEfectivo,
            'tarjeta' => $totalTarjetas,
            'cheque' => $totalCheque,
            'credito' => $totalCreditos,
            'subtotalPagos' => $totalEfectivo + $totalTarjetas + $totalCheque,
            'devoluciones' => $devoluciones,
            'anulaciones' => $anulaciones,
            'remesas' => $remesas,
            'percepcion' => $percecion,
            'sumaTotales' => $totalEfectivo + $totalTarjetas + $totalCheque,
            'ticketDesde' => $primerTicket,
            'ticketHasta' => $ultimoTicket,
            'gravadosT' => $gravadosT / 1.13,
            'ivaT' => $ivaT,
            'subT' => $totalT,
            'totalT' => $totalT,
            'consumidorDesde' => $consumidorDesde,
            'consumidorHasta' => $consumidorHasta,
            'gravadosCon' => $gravadosCon / 1.13,
            'ivaCon' => $ivaCon,
            'subCon' => $totalCon,
            'totalCon' => $totalCon,
            'CreDesde' => $CreDesde,
            'CreHasta' => $CreHasta,
            'gravadosCre' => $gravadosCre / 1.13,
            'ivaCre' => $ivaCre,
            'subCre' => $totalCre,
            'totalCre' => $totalCre,
            'dteDesde' => $dteDesde,
            'dteHasta' => $dteHasta,
            'gravadosDTE' => $gravadosCon + $gravadosCre,
            'ivaDTE' => $ivaCon + $ivaCre,
            'subDTE' => $totalCon + $totalCre,
            'totalDTE' => $totalCon + $totalCre,
            'creditosDesde' => $creditosDesde,
            'creditosHasta' => $creditosHasta,
            'gravadosCredi' => $gravadosCredi,
            'ivaCredi' => $ivaCredi,
            'subCredi' => $totalCredi,
            'totalCredi' => $totalCredi,
            'totalGeneral' => $gravadosCon + $gravadosCre + $gravadosT - $remesas,
            'ivaGeneral' => $ivaCon + $ivaCre + $ivaT,
            'subGeneral' => $totalCon + $totalCre + $totalT- $remesas,
            'totalPercepcion' => $percecion,
            'totalGlobal' => $totalCon + $totalCre + $totalT,
            'totalEfectivo' => $this->totalEfectivox - $apertura->inicio,
            'diferencia' => $this->totalDiferenciax
        ]);

        Caja::where('fecha', date('Y-m-d'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('cajero', $user->id)->where('estado', 'Cancelado')->update(['arqueado' => true]);

        Remesas::where('fecha', date('Y-m-d'))->where('sucursal', session('sucursal'))->where('caja', session('caja'))->where('cajero', $user->id)->update(['arqueado' => true]);

        //dd($user->id);
        $act = Actividades::where('user', $user->id)->where('status', 'Activo')->where('sucursal', session('sucursal'))->where('caja', session('caja'))->first();
        $act->status= 'Cerrado';
        $act->save();

        $this->ImprimirCorteX($arqueo->id);
        Auth::logout();
        return Redirect::to('login');
        //$this->ImprimirCorteX($arqueo->id);
    }

    #[On('Temporal')]
    public function Temporal($id)
    {
        $user_id = Auth::user()->id;
        $query = Precios::with('Rproductos')->find($id);
        $nombre = $query->Rproductos->producto;

        // Verifica si el producto ya existe en tempPos
        $tmp = tempPos::where('user', $user_id)
            ->where('producto', $query->producto)
            ->first();

        if ($tmp) {
            // Si el producto ya existe, sumar la cantidad seleccionada
            $tmp->cantidad += $this->cantidad[$id];
            $tmp->total = $tmp->cantidad * $tmp->costo;
            $tmp->save();
        } else {
            // Si el producto no existe, crearlo con la cantidad seleccionada
            $createTemp = tempPos::create([
                'marca' => $this->marcaId,
                'producto' => $query->producto,
                'observaciones' => !empty($this->observaciones[$id]) ? $this->observaciones[$id] : null,
                'nombre' => $nombre,
                'cantidad' => $this->cantidad[$id],
                'costo' => $query->precioVentaIva,
                'total' => $this->cantidad[$id] * $query->precioVentaIva,
                'user' => $user_id,
            ]);
        }

        $this->Carrito();
        $this->actualizarTotal();
    }



    #[On('Carrito')]
    public function Carrito()
    {
        $user_id = Auth::user()->id;

        $this->items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();

        foreach ($this->items as $item) {
            $this->cantidad[$item->producto] = $item->cantidad;
            $this->cost[$item->producto] = $item->costo;
        }
    }

    #[On('deleteItem')]
    public function deleteItem($id)
    {
        $item = tempPos::find($id);

        if ($item) {
            $item->delete();
            $this->cantidad[$id] = 1;
            $this->Carrito();
        }
        $this->actualizarTotal();
    }

    public function Limpiar()
    {

        $user = Auth::user()->id;

        DB::table('temp_pos')->where('user', $user)->where('marca', $this->marcaId)->delete();

        return redirect()->route('pos', ['id' => $this->marcaId]);
        $this->actualizarTotal();
    }

    protected function rules()
    {
        $rules = [
            'formas' => 'required',
            'efectivo' => 'required',
            'comprobante' => 'required',
            'nombreC' => 'required',
            'correlativo' => 'required',
            'factura' => 'required',
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'formas.required' => 'El la forma de pago es requerid',
            'efectivo.required' => 'El efectivo es requerido',
            'comprobante.required' => 'El numero de comprobante es requerido',
            'nombreC.required' => 'El nombre del cliente es requerido',
            'condicionPago.required' => 'La condición de pago es requerida',
            'correlativo.required' => 'El numero del correlatvo es requerido',
            'factura.required' => 'El tipo de factura es requerido',
        ];
    }

    //Domicilio
    public function StoreDomicilio()
    {
        DB::beginTransaction();

        try {
            $user_id = Auth::id();
            // Obtén todos los elementos de tempPos para el usuario y marca
            $items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();

            // Verifica que la colección no esté vacía
            if ($items->isEmpty()) {
                $this->dispatch('noty-error', msg: 'No hay productos en el carrito temporal');
                return;
            }

            // Cargar recetas para cada producto en items
            foreach ($items as $item) {
                $receta = RecetaProductos::with('RProductoMenu')
                    ->where('producto', $item->producto)
                    ->first();

                if (!$receta) {
                    $this->dispatch('noty-error', msg: 'El producto ' . $item->producto . ' no cuenta con una receta');
                    return;
                }
            }

            // Verificar existencias
            $existenciasList = $this->checkExistencias();

            if (!empty($this->existencias)) {
                $this->dispatch('open-modal');
                $this->dispatch('noty-error-menu', msg: 'No hay suficientes existencias de productos en el inventario');
                return;
            }

            // Aquí especificamos el tipo de factura como "ticket"
            $this->factura = 'Ticket';

            // Crear el registro en Pos
            $pos = $this->createPos();

            // Procesar cada item en tempPos
            $this->detallePos($items, $pos);

            // Eliminar los items temporales
            tempPos::where('user', $user_id)->where('marca', $this->marcaId)->delete();

            DB::commit(); // Hacer commit de la transacción

            $this->dispatch('noty', msg: 'Venta guardada con éxito');
            $this->ResetInt();
            return redirect()->route('pos', ['id' => $this->marcaId]);
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer cambios en caso de error
            $this->dispatch('noty-error', msg: 'Error al guardar la venta: ' . $e->getMessage());
        }
    }


    // Método StoreCredito con transacción
    public function StoreCredito()
    {
        DB::beginTransaction(); // Inicia la transacción

        try {
            $this->validate($this->rules(), $this->messages());

            // Obtener el ID del usuario
            $user_id = Auth::id();
            $items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();
            foreach ($items as $item) {
                $receta = RecetaProductos::with('RProductoMenu')
                    ->where('producto', $item->producto)
                    ->first();

                if (!$receta) {
                    $this->dispatch('noty-error', msg: 'El producto ' . $item->producto . ' no cuenta con una receta');
                    return;
                }
            }

            // Verificar existencias
            $existenciasList = $this->checkExistencias();

            if (!empty($this->existencias)) {
                $this->dispatch('open-modal');
                $this->dispatch('noty-error-menu', msg: 'No hay suficientes existencias de productos en el inventario');
                return;
            }

            // Crear el registro en Pos
            $pos = $this->posCreate(); // Aquí se llama correctamente

            // Procesar cada item en tempPos
            $this->detallePos($items, $pos);

            // Eliminar los items temporales
            tempPos::where('user', $user_id)->where('marca', $this->marcaId)->delete();

            DB::commit(); // Hacer commit de la transacción

            $this->dispatch('noty', msg: 'Venta guardada con éxito');
            $this->ResetInt();
            return redirect()->route('pos', ['id' => $this->marcaId]);
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer cambios en caso de error
            $this->dispatch('noty-error', msg: 'Error al guardar la venta: ' . $e->getMessage());
        }
    }

    // Método StoreConsumidor con transacción
    public function StoreConsumidor()
    {
        $this->validate($this->rules(), $this->messages());

        DB::beginTransaction(); // Inicia la transacción

        try {
            $user_id = Auth::id();
            $items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();
            foreach ($items as $item) {
                $receta = RecetaProductos::with('RProductoMenu')
                    ->where('producto', $item->producto)
                    ->first();

                if (!$receta) {
                    $this->dispatch('noty-error', msg: 'El producto ' . $item->producto . ' no cuenta con una receta');
                    return;
                }
            }

            // Verificar existencias
            $existenciasList = $this->checkExistencias();

            // Crear el registro en Pos
            $pos = $this->posCreate();

            // Procesar cada item en tempPos
            $this->detallePos($items, $pos);

            // Eliminar los items temporales y hacer commit de la transacción
            tempPos::where('user', $user_id)->where('marca', $this->marcaId)->delete();

            DB::commit(); // Hacer commit de la transacción

            $this->dispatch('noty', msg: 'Venta guardada con éxito');
            $this->ResetInt();
            return redirect()->route('pos', ['id' => $this->marcaId]);
        } catch (\Exception $e) {
            DB::rollBack(); // Deshacer cambios en caso de error
            $this->dispatch('noty-error', msg: 'Error al guardar la venta: ' . $e->getMessage());
        }
    }


    // Función para verificar existencias
    private function checkExistencias()
    {
        $existenciasList = [];
        $user_id = Auth::id();

        // Obtener los items del usuario y la marca
        $items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();

        // Asegúrate de que solo estamos tratando con un solo item
        if ($items->isEmpty()) {
            return []; // No hay items para procesar
        }

        // Obtener el primer producto de los items
        $productoSeleccionado = $items->first()->producto;


        $recetaProductos = RecetaProductos::where('producto', $productoSeleccionado)->get();

        foreach ($recetaProductos as $recetaProducto) {
            $cantidad = $recetaProducto->cantidad;
            $inventario = Inventario::where('producto', $recetaProducto->producto_primary)->first();

            if ($inventario) {
                $existencia = $inventario->existencia;

                if ($cantidad > $existencia) {
                    $existenciasList[] = [
                        'producto_id' => $recetaProducto->producto_primary,
                        'producto_name' => $recetaProducto->RProducto->producto,
                        'existencia_number' => $existencia,
                        'cantidad_solicitada' => $cantidad,
                    ];
                }
            }
        }

        // Si hay existencias insuficientes, muestra un mensaje
        if (!empty($existenciasList)) {
            // Puedes personalizar el mensaje según la cantidad de productos sin existencia
            $this->dispatch('open-modal');
            $this->dispatch('noty-error-menu', msg: 'No hay suficientes existencias de los siguientes productos en el inventario: ' . implode(', ', array_column($existenciasList, 'producto_name')));
            return []; // O retornar $existenciasList si necesitas más detalles
        }

        return $existenciasList; // Retorna la lista de existencias si todo está bien
    }

    // Función para preparar los datos de Pos
    public function createPos()
    {
        $this->fecha = now();

        if ($this->factura === 'Ticket') {
            // Validaciones para el tipo de factura "ticket"
            $this->validate([
                'formas' => 'required',
                'efectivo' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            ]);

            $this->rules([
                'formas.required' => 'La forma de pago es requerida',
                'efectivo.required' => 'El efectivo es requerido',
                'efectivo.numeric' => 'El efectivo debe ser un número válido',
                'efectivo.regex' => 'El efectivo debe ser un número válido con hasta dos decimales',
            ]);

            return $this->posCreateTicket();
            return $this->detallePos($items, $pos);
        } else {
            // Validaciones para otros tipos de factura
            $this->validate([
                'formas' => 'required',
                'efectivo' => 'required|numeric',
                'cambio' => 'nullable|numeric',
                'factura' => 'required|string',
                'comprobante' => 'nullable|string',
                'idC' => 'required|string',
                'correlativo' => 'required|string',
                'estado' => 'required|string',
            ]);

            $this->rules([
                'formas.required' => 'La forma de pago es requerida',
                'efectivo.required' => 'El efectivo es requerido',
                'efectivo.numeric' => 'El efectivo debe ser un número válido',
                'cambio.numeric' => 'El cambio debe ser un número válido',
                'factura.required' => 'El tipo de factura es requerido',
                'comprobante.string' => 'El comprobante debe ser una cadena de texto',
                'idC.required' => 'El ID del cliente es requerido',
                'correlativo.required' => 'El correlativo es requerido',
                'estado.required' => 'El estado es requerido',
            ]);

            return $this->posCreate();
        }
    }

    // Método para retornar solo los datos para "ticket"
    private function posCreateTicket()
    {
        $this->fecha = now();
        return ModelsPos::create([
            'formas' => $this->formas,
            'efectivo' => $this->efectivo,
            'cambio' => $this->cambio,
            'factura' => $this->factura,
            'fecha' => $this->fecha,
            'comprobante' => null,
            'idC' => empty($this->idC) ? 1 : $this->idC,
            'correlativo' => null,
            'estado' => 'Cancelado',
            'tipoPedido' => $this->tipoPedido,
            'direccion' => empty($this->direccionV) ? null : $this->direccionV,
            'usuario' => Auth::id(),
        ]);
    }

    private function posCreate()
    {
        $this->fecha = now();

        // Crear el registro en Pos
        return ModelsPos::create([
            'formas' => $this->formas,
            'efectivo' => $this->efectivo,
            'cambio' => $this->cambio,
            'factura' => $this->factura,
            'fecha' => $this->fecha,
            'comprobante' => $this->comprobante,
            'idC' => $this->idC,
            'correlativo' => $this->correlativo,
            'estado' => $this->estado,
            'tipoPedido' => $this->tipoPedido,
            'direccion' => empty($this->direccionV) ? null : $this->direccionV,
            'usuario' => Auth::id(),
        ]);
    }

    // Función para procesar los items y actualizar inventario y kardex
    private function detallePos($items, $pos)
    {
        foreach ($items as $item) {
            $recetas = RecetaProductos::with('RProducto')
                ->where('producto', $item->producto)
                ->get();

            foreach ($recetas as $receta) {

                $productoPrimario = $receta->RProducto;

                $inventario = Inventario::where('producto', $productoPrimario->id)->first();

                $nuevaExistencia = $inventario->existencia - $receta->cantidad;
                $inventario->update(['existencia' => $nuevaExistencia]);

                $ultimoKardex = Kardex::where('producto', $productoPrimario->id)
                    ->where('inventario', $inventario->id)
                    ->latest()
                    ->first();

                Kardex::create([
                    'empresa' => Auth::user()->empresa,
                    'sucursal' => 1,
                    'producto' => $productoPrimario->id,
                    'inventario' => $inventario->id,
                    'descripcion' => 'Venta de producto ' . $productoPrimario->id,
                    'fecha' => now()->toDateString(),
                    'hora' => now()->toTimeString(),
                    'ingreso' => 0.00,
                    'totalingreso' => 0.00,
                    'egreso' => $receta->cantidad,
                    'totalegreso' => $item->costo * $receta->cantidad,
                    'costoUmovimiento' => $item->costo,
                    'costoUnitario' => $ultimoKardex ? $ultimoKardex->costoUnitario : 0,
                    'saldo' => $nuevaExistencia,
                    'saldototal' => $ultimoKardex ? $ultimoKardex->saldototal - ($item->costo * $receta->cantidad) : 0,
                ]);
            }

            DetallePos::create([
                'pos' => $pos->id,
                'producto' => $item->producto,
                'inventario' => 80,
                'medida' => $productoPrimario->unidad_medida,
                'cantidad' => $item->cantidad,
                'descargar' => $item->cantidad,
                'precio' => $item->costo,
                'descuento' => null,
                'totalDescuento' => null,
                'total' => $item->total,
            ]);
        }
    }

    public function cambioEfectivo()
    {
        $user_id = Auth::id();
        $items = tempPos::where('user', $user_id)->where('marca', $this->marcaId)->get();
        $totalCost = 0;

        foreach ($items as $item) {
            $totalCost += ($item->costo * $item->cantidad);
        }

        if ($this->efectivo < $totalCost) {
            $this->dispatch('noty-error', msg: 'El efectivo ingresado es menor al total.');
            $this->cambio = '';
            $this->efectivo = '';
        } else {
            $this->cambio = number_format(max(0, $this->efectivo - $totalCost), 2);
        }
    }


    public function Nombre()
    {
        // Buscar el cliente por nombre o número de DUI
        $cliente = Cliente::where('nombreCliente', 'like', '%' . $this->idC . '%')
            ->orWhere('dui', 'like', '%' . $this->dui . '%')
            ->first();

        if ($cliente) {
            // Si se encuentra un cliente, asignar valores a las propiedades
            $this->idC = $cliente->id;;
            $this->dui = $cliente->dui;
        } else {
            // Limpiar los campos si no se encuentra ningún cliente
            $this->idC = '';
            $this->dui = '';
        }
    }


    public function actualizarPorIdC()
    {
        if ($this->idC) {
            // Buscar el cliente solo por ID
            $cliente = Cliente::find($this->idC);

            if ($cliente) {
                // Si se encuentra el cliente, actualizar `registroC`
                $this->registroC = $cliente->registro;
            } else {
                // Limpiar `registroC` si no se encuentra un cliente
                $this->registroC = '';
            }
        }
    }

    //buscar cliente en credito fiscal
    public function buscarPorDuiC()
    {
        if ($this->duiC) {
            // Buscar el cliente solo por registro
            $cliente = Cliente::where('dui', '=', $this->duiC)->first();

            if ($cliente) {
                $this->idC = $cliente->id;
            } else {
                $this->idC = '';
            }
        }
    }

    //buscar cliente en consumidor final
    public function buscarPorIdC()
    {
        if ($this->idC) {
            // Buscar el cliente solo por ID
            $cliente = Cliente::find($this->idC);

            if ($cliente) {
                // Si se encuentra el cliente, actualizar `registroC`
                $this->duiC = $cliente->dui;
            } else {
                // Limpiar `registroC` si no se encuentra un cliente
                $this->duiC = '';
            }
        }
    }

    public function actualizarPorRegistroC()
    {
        if ($this->registroC) {
            // Buscar el cliente solo por registro
            $cliente = Cliente::where('registro', '=', $this->registroC)->first();

            if ($cliente) {
                $this->idC = $cliente->id;
            } else {
                $this->idC = '';
            }
        }
    }

    public function ResetFactura()
    {
        $this->factura = '';
        $this->resetValidation();
    }

    public function ResetInt()
    {
        $this->formas = '';
        $this->efectivo = '';
        $this->cambio = '';
        $this->comprobante = '';
        $this->idC = '';
        $this->fecha = '';
        $this->correlativo = '';
        $this->estado = '';
        $this->direccion = '';
        $this->duiC = '';
        $this->registroC = '';
        $this->resetValidation();
    }

    //Registro de clientes
    public function updateDepartamento()
    {
        $this->municipios = Municipio::where('departamento', $this->departamento)->get();
    }

    public function updateMunicipio()
    {
        $this->distritos = Distritos::where('municipio', $this->municipio)->get();
    }

    protected function ruless()
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


    protected function messagess()
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

    public function StoreCliente()
    {
        $this->validate($this->ruless(), $this->messagess());

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
        return redirect()->route('pos');
    }

    public function storeHomologado($homologado)
    {
        if ($homologado === 'SI') {
            $this->nit = '';
        }
    }

    public function ResetCliente()
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
        $this->resetValidation();
    }
}
