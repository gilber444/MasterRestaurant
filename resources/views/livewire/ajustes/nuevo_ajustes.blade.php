<div class="row">
    <div class="col-sm-12 col-md-6">
        <label class="form-label">Elegir Sucursal</label>
        <select wire:model='sucursal' class="form-select form-select-lg" data-allow-clear="true">
            <option value="Elegir">Elegir Sucursal</option>
            @foreach ($sucursal as $s)
                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
            @endforeach
        </select>
        @error('sucursal')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-3">
        <label class="form-label">Tipo Ajuste</label>
        <select wire:model='tipo' class="form-select form-select-lg" data-allow-clear="true">
            <option value="">Elegir...</option>
            <option value="Ingreso">Ingreso</option>
            <option value="Egreso">Egreso</option>
        </select>
        @error('tipo')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-3">
        <label for="">Fecha Ajuste</label>
        <div class="input-group">
            <input id="fechaInput" type="date" class="form-control" placeholder="0000" wire:model='fecha'>
        </div>
        @error('fecha')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-12 mb-3">
        <label class="form-label">Detalle</label>
        <div class="input-group input-group-merge">
            <textarea class="form-control" wire:model.lazy='detalle' name="detalle" id="detalle" cols="30" rows="2"></textarea>
        </div>
        @error('detalle')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <hr>
    <h6 class="text-center">Agregar Productos</h6>
    <select class="form-control mb-3" id="productSearch" style="width: 100%;">
        <option value="">Buscar producto...</option>
        @if ($productos)
            @foreach ($productos as $product)
                <option value="{{ $product['id'] }}">
                    {{ $product['producto'] }} - {{ $product['marca'] }} - {{ $product['categoria'] }}
                </option>
            @endforeach
        @endif
    </select>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-sm">
            <thead>
                <th class="text-center">ID</th>
                <th class="text-center">SUCURSAL</th>
                <th class="text-center">PRODUCTOS</th>
                <th class="text-center">TIPO</th>
                <th class="text-center">CANTIDAD</th>
                <th class="text-center">ACTIONS</th>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    <script>
        document.addEventListener('livewire:load', function() {
            // Inicializar Select2
            $('#productSearch').select2({
                placeholder: "Buscar producto...",
                allowClear: true,
                minimumInputLength: 1,
            });

            $('#productSearch').on('change', function(e) {
                var productId = $(this).val();
                @this.call('selectProduct', productId);
            });

            Livewire.on('refreshSelect2', () => {
                $('#productSearch').select2('destroy').select2({
                    placeholder: "Buscar producto...",
                    allowClear: true,
                    minimumInputLength: 1,
                });
            });
        });
    </script>
