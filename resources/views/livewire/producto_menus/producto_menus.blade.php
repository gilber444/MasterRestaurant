<div class="row">
    <div class="col-md-12">
        <div class="card height-equal">
            <div class="card-header border-l-primary border-2">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h4>{{ $componentName }} | {{ $pageTitle }}</h4>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        @include('common.searchbox')
                    </div>
                    @can('ProductoMenu_Create')
                        <div class="col-sm-12 col-md-2">
                            <button type="button" class="btn btn-xl rounded-pill btn-label-primary waves-effect"
                                data-bs-toggle="modal" data-bs-target="#MyModal">
                                <i class="ri-add-line"></i>Nuevo
                            </button>
                        </div>
                    @endcan
                </div>
            </div>

            <!-- Filtros de productos -->
            <div class="card-body">
                <form wire:submit.prevent="filtrar">
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-2">
                            <label for="marca">Marca:</label>
                            <select wire:model="filtroMarca" class="form-select form-select-md">
                                <option value="">Todas las marcas</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->marca }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label for="linea">Línea:</label>
                            <select wire:model="filtroLinea" class="form-select form-select-md">
                                <option value="">Todas las líneas</option>
                                @foreach($lineas as $linea)
                                    <option value="{{ $linea->id }}">{{ $linea->linea }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label for="categoria">Categoría:</label>
                            <select wire:model="filtroCategoria" class="form-select form-select-md">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label for="formaVenta">Forma de Venta:</label>
                            <select wire:model="filtroFormaVenta" class="form-select form-select-md">
                                <option value="">Todas las formas de venta</option>
                                @foreach($FormaVentas as $forma)
                                    <option value="{{ $forma->id }}">{{ $forma->forma_venta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <label for="status">Estado:</label>
                            <select wire:model="filtroStatus" class="form-select form-select-md">
                                <option value="">Todos</option>
                                <option value="Activo">Activo</option>
                                <option value="Desactivado">Desactivado</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-2 align-self-end">
                            <button type="submit" class="btn btn-md rounded-pill btn-label-primary waves-effect me-2">Filtrar</button>
                            <button type="button" class="btn btn-md rounded-pill btn-label-danger waves-effect" wire:click="resetFiltro">Limpiar</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla de productos -->
            <div class="table-responsive">
                <table class="table table-responsive-md table-hover">
                    <thead class="thead-primary">
                        <tr>
                            <th class="text-center">PRODUCTO</th>
                            <th class="text-center">MARCA</th>
                            <th class="text-center">LINEA</th>
                            <th class="text-center">CATEGORIA</th>
                            <th class="text-center">FORMA VENTA</th>
                            <th class="text-center">COMUN</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $p)
                            <tr>
                                <td class="text-center">{{ $p->producto }}</td>
                                <td class="text-center">{{ $p->Rmarcas->marca }}</td>
                                <td class="text-center">{{ $p->Rlineas->linea }}</td>
                                <td class="text-center"> {{ $p->Rcategorias->categoria }}</td>
                                <td class="text-center"> {{ $p->Rventas->forma_venta }}</td>
                                <td class="text-center"> {{ $p->comun }}</td>
                                <td class="text-center">
                                    @if($p->status === 'Activo')
                                        <span class="badge bg-label-success rounded-pill">Activo</span>
                                    @else
                                        <span class="badge bg-label-danger rounded-pill">Desactivado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-pill" role="group">
                                        @can('ProductoMenu_Update')
                                            <a class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-md me-2"
                                                href="{{ route('EditarProducto', ['id' => $p->id]) }}">
                                                <i class="ri-edit-box-line"></i>
                                            </a>
                                        @endcan
                                        @can('ProductoMenu_Destroy')
                                            <a href="#" onclick="confirmDestroy({{ $p->id }})"
                                                class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-md"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Sin resultados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer p-1">
                {{ $productos->links() }}
            </div>
            @include('livewire.producto_menus.forms')
        </div>
    </div>
</div>
