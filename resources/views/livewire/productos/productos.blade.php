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
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Codigo</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">UM Interno</th>
                                <th class="text-center">UM Hacienda</th>
                                <th class="text-center">Activo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td class="text-center">
                                        @if ($producto->image != null )
                                            <img src="{{ route('productos.mostrar', ['imagen' => $producto->image]) }}" alt="Imagen" class=" w-px-40 h-auto" style="height: 3rem !important;width: 3rem !important;object-fit: cover; border-radius:0.3rem">
                                        @endif
                                    </td>

                                    @if ($producto->codigo_barra == null)
                                        <td class="text-center" style="font-size: 0.8rem;">-</td>
                                    @else
                                        <td class="text-center" style="font-size: 0.8rem;">{{ $producto->codigo_barra }}</td>
                                    @endif

                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->producto }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->RcategoriaProducto->categoria}}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->Rmarcas ? $producto->Rmarcas->nombre : '-' }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->RunidadMedida->nombre }}</td>
                                    <td class="text-center" style="font-size: 0.8rem;"> {{ $producto->RunidadMedidaMH->valor  }}</td>
                                    <td class="text-center">
                                        @if($producto->presentacion == '1')
                                            <span class="badge bg-label-success rounded-pill">Si</span>
                                        @else
                                            <span class="badge bg-label-danger rounded-pill">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-pill gap-3" role="group" >
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
            @include('livewire.productos.forms')
            @include('common.notis')
        </div>
    </div>
</div>



