<div class='row mt-2'>
    <div class="col-sm-12 col-md-2">
        <label class="form-label">Linea</label>
    </div>
    <div class="col-sm-12 col-md-2">
        <label class="form-label">Categoria</label>
    </div>
    <div class="col-sm-12 col-md-2">
        <label class="form-label">CANTIDAD</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">COSTO</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">C/IVA</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">UTILIDAD</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">P/V</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">PV/IVA</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">ACTIONS</label>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-2">
        <select wire:model='lineaP' class="form-select form-select-md" data-allow-clear="true">
            <option value="Elegir">Elegir Linea...</option>
            @foreach ($lineas as $l)
                <option value="{{ $l->id }}">{{ $l->linea }}</option>
            @endforeach
        </select>
    </div>
    @error('lineaP')
        <span class="text-danger er">{{ $message }}</span>
    @enderror
    <div class="col-sm-12 col-md-2">
        <select wire:model='categoriaP' class="form-select form-select-md" data-allow-clear="true">
            <option value="Elegir">Elegir Categoria...</option>
            @foreach ($categorias as $c)
                <option value="{{ $c->id }}">{{ $c->categoria }}</option>
            @endforeach
        </select>
    </div>
    @error('categoriaP')
        <span class="text-danger er">{{ $message }}</span>
    @enderror
    <div class="col-sm-12 col-md-2">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='cantidadP' wire:input="calcularCantidad"
                class="form-control" placeholder="">
        </div>
        @error('cantidadP')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='costo' wire:change='calcularCostoIva' class="form-control" placeholder="" readonly>
        </div>
        @error('costo')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='costoIva' wire:change='calcularCosto' class="form-control" placeholder="" readonly>
        </div>
        @error('costoIva')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='utilidad' wire:change='calcularPrecioVenta' class="form-control"
                placeholder="">
        </div>
        @error('utilidad')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='precioVenta' wire:change='calcularPrecioVentaIva_Utilidad'
                class="form-control" placeholder="">
        </div>
        @error('precioVenta')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="input-group input-group-merge">
            <input type="text" wire:model='precioVentaIva' wire:change='calcularPrecioVenta_Utilidad'
                class="form-control" placeholder="">
        </div>
        @error('precioVentaIva')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="dropdown input-group input-group-merge">
            <a href="javascript:void(0)" wire:click.prevent="StorePrecio()"
                class="btn rounded-pill btn-label-success waves-effect me-2">
                <i class="ri-save-3-line"></i>
            </a>
        </div>
    </div>
</div>
<hr>
@foreach (DB::table('precios')->where('producto', $selected_id)->whereNull('deleted_at')->get() as $pre)
    <div class='row'>
        <div class="col-sm-12 col-md-2 mb-3">
            <label class="form-label">Linea</label>
            <select wire:model="lineaU.{{ $pre->id }}" class="form-select form-select-md" data-allow-clear="true">
                <option value=""></option>
                @foreach ($lineas as $l)
                    <option value="{{ $l->id }}">{{ $l->linea }}</option>
                @endforeach
            </select>
            @error('lineaU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-sm-12 col-md-2 mb-3">
            <label class="form-label">Categoria</label>
            <select wire:model="categoriaU.{{ $pre->id }}" class="form-select form-select-md" data-allow-clear="true">
                <option value=""></option>
                @foreach ($categorias as $c)
                    <option value="{{ $c->id }}">{{ $c->categoria }}</option>
                @endforeach
            </select>
            @error('categoriaU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-sm-12 col-md-2 mb-3">
            <label class="form-label">Cantidad</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='cantidadesU.{{ $pre->id }}'
                    wire:change="calcularCantidadUpdate({{ $pre->id }})" class="form-control" placeholder="">
            </div>
            @error('cantidadU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">C</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='costoU.{{ $pre->id }}'
                    wire:change="calcularCostoIvaUpdate({{ $pre->id }})" class="form-control" placeholder="">
            </div>
            @error('costoU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">C/IVA</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='costoIvaU.{{ $pre->id }}'
                    wire:change="calcularCostoUpdate({{ $pre->id }})" class="form-control" placeholder="">
            </div>
            @error('costoIvaU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">%</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='utilidadU.{{ $pre->id }}'
                    wire:change="calcularPrecioVentaUpdate({{ $pre->id }})" class="form-control"
                    placeholder="">
            </div>
            @error('utilidadU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">PV</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='precioVentaU.{{ $pre->id }}'
                    wire:change='calcularPrecioVentaIva_UtilidadUpdate({{ $pre->id }})' class="form-control" placeholder="">
            </div>
            @error('precioVentaU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">PV/IVA</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='precioVentaIvaU.{{ $pre->id }}'
                    wire:change='calcularPrecioVenta_UtilidadUpdate({{ $pre->id }})' class="form-control"
                    placeholder="">
            </div>
            @error('precioVentaIvaU.' . $pre->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1">
            <div class="dropdown input-group input-group-merge">
                <a href="javascript:void(0)" wire:click.prevent="UpdatePrecios({{ $pre->id }})"
                    class="btn rounded-pill btn-label-success waves-effect me-2">
                    <i class="ri-loop-left-line"></i>
                </a>
            </div>
            <div class="dropdown input-group input-group-merge">
                <a href="#" onclick="confirmDestroy({{ $pre->id }})"
                    class="btn rounded-pill btn-label-danger waves-effect me-2"><i class="ri-delete-bin-line"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
