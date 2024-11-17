<div class="row" style="display: flex; flex-direction: column;">
    <!-- Form Separator -->
    <div class="col-xxl">
        <div class="card mb-6">
            <div style="display: flex; justify-content: space-between;align-items: center; margin-bottom: -3rem;">
                <h5 class="card-header">Modificar Platillo <i class="ri-arrow-up-down-line"></i></h5>
                <div>
                    <button style="margin-left: 27rem;" wire:click="resetProcess" type="submit" class="btn btn-danger waves-effect waves-light">
                        <i style="margin-right: 0.3rem;" class="ri-close-large-line"></i>
                        Cancelar
                    </button>
                    <button type="submit" wire:click="Update()" class="btn btn-primary me-4 waves-effect waves-light mr-2">
                        <i style="margin-right: 0.3rem;" class="ri-save-line"></i>
                        Actualizar Platillo
                    </button>
                </div>

            </div>

            <div class="card-body" id="formTraslado">
                <hr class="my-6 mx-n4">
                <h6>1. Detalles Del Platillo</h6>

                <div style="display: flex; flex-direction: row; justify-content: space-between; gap: 2rem; margin-bottom: 1rem; margin-top: 1rem; ">
                    <div class="mb-4" style="display: flex; flex-direction: column;  width: 100%">
                        <label style="width: 100%" class="col-form-label" for="multicol-email">Producto:</label>
                        <select wire:model.lazy="producto" class="form-select" data-allow-clear="true"
                            tabindex="-1" aria-hidden="true" wire:change="Temporal($event.target.value)">
                            <option selected=""></option>
                            @forelse ($productos as $producto)
                                <option value="{{ $producto->id }}">
                                    {{ $producto->producto }}
                                </option>
                            @empty
                                <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                            @endforelse
                        </select>
                        @error('producto')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class=" mb-4"  style="display: flex; flex-direction: column; width: 100%">
                        <label style="width: 100%" class="col-form-label" for="multicol-email">Stock:</label>
                        <input type="text" wire:model.lazy="stock" wire:keydown.enter="actualizarCostoSinIva1" class="form-control" id="basic-icon-default-fullname" placeholder="Stock" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('stock')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4"  style="display: flex; flex-direction: column;  width: 100%">
                        <label style="width: 100%" class="col-form-label">Fecha :</label>
                        <input wire:model.lazy="fecha" type="date" class="form-control dob-picker flatpickr-input" placeholder="YYYY-MM-DD" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                        @error('fecha')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-body">
                <h6>2. Detalle De la Receta</h6>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th>ID Producto</th>
                                <th>Producto Primario</th>
                                <th class="text-center">Unidad de Medida</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                        </thead>

                        <tbody id="selectedProductsBody">
                            @if ($productoMenu)
                                @foreach ($productoMenu as $receta)
                                <tr>
                                    <td>
                                        {{ $receta->RProducto->id }}
                                    </td>

                                    <td>
                                        {{ $receta->RProducto->producto }}
                                    </td>

                                    <td class="text-center">
                                        {{ $receta->RUnidad->nombre }}
                                    </td>

                                    <td class="text-center">
                                        {{ $receta->cantidad }}
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <p>Seleccione un producto para mostrar la receta correspondiente.</p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
    @include('livewire.programacion_menu_nuevo.forms')
    @include('common.notis')
</div>