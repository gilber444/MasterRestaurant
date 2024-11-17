<div class='row mt-2'>
    <div class="col-sm-12 col-md-5">
        <label class="form-label">PRODUCTO MENU</label>
    </div>
    <div class="col-sm-12 col-md-3">
        <label class="form-label">UNIDAD MEDIDA</label>
    </div>
    <div class="col-sm-12 col-md-2">
        <label class="form-label">CANTIDAD</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">Total</label>
    </div>
    <div class="col-sm-12 col-md-1">
        <label class="form-label">ACTIONS</label>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-5">
        <select wire:model='producto_primary' wire:change='storeUnidad' class="form-select form-select-md">
            <option value="">Elegir el Producto...</option>
            @foreach ($Producto_Primary as $p)
                <option value="{{ $p->id }}">{{ $p->producto }}</option>
            @endforeach
        </select>
        @error('producto_primary')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-3">
        <input type="text" wire:model='nombreUnidad' class="form-control" readonly>
        @error('unidad')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-2">
        <div class="form-floating form-floating-outline mb-2">
            <input type="text" wire:model.lazy="cantidad" wire:change='storeCantidad' class="form-control" placeholder="cantidad">
            <label for="cantidad">Cantidad</label>
            @error('cantidad')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="form-floating form-floating-outline mb-2">
            <input type="text" wire:model.lazy="total" class="form-control" placeholder="Total" readonly>
            <label for="total">Total</label>
            @error('total')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-1">
        <div class="dropdown input-group input-group-merge">
            <a href="javascript:void(0)" wire:click.prevent="StoreReceta()"
                class="btn rounded-pill btn-label-success waves-effect me-2">
                <i class="ri-save-line"></i>
            </a>
        </div>
    </div>
</div>
<hr>

@foreach (DB::table('receta_productos')->where('producto', $selected_id)->whereNull('deleted_at')->get() as $pro)
    <div class='row'>
        <div class="col-sm-12 col-md-5 mb-3">
            <label class="form-label">PRODUCTO MENU</label>
            <select wire:model="producto_primaryU.{{ $pro->id }}" wire:change="updateUnidad({{ $pro->id }})"
                class="form-select form-select-md">
                <option value=""></option>
                @foreach ($Producto_Primary as $p)
                    <option value="{{ $p->id }}">{{ $p->producto }}</option>
                @endforeach
            </select>
            @error('producto_primaryU.' . $pro->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-3 mb-3">
            <label class="form-label">UNIDAD MEDIDA</label>
            <input type="text" wire:model="unidadesU.{{ $pro->id }}" class="form-control" readonly>
            @error('unidad.' . $pro->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-2 mb-3">
            <label class="form-label">CANTIDAD</label>
            <div class="input-group input-group-merge">
                <input type="number" wire:model='cantidadU.{{ $pro->id }}' wire:change="updateTotal({{ $pro->id }})"class="form-control" placeholder="">
            </div>
            @error('cantidadU.' . $pro->id)
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-12 col-md-1 mb-3">
            <label class="form-label">SUB TOTAL</label>
            <div class="input-group input-group-merge">
                <input type="text" wire:model='totalU.{{ $pro->id }}' class="form-control" placeholder="" readonly>
            </div>
            @error('totalU')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-1">
            <div class="dropdown input-group input-group-merge">
                <a href="javascript:void(0)" wire:click.prevent="UpdateReceta({{ $pro->id }})"
                    class="btn rounded-pill btn-label-success waves-effect me-2">
                    <i class="ri-loop-left-line"></i>
                </a>
            </div>
            <div class="dropdown input-group input-group-merge">
                <a href="#" wire:click.prevent="DestroyReceta({{ $pro->id }})"
                    class="btn rounded-pill btn-label-danger waves-effect me-2">
                    <i class="ri-delete-bin-line"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach
<hr>
<div class="row">
    <div class="col-sm-12 col-md-10 mb-3">
        <label class="form-label text-center fs-6"><b>TOTAL RECETA</b></label>        
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="form-floating form-floating-outline mb-5">
            <input type="text" wire:model.lazy="Totales" class="form-control fs-5" readonly>
        </div>
    </div>
    <div class="col-sm-12 col-md-1 mb-3">      
    </div>
</div>
