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
                    @can('Productos_Create')
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn rounded-pill btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#MyModal">
                                <i class="ri-add-line"></i>Nuevo
                            </button>

                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="text-center">Codigo Barra</th>
                                <th class="text-center">Productos</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Unidad Medida INT</th>
                                <th class="text-center">Unidad Medida MH</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td class="text-center" style="font-size: 0.7rem;">{{ $producto->codigo_barra }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->producto }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->categoria }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->marca }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->unidad_medida }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->unidad_medida_mh }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill" role="group">
                                            @can('Productos_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $producto->id }})"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Productos_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $producto->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                                            @endcan
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
            {{ $productos->links() }}
            </div>
            @include('livewire.admin_productos.forms')
        </div>
    </div>
</div>
