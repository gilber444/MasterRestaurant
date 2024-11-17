<div class="row" style="display: flex; flex-direction: column;">
    <!-- Form Separator -->
    <div class="col-xxl">
        <div class="card mb-6">
            <div style="display: flex; justify-content: space-between;align-items: center; margin-bottom: -3rem;">
                <h5 class="card-header">Actualizar Traslado <i class="ri-arrow-up-down-line"></i></h5>
                <button style="margin-left: 25rem;" wire:click="resetProcess" type="submit" class="btn btn-danger waves-effect waves-light">
                    <i style="margin-right: 0.3rem;" class="ri-close-large-line"></i>
                    Cancelar
                </button>
                <button type="submit" wire:click="Update" class="btn btn-primary me-4 waves-effect waves-light mr-2">
                    <i style="margin-right: 0.3rem;" class="ri-save-line"></i>
                    Actualizar Traslado
                </button>

            </div>

            <div class="card-body">
                <hr class="my-6 mx-n4">
                <h6>1. Detalles Del Traslado</h6>

                <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 2rem; margin-bottom: 1rem; margin-top: 1.5rem; ">
                    <div class="mb-4" style="display: flex; flex-direction: column;  width: 100%">
                        <label style="width: 100%" class="col-form-label" for="multicol-email">Sucursal Origen:</label>
                        <select wire:model.lazy="sorigen" class="form-select" data-allow-clear="true"
                            tabindex="-1" aria-hidden="true">
                            <option selected=""></option>
                            @forelse ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">
                                {{ $sucursal->nombre }}
                            </option>
                            @empty
                            <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                            @endforelse
                        </select>
                        @error('sorigen')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class=" mb-4"  style="display: flex; flex-direction: column; width: 100%">
                        <label style="width: 100%" class="col-form-label" for="multicol-email">Sucursal Destino:</label>
                        <select wire:model.lazy="sdestino" class="form-select" data-allow-clear="true"
                            tabindex="-1" aria-hidden="true">
                            <option selected=""></option>
                            @forelse ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">
                                {{ $sucursal->nombre }}
                            </option>
                            @empty
                            <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                            @endforelse
                        </select>
                        @error('sdestino')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4"  style="display: flex; flex-direction: column;  width: 100%">
                        <label style="width: 100%" class="col-form-label">Fecha Traslado:</label>
                        <input wire:model.lazy="fecha" type="date" class="form-control dob-picker flatpickr-input" placeholder="YYYY-MM-DD">
                        @error('fecha')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-default-message">
                        Comentarios:
                    </label>
                    <div class="col-sm-10">
                        <textarea spellcheck="false" id="basic-default-message" class="form-control"
                            placeholder="Agregar comentario o descripcion"
                            aria-label="Agregar comentario o descripcion"
                            aria-describedby="basic-icon-default-message2" wire:model.lazy="detalle">
                        </textarea>
                        @error('detalle')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-body">
                <h6>2. Carrito De Productos</h6>

                <div class="col-sm-12 col-md-12 mb-3">
                    {{-- <style>
                        #searchTraslado .position-relative .select2-container {
                            max-width: 40.5rem !important;
                            min-width: 40.5rem !important;
                        }
                    </style> --}}



                    <div class="row mb-4" wire:ignore id='searchTraslado'>
                        <label class="col-sm-3 col-form-label" for="inputGroupSelect01">Productos a Trasladar</label>
                        <div class="col-sm-9">
                            <select id="select2ActiProducto"
                                class="select2 form-select form-select-lg select2-hidden-accessible"
                                data-allow-clear="true" data-select2-id="select2ActiProducto" tabindex="-1"
                                aria-hidden="true" style="width: 100%;" onchange="cargaDatos()">
                                <option selected="">Buscar Producto</option>
                                @forelse ($productos as $producto)
                                <option value="{{ $producto->id }}">
                                    CODIGO: {{ $producto->codigo_barra }} -
                                    NOMBRE: {{ $producto->producto }} -
                                    UM: {{ $producto->RunidadMedida->nombre }} -
                                    PRECIO: {{ $producto->csiva }}
                                </option>
                                @empty
                                <option>No hay actividades disponibles</option>
                                @endforelse
                            </select>
                        </div>

                    </div>
                    @error('actividad')
                    <span class="text-danger er">{{ $message }}</span>
                    @enderror

                </div>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="text-center">Codigo</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Accion</th>
                            </tr>
                        </thead>

                        <tbody id="selectedProductsBody">
                            @forelse ($items as $i)
                            <tr>
                                <td class="text-center">{{$i->codigo}}</td>
                                <td class="text-center">{{$i->nombre}}</td>
                                <td class="text-center">
                                    <input class="form-control" wire:keydown.enter='updateCantidad({{$i->id}})' wire:model='cant.{{$i->id}}' type="text">
                                </td>
                                <td class="text-center">{{$i->costo}}</td>
                                <td class="text-center">{{$i->total}}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger " type="button" wire:click='deleteItem({{$i->id}})'>
                                        -
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">
                                        No se encontraron registros
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>




                    </table>
                    <div style="display: flex;justify-content: right;margin-top: 1rem;">
                        <button type="button" style="display: none !important;"
                            class="btn btn-info waves-effect waves-light" id="selectButton2">
                            <i class="ri-shopping-cart-2-line" style="margin-right: 0.3rem;"></i> Terminar Carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        function cargaDatos(){
            console.log('ejecutando');
            var mId
            $('select2ActiProducto').select2()
            $('#select2ActiProducto').off('change');
            $('#select2ActiProducto').on('change', function(e) {
                mId = $(this).val();
                console.log(mId);
                
                Livewire.dispatch('Temporal', {
                    id: mId
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            cargaDatos();
        });

    </script>
</div>