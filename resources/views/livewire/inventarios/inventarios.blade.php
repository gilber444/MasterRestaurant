<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle}} </b></h5>
            @if($rol === 'Super' OR $rol === 'Administrador' )
            <div class="dropdown">
                <select wire:model.lazy="sucursalSeleccionada" class="form-select">
                    <option value="Global">Global, Todas las Sucursales</option>
                    @foreach ($sucursales as $sucursal )
                    <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <hr class="my-2">
        @include('common.searchbox')
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-sm">
            <thead>
                <th class="text-center">Código de barras</th>
                <th class="text-center">Nombre del producto</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Medida</th>
                <th class="text-center">Existencia</th>
                <th class="text-center">Lugar</th>
            </thead>
            <tbody>
                @foreach ( $data as $dat )
                <tr>
                    <td class="text-center"><b>{{ $dat->Rproductos->codigo_barra }}</b></td>
                    <td>{{ $dat->Rproductos->producto}}</td>
                    <td class="text-center">{{ $dat->Rproductos->RcategoriaProducto->categoria }}</td>
                    <td class="text-center">{{ $dat->Rproductos->RunidadMedida->nombre }}</td>
                    <td class="text-center">{{ $dat->existencia }}</td>
                    <td class="text-center">{{ $dat->Rsucursal->nombre }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$data->links()}}
</div>
@include('common.notis')
