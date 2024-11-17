<div class="card mb-0">
    <div class="card-body card-separator">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Editar Compra</h5>
            <div class="d-flex">
                <button type="button" class="btn rounded-pill btn-label-danger waves-effect"
                    wire:click.prevent="Limpiar()">
                    <i class="ri-arrow-left-line"></i> Regresar
                </button>
                <button type="button" class="btn rounded-pill btn-label-primary waves-effect me-2"
                    wire:click.prevent="Update()">
                    <i class="ri-save-line"></i> Actualizar Compra
                </button>
            </div>
        </div>
        <div class="deposit-content pt-2">
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating form-floating-outline">
                        <select wire:model='proveedor' class="form-select" aria-label="Elegir Proveedor">
                            <option value="Elegir">Elegir Proveedor</option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} - {{ $p->razon_social }} -
                                    {{ $p->registro }}</option>
                            @endforeach
                        </select>
                        <label for="">Proveedor</label>
                    </div>
                    @error('proveedor')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="text" wire:model.lazy="vendedor" class="form-control" placeholder="Vendedor">
                        <label for="vendedor">Vendedor</label>
                        @error('vendedor')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" wire:model.lazy="correlativo" class="form-control"
                            placeholder="Correlativo">
                        <label for="correlativo">Correlativo</label>
                        @error('correlativo')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <select wire:model='factura' class="form-select" aria-label="Elegir tipo factura">
                            <option value="Elegir">Elegir tipo factura</option>
                            @foreach ($facturas as $fact)
                                <option value="{{ $fact->id }}">{{ $fact->factura }}</option>
                            @endforeach
                        </select>
                        <label for="">Tipo Factura</label>
                    </div>
                    @error('factura')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input id="fechaInput" type="date" class="form-control" placeholder="0000"
                            wire:model='fechaCompra'>
                        <label for="">Fecha Compra</label>
                    </div>
                    @error('fechaCompra')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" wire:model.lazy="serie" class="form-control" placeholder="Serie">
                        <label for="serie">Serie</label>
                        @error('serie')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline mb-6">
                        <select wire:model.lazy='condicionPago' class="form-select" aria-label="Elegir forma de pago">
                            <option value="Elegir">Elegir forma de pago</option>
                            @foreach ($Condicion as $c)
                                <option value="{{ $c->id }}">{{ $c->valor }}</option>
                            @endforeach
                        </select>
                        <label for="condicionPago">Forma pago</label>
                    </div>
                    @error('condicionPago')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input id="fechaInput" type="date" class="form-control" placeholder="0000"
                            wire:model='fechaPago'>
                        <label for="">Fecha Pago</label>
                    </div>
                    @error('fechaPago')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-floating form-floating-outline">
                    <textarea class="form-control" wire:model.lazy='observaciones' name="observaciones" id="observaciones" cols="30"
                        rows="2"></textarea>
                    <label class="form-label">Detalle del compra</label>
                </div>
                @error('observaciones')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="row" wire:ignore id='searchCompras'>
            <div class="col-sm-12 col-md-12 text-center">
                <h5>Agregar Productos</h5>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="form-floating form-floating-outline mb-6">
                    <select id="select2ActiProducto"
                        class="select2 form-select form-select-lg select2-hidden-accessible"
                        aria-label="Buscar Producto" data-allow-clear="true" data-select2-id="select2ActiProducto"
                        tabindex="-1" aria-hidden="true" style="width: 100%;" onchange="cargaDatos()">
                        <option selected="">Buscar Producto</option>
                        <option disabled> Código de Barra - Producto - Unidad de Medida - Precio Sin IVA</option>
                        @forelse ($productos as $producto)
                            <option value="{{ $producto->id }}">
                                {{ $producto->codigo_barra }} - {{ $producto->producto }} -
                                {{ $producto->RunidadMedidaMH->valor }} - {{ $producto->csiva }}
                            </option>
                        @empty
                            <option>No hay productos disponibles</option>
                        @endforelse
                    </select>
                    <label class="form-label">Buscar Productos</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm12 col-md-12">
                <div class="table-responsive text-nowrap mb-3">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">PRODUCTOS</th>
                                <th class="text-center">CANTIDAD</th>
                                <th class="text-center">COSTO</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">TOTAL IVA</th>
                                <th class="text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="selectedProductsBody">
                            @forelse ($items as $i)
                                <tr>
                                    <td class="text-center">{{ $i->codigo }}</td>
                                    <td class="text-center">{{ $i->nombre }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <input class="form-control w-25"
                                                wire:keydown.enter='updateCantidad({{ $i->id }})'
                                                wire:model='cant.{{ $i->id }}' type="text">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $costoProducto = DB::table('productos')
                                                ->where('id', $i->producto)
                                                ->whereNull('deleted_at')->value('csiva');
                                        @endphp
                                        ${{ number_format($costoProducto, 4) }}
                                        <div class="d-flex justify-content-center">
                                            <input class="form-control w-25"
                                                wire:keydown.enter="updateCosto({{ $i->id }})"
                                                wire:model="cost.{{ $i->id }}" type="text"
                                                value="{{ number_format($i->costo, 2) }}">
                                        </div>
                                    </td>
                                    <td class="text-center">${{ number_format($i->total, 2) }}</td>
                                    <td class="text-center">${{ number_format($i->total * 1.13, 2) }}</td>
                                    <td class="text-center">
                                        <button class="btn rounded-pill btn-icon btn-outline-danger waves-effect"
                                            type="button" wire:click='deleteItem({{ $i->id }})'>
                                            -
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7">
                                        No se encontraron registros
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function cargaDatos() {
        var mId
        $('select2ActiProducto').select2()
        $('#select2ActiProducto').off('change');
        $('#select2ActiProducto').on('change', function(e) {
            mId = $(this).val();

            Livewire.dispatch('Temporal', {
                id: mId
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        cargaDatos();
    });
</script>
