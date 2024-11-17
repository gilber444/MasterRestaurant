<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="linea" class="form-control"
                                placeholder="Lineas">
                            <label for="codigo">Linea</label>
                            @error('linea')
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
