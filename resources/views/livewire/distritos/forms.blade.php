<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="codigo" class="form-control"
                                placeholder="Codigo">
                            <label for="codigo">Codigo</label>
                            @error('codigo')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="distrito" class="form-control" placeholder="Distrito">
                            <label for="distrito">Distrito</label>
                            @error('distrito')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <select wire:model.lazy='municipio' class="form-control">
                            <option value="">Elegir Municipio...</option>
                            @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->municipio }}</option>
                            @endforeach
                        </select>
                        @error('municipio')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <select wire:model.lazy='status' class="form-control">
                            <option value="">Elegir...</option>
                            <option value="Activo">Activo</option>
                            <option value="Desactivado">Desactivado</option>
                        </select>
                        @error('status')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
