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
                    @can('Actividades_Create')
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
                                <th class="text-center">Codigo</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($actividades as $ac)
                                <tr>
                                    <td class="text-center">{{ $ac->codigo }}</td>
                                    <td class="text-center"> {{ $ac->valor }}</td>
                                    <td class="text-center">
                                        @if($ac->status === 'Activo')
                                            <span class="badge bg-label-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">Bloqueado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill" role="group">
                                            @can('Actividades_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $ac->id }})"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Actividades_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $ac->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
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
                {{ $actividades->links() }}
            </div>
            @include('livewire.actividad_economicas.forms')
        </div>
    </div>
</div>
