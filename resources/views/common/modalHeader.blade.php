<div class="modal-header">
    <h5 class="modal-title text-primary" id="modalToggleLabel">{{ $componentName }} |
        {{ $selected_id > 0 ? 'Actualización' : 'Nuevo' }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
        wire:click='ResetInt'></button>
</div>
