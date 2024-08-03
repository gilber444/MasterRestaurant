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
                    @can('Usuarios_Create')
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
                                <th class="text-center"></th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Estatus</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $objUser)
                                <tr>
                                    <td class="text-center">
                                        @if ($objUser->image != null)
                                            <img src="{{ route('user.mostrar', ['imagen' => $objUser->image]) }}" alt="Avatar" class="avatar avatar-sm rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $objUser->name }}</td>
                                    <td class="text-center">{{ $objUser->user }}</td>
                                    <td class="text-center"> {{ $objUser->phone }}</td>
                                    <td>{{ $objUser->email }}</td>
                                    <td class="text-center">{{ $objUser->profile }}</td>
                                    <td class="text-center">
                                        @if($objUser->status === 'ACTIVE')
                                            <span class="badge bg-label-success rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">Bloqueado</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill" role="group">
                                            @can('Usuarios_Update')
                                                <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                                wire:click="Edit({{ $objUser->id }})"><i class="ri-edit-box-line"></i>
                                                </button>
                                            @endcan
                                            @can('Usuarios_Destroy')
                                                <a href="#" onclick="confirmDestroy({{ $objUser->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
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
                {{ $users->links() }}
            </div>
            @include('livewire.users.forms')
        </div>
    </div>
</div>
