<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle}} </b></h5>
            <div class="dropdown">
                <a href="{{ route('nuevo_ajustes') }}" class="btn btn-primary btn-rounded mb-2" > <i class="fa-solid fa-plus"></i> Agregar Ajuste</a>
            </div>
        </div> 
        <hr class="my-2">
        @include('common.searchbox')
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-sm">
            <thead>
                <th class="text-center">ID</th>
                <th class="text-center">FECHA</th>
                <th class="text-center">DETALLE</th>
                <th class="text-center">SUCURSAL</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">TIPO</th>
                <th class="text-center">ESTATUS</th>
                <th class="text-center">ACTIONS</th>
            </thead>
            <tbody>
                {{-- @foreach ( $ajustes as $ajuste )
                        <tr>
                            <td class="text-center">{{ $ajuste->id }}</td>
                            <td class="">{{ $ajuste->fecha }}</td>
                            <td class="">{{ $ajuste->detalle }}</td>
                            <td class="">{{ $ajuste->sucursal }}</td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="text-black" wire:click="cargarDetallesAjustes('{{ $ajuste->id }}')">
                                    @php
                                        $totalProductos = DB::table('detalle_ajustes')->where('ajuste', $ajuste->id)->whereNull('detalle_ajustes.deleted_at')->sum('cantidad');
                                        echo($totalProductos);
                                    @endphp
                                </a>
                            </td>
                            <td class="text-center">{{ $ajuste->tipo }}</td>
                            <td class="text-center">
                                    <span class="badge 
                                        @if($ajuste->status == 'Realizado') 
                                            bg-label-success 
                                        @elseif($ajuste->status == 'Pendiente') 
                                            bg-label-warning 
                                        @else 
                                            bg-label-secondary
                                        @endif 
                                        text-uppercase">
                                        {{ $ajuste->status }}
                                    </span>
                            </td>
                            <td class="text-center">
                                {{-- @if ($ajuste->status !== 'Anulado' && DB::table('detalle_ajustes')->where('ajuste', $ajuste->id)->whereNull('detalle_ajustes.deleted_at')->count() > 0)
                                    <a href="javascript:void(0)" wire:click="anular('{{$ajuste->id}}')" class="btn btn-primary"> 
                                        <i class="fa-solid fa-box-archive"> Anular</i>
                                    </a>
                                @endif --}}
                                {{-- @if ($ajuste->status !== 'Anulado')
                                <a class="btn btn-warning" href="javascript:void(0);" wire:click="Edit('{{$ajuste->id}}')"><i class="bx bx-edit-alt"></i>Editar</a>
                                @endif --}}
                                {{-- @if(DB::table('detalle_ajustes')->where('ajuste', $ajuste->id)->whereNull('detalle_ajustes.deleted_at')->count() == 0)
                                <a class="btn btn-danger" href="javascript:void(0);"  onclick="Confirm('{{$ajuste->id}}')"><i class="bx bx-trash"></i>Eliminar</a>
                                @endif --}}
                            </td>
                        </tr>
                
            </tbody>
        </table>
    {{-- @include('livewire.ajustes.nuevo_ajustes') --}}
    </div>
    {{$ajustes->links()}}
</div>
@include('common.notis') 
