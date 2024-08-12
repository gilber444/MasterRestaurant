<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle}} </b></h5>
            <div class="dropdown">
                @can('Sucursales_Create')
                <button type="button" class="btn rounded-pill btn-label-primary waves-effect" data-bs-toggle="modal" data-bs-target="#MyModal">
                    <i class="ri-add-line"></i>Nuevo
                </button>
                @endcan
            </div>
        </div>
        <hr class="my-2">
        @include('common.searchbox')
    </div>
    <div class="table-responsivep">
        <table class="table table-hover table-sm">
            <thead>
                <th class="text-center">#</th>
                <th class="text-center">Empresa</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Direccion</th>
                <th class="text-center">N. Cajas</th>
                <th class="text-center">Actions</th>
            </thead>
            <tbody>
                @foreach ( $sucursales as $sucursal )
                <tr>
                    <td class="text-center">{{ $sucursal->numero }}</td>
                    <td>{{ $sucursal->empresa }}</td>
                    <td>{{ $sucursal->nombre }}</td>
                    <td>{{ $sucursal->direccion }}</td>
                    <td class="text-center">{{ $sucursal->cajas }}</td>
                    <td class="text-center">
                        @can('Sucursales_Update')
                        <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm" wire:click="Edit({{ $sucursal->id }})"><i class="ri-edit-box-line"></i></button>
                        @endcan
                        @can('Sucursales_Destroy')
                        <a href="#" onclick="confirmDestroy({{ $sucursal->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{$sucursales->links()}}
    @include('livewire.sucursales.form')
</div>
@include('common.notis')
