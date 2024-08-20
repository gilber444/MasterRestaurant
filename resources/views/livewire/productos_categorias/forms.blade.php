<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none; " aria-hidden="true">
    <div class="modal-dialog modal-lg" style="--bs-modal-width: 50rem;" role="document">
        <div class="modal-content" style="overflow:hidden;">
            @include('common.modalHeader')

            <div class="modal-body">
                <div class="tab-content" style="border: 1px solid #e6e6e6; border-radius: 1rem; margin-bottom: 0rem;">
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <form>
                            <h6 class="mb-7">1. Detalles De La Categoria</h6>
                            <div class="row mt-2">

                                <div class="input-group input-group-merge mb-5 w-100">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                       <i class="ri-text" style="color: #8e8e8e;"></i>
                                    </span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" wire:model.lazy="categoria" class="form-control" placeholder="Categoria">
                                        <label for="categoria">Nombre De La Categoria</label>

                                        @error('categoria')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-5 w-100">
                                    <label class="input-group-text" for="inputGroupSelect01">Activo</label>
                                    <select wire:model.lazy="estado" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Estado</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>

                                    @error('estado')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </form>
                    </div>


                </div>
            </div>

            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
