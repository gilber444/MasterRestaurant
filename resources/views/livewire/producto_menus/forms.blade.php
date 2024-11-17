<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="card text-center mb-4">
                    <div class="card-header p-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link d-flex flex-column gap-1 active waves-effect"
                                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-home-card"
                                        aria-controls="navs-home-card" aria-selected="true">
                                        <i class="ri-instance-line"></i> Producto
                                    </button>
                                </li>
                                @if ($selected_id > 0 && $activateNewSection)
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link d-flex flex-column gap-1 waves-effect"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-profile-card"
                                            aria-controls="navs-profile-card" aria-selected="false" tabindex="-1">
                                            <i class="ri-money-dollar-circle-fill"></i> Precios
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link d-flex flex-column gap-1 waves-effect"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-messages-card"
                                            aria-controls="navs-messages-card" aria-selected="false" tabindex="-1">
                                            <i class="ri-restaurant-line"></i> Menú
                                        </button>
                                    </li>
                                @endif
                                <span class="tab-slider" style="left: 0px; width: 90.375px; bottom: 0px;"></span>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content pb-0">
                            <div class="tab-pane fade show active" id="navs-home-card" role="tabpanel">
                                <p class="card-text">
                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <label for="producto">Producto</label>
                                            <input type="text" wire:model.lazy="producto" class="form-control">
                                            <label for="producto">Producto</label>
                                            @error('producto')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='marca' class="form-select form-select-md">
                                                <option value="">Elegir la Marca...</option>
                                                @foreach ($marcas as $m)
                                                    <option value="{{ $m->id }}">{{ $m->marca }}</option>
                                                @endforeach
                                            </select>
                                            <label for="marca">Marca</label>
                                            @error('marca')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='linea' class="form-select form-select-md">
                                                <option value="">Elegir la Linea...</option>
                                                @foreach ($lineas as $l)
                                                    <option value="{{ $l->id }}">{{ $l->linea }}</option>
                                                @endforeach
                                            </select>
                                            <label for="linea">Línea</label>
                                            @error('linea')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='categoria' class="form-select form-select-md">
                                                <option value="">Elegir la Categoria...</option>
                                                @foreach ($categorias as $c)
                                                    <option value="{{ $c->id }}">{{ $c->categoria }}</option>
                                                @endforeach
                                            </select>
                                            <label for="categoria">Categoría</label>
                                            @error('categoria')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='forma_venta' class="form-select form-select-md">
                                                <option value="">Elegir la forma de venta...</option>
                                                @foreach ($FormaVentas as $f)
                                                    <option value="{{ $f->id }}">{{ $f->forma_venta }}</option>
                                                @endforeach
                                            </select>
                                            <label for="forma_venta">Forma de Venta</label>
                                            @error('forma_venta')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='comun' class="form-select form-select-md">
                                                <option value="">Producto en común...</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="comun">Producto en común</label>
                                            @error('comun')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <div class="form-floating form-floating-outline mb-2">
                                            <select wire:model.lazy='status' class="form-select form-select-md">
                                                <option value="">Elegir...</option>
                                                <option value="Activo">Activo</option>
                                                <option value="Desactivado">Desactivado</option>
                                            </select>
                                            <label for="status">Estado</label>
                                            @error('status')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                </p>
                            </div>
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
