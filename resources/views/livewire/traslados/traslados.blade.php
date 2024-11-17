<div class="row">
    <div class="col-md-12">
        <div class="card height-equal">
            <div class="card-header border-l-primary border-2">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <h4>{{ $componentName }} | {{ $pageTitle }}</h4>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        {{-- search --}}
                        @include('common.searchbox')
                    </div>
                    @can('Traslados_Create')
                        <div class="col-sm-12 col-md-2">
                            <a type="button" href="{{ route('nuevotraslados')}}" class="btn rounded-pill btn-label-primary waves-effect">
                                <i class="ri-add-line"></i>Nuevo
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="text-center">Correlativo</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">S - <span style="font-size:0.6rem">origen<span></th>
                                <th class="text-center">S - <span style="font-size:0.6rem">destino<span></th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Solicitante</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($traslados as $traslado)
                                <tr>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $traslado->correlativo }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ \Carbon\Carbon::parse($traslado->fecha)->format('d/m/Y')  }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $traslado->Rorigen->nombre }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $traslado->Rdestino->nombre }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="text-center"
                                            wire:click="cargarProductosTraslado('{{ $traslado->id }}')">
                                            @php
                                                $totalProductos = DB::table('traslado_detalles')
                                                    ->where('traslado', $traslado->id)
                                                    ->whereNull('deleted_at')
                                                    ->sum('cantidad');
                                                echo $totalProductos;
                                            @endphp
                                        </a>
                                    </td>
                                    <td class="text-center" style="font-size: 0.8rem; text-transform: capitalize;">{{ $traslado->Rsolicitante->name }}</td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            @can('Traslados_Update')
                                                <button type="button"
                                                    class="btn dropdown-toggle waves-effect btn-outline-{{ $traslado->estado === 'Autorizado' ? 'success' : ($traslado->estado === 'Solicitado' ? 'warning' : 'danger') }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 0px; font-size: 0.8rem;"
                                                    {{ $traslado->estado === 'Rechazado' || $traslado->estado === 'Autorizado' ? 'disabled' : '' }}>
                                                    {{ $traslado->estado === 'Autorizado' ? 'Autorizado' : ($traslado->estado === 'Solicitado' ? 'Solicitado' : 'Rechazado') }}
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" style="border-radius: 0px; font-size: 0.8rem;" href="#"
                                                            wire:click.prevent="cambiarEstado({{ $traslado->id }}, 'Autorizado')">
                                                            Autorizado
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a class="dropdown-item" style="border-radius: 0px; font-size: 0.8rem;" href="#"
                                                            wire:click.prevent="cambiarEstado({{ $traslado->id }}, 'Rechazado')">
                                                            Rechazado
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endcan
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill gap-3" role="group" >
                                            @if($traslado->estado != 'Autorizado' && $traslado->estado != 'Rechazado')
                                                @if($traslado->solicitante == Auth::user()->id)
                                                    <a href="{{ route('editartraslados', ['idTraslado' => $traslado->id]) }}" class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm">
                                                        <i class="ri-edit-box-line"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('editartraslados', ['idTraslado' => $traslado->id]) }}" class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm disabled">
                                                        <i class="ri-edit-box-line"></i>
                                                    </a>
                                                @endif

                                                @can('Traslados_Destroy')
                                                    @if($traslado->solicitante == Auth::user()->id)
                                                        <a href="#" onclick="confirmDestroy({{ $traslado->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                                                    @else
                                                        <a href="#" onclick="confirmDestroy({{ $traslado->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm disabled"><i class="ri-delete-bin-line"></i></a>
                                                    @endif
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Sin resultados</td>
                                </tr>
                            @endforelse
                        </tbody> 

                    </table> 
                </div>
            </div>
            <div class="card-footer p-1">
                {{ $traslados->links() }}
            </div>
            {{-- @include('livewire.productos_um.forms') --}}
            @include('livewire.traslados.traslado_producto')
            @include('common.notis')
        </div>
    </div>
</div>



