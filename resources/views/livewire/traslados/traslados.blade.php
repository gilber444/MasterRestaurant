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
                                <th class="text-center">ID</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Sucursal - <span style="font-size:0.6rem">orig<span></th>
                                <th class="text-center">Sucursal - <span style="font-size:0.6rem">dest<span></th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @forelse ($unidadesmedidas as $um)
                                <tr>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $um->id }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $um->nombre }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;">{{ $um->simbolo }}</td>
                                    <td class="text-center">
                                        @if($um->estado == '1')
                                            <span class="badge bg-label-success rounded-pill">Si</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill gap-3" role="group" >
                                            @can('Traslados_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $um->id }}, true)"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Traslados_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $um->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Sin resultados</td>
                                </tr>
                            @endforelse
                        </tbody> --}}

                    </table> 
                </div>
            </div>
            <div class="card-footer p-1">
            {{-- {{ $unidadesmedidas->links() }} --}}
            </div>
            {{-- @include('livewire.productos_um.forms') --}}
            @include('common.notis')
        </div>
    </div>
</div>



