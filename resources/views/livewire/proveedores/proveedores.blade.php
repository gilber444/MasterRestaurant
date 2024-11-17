<div class="row">
    <div class="col-md-12">
        <div class="card height-equal">
            <div class="card-header border-l-primary border-2">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <h4>{{ $componentName }} | {{ $pageTitle }}</h4>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        @include('common.searchbox')
                    </div>
                    @can('Proveedores_Create')
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn rounded-pill btn-label-primary waves-effect"
                                data-bs-toggle="modal" data-bs-target="#MyModal">
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
                                <th class="text-center">Id</th>
                                <th class="text-center">Nombre del Proveedor</th>
                                <th class="text-center">RAzon Social</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Registro</th>
                                <th class="text-center">NIT</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($proveedores as $pro)
                                <tr>
                                    <td class="text-center"><b>{{ $pro->id }}</b></td>
                                    <td>{{ $pro->nombre }}</td>
                                    <td>{{ $pro->razon_social }}</td>
                                    <td>{{ $pro->telefono }}</td>
                                    <td>{{ $pro->registro }}</td>
                                    <td>{{ $pro->nit }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill" role="group">
                                            @can('Proveedores_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $pro->id }})"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Proveedores_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $pro->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                                            @endcan
                                        </div>
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
                {{ $proveedores->links() }}
            </div>
            @include('livewire.proveedores.forms')
        </div>
    </div>
</div>
