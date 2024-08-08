<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row mt-2">

                    <div class="input-group input-group-merge mb-3 w-50">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ri-barcode-line"></i>
                        </span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy="codigo_barra" class="form-control" id="basic-icon-default-fullname" placeholder="0000000" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
                            <label for="codigo_barra">Codigo De Barra</label>

                            @error('codigo_barra')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="input-group input-group-merge mb-3 w-50">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ri-text"></i>
                        </span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy="producto" class="form-control" id="basic-icon-default-fullname" placeholder="Nombre del Producto" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
                            <label for="producto">Nombre De Producto</label>

                            @error('producto')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 w-100" data-select2-id="20">
                      <div class="form-floating form-floating-outline form-floating-select2" data-select2-id="19">
                        <div class="position-relative" data-select2-id="18">
                        
                            <select wire:model.lazy="categoria" id="multicol-country" class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="multicol-country" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="2">Seleccionar Categoria</option>
                                <option value="Carnes & Otros" data-select2-id="22">Carnes & Otros</option>
                                <option value="Granos Basicos" data-select2-id="23">Granos Basicos</option>
                                <option value="Bebidas & Lacteos" data-select2-id="24">Bebidas & Lacteos</option>
                            </select>

                            @error('categoria')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                      </div>
                    </div>

                    <div class="input-group input-group-merge  mb-3 w-100">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="ri-text-snippet"></i>
                        </span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy="marca" class="form-control" id="basic-icon-default-fullname" placeholder="Nombre del Marca" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2">
                            <label for="marca">Nombre De La Marca</label>

                            @error('marca')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 w-50" data-select2-id="20">
                      <div class="form-floating form-floating-outline form-floating-select2" data-select2-id="19">
                        <div class="position-relative" data-select2-id="18">
                        
                            <select id="multicol-country" wire:model.lazy="unidad_medida"  class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="multicol-country" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="2">Unidad De Medida - INT</option>
                                @forelse ($unidades as $uni)
                                    <option value="{{ $uni->valor }}" data-select2-id="22">{{ $uni->valor }}</option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>

                            @error('unidad_medida')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 mb-3 w-50" data-select2-id="20">
                      <div class="form-floating form-floating-outline form-floating-select2" data-select2-id="19">
                        <div class="position-relative" data-select2-id="18">
                        
                            <select id="multicol-country" wire:model.lazy="unidad_medida_mh"  class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="multicol-country" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="2">Unidad De Medida - MH</option>
                                @forelse ($unidades as $uni)
                                    <option value="{{ $uni->valor }}" data-select2-id="22">{{ $uni->valor }}</option>
                                @empty
                                    <option value=""></option>
                                @endforelse
                            </select>

                            @error('unidad_medida_mh')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                      </div>
                    </div>

                </div>
            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
