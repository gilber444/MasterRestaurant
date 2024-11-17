<div class="card mb-0">
    <div class="card-body card-separator">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Editar Ajuste</h5>
            <div class="d-flex">
                <button type="button" class="btn rounded-pill btn-label-danger waves-effect"
                    wire:click.prevent="Limpiar()">
                    <i class="ri-arrow-left-line"></i> Regresar
                </button>
                <button type="button" class="btn rounded-pill btn-label-primary waves-effect me-2"
                    wire:click.prevent="Update()">
                    <i class="ri-save-line"></i> Actualizar Ajuste
                </button>
            </div>
        </div>
        <div class="deposit-content pt-2">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating form-floating-outline mb-6">
                        <select wire:model.lazy='sucursal' class="form-select" aria-label="Elegir Sucursal">
                            <option value="Elegir">Elegir Sucursal</option>
                            @foreach ($sucursales as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                        <label class="form-label">Elegir Sucursal</label>
                    </div>
                    @error('sucursal')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                        <select wire:model.lazy='tipo' class="form-select" aria-label="Elegir Tipo Aguste">
                            <option value="">Elegir...</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>
                        </select>
                        <label class="form-label">Elegir Tipo Aguste</label>
                    </div>
                    @error('tipo')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-floating form-floating-outline mb-6">
                        <input id="fechaInput" type="date" class="form-control" placeholder="0000"
                            wire:model.lazy='fecha'>
                        <label for="">Fecha Ajuste</label>
                    </div>
                    @error('fecha')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 mb-3">
                    <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control" wire:model.lazy='detalle' name="detalle" id="detalle" cols="30" rows="2"></textarea>
                        <label class="form-label">Detalle del ajuste</label>
                    </div>
                    @error('detalle')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <hr>
            <div class="row" wire:ignore id='searchAjustes'>
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
                                    <th class="text-center">UNIDAD MEDIDA</th>
                                    <th class="text-center">CANTIDAD</th>
                                    <th class="text-center">COSTO</th>
                                    <th class="text-center">TOTAL</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProductsBody">
                                @forelse ($items as $i)
                                    <tr>
                                        <td class="text-center">{{ $i->codigo }}</td>
                                        <td class="text-center">{{ $i->nombre }}</td>
                                        <td class="text-center">{{ $i->medida }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input class="form-control w-25"
                                                    wire:keydown.enter='updateCantidad({{ $i->id }})'
                                                    wire:model='cant.{{ $i->id }}' type="text">
                                            </div>
                                        </td>
                                        <td class="text-end"> ${{ $i->costo }}</td>
                                        <td class="text-end">${{ number_format($i->total, 2) }}</td>
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
