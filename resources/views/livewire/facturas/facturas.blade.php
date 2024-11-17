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
                    @can('Factura_Create')
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
                                <th class="text-center">ID</th>
                                <th class="text-center">FACTURA</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($facturas as $data)
                                <tr>
                                    <td class="text-center">{{ $data->id }}</td>
                                    <td class="text-center"> {{ $data->factura }}</td>
                                    <td class="text-center">
                                        @if($data->status === 'Activo')
                                            <span class="badge bg-label-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">Bloqueado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill" role="group">
                                            @can('Factura_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $data->id }})"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Factura_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $data->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
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
                {{ $facturas->links() }}
            </div>
            @include('livewire.facturas.forms')
        </div>
    </div>
</div>
