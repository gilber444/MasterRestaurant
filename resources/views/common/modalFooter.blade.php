<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" wire:click='ResetInt'>Cancelar</button>
@if ($selected_id < 1)
    <button type="button" wire:click="Store()" class="btn rounded-pill btn-label-primary waves-effect">
        <i class="ri-save-line"></i> Guardar Datos
    </button>
@else
    <button type="button" wire:click.prevent="Update()" class="btn rounded-pill btn-label-primary waves-effect">
        <i class="ri-save-line"></i> Actualizar Datos
    </button>
@endif
