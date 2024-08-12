<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle}} </b></h5>
            <div class="dropdown">
                @can('Parametros_Create')
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
                <th class="text-center">Caja #</th>
                <th class="text-center">Sucursal</th>
                <th class="text-center">Token</th>
                <th class="text-center">Actions</th>
            </thead>
            <tbody>
                @foreach ( $parametros as $parametro )
                <tr>
                    <td class="text-center">{{ $parametro->caja }}</td>
                    <td class="text-center">{{ $parametro->nombre }}</td>
                    <td class="text-center">{{ $parametro->token }}</td>
                    <td class="text-center">
                        @can('Parametros_Update')
                        <button class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm" wire:click="Edit({{ $parametro->id }})"><i class="ri-edit-box-line"></i></button>
                        @endcan
                        @can('Parametros_Destroy')
                        <a href="#" onclick="confirmDestroy({{ $parametro->id }})" class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i class="ri-delete-bin-line"></i></a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$parametros->links()}}
    @include('livewire.parametros.form')
</div>
@include('common.notis')
