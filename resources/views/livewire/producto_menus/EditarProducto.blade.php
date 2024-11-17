<div class="card" role="document">
    <div class="card-header">
        <h5 class="card-title">{{ $componentName }} |
            {{ $selected_id > 0 ? 'Actualizar' : 'Nuevo' }}
        </h5>
    </div>
    <div class="card-header p-0">
        <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="{{-- nav-item {{ $activeTab == 'navs-profile-card' ? 'move' : '' }}" --}}" role="presentation">
                    <button type="button"
                        class="nav-link d-flex flex-column gap-1 {{ $activeTab == 'navs-home-card' ? 'active' : '' }} waves-effect"
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-home-card"
                        aria-controls="navs-home-card"
                        aria-selected="{{ $activeTab == 'navs-home-card' ? 'true' : 'false' }}"
                        wire:click="setActiveTab('navs-home-card')">
                        <i class="ri-instance-line"></i> Producto
                    </button>
                </li>
                @if ($selected_id > 0)
                    <li class="{{-- nav-item {{ $activeTab == 'navs-profile-card' ? 'move' : '' }}" --}} " role="presentation">
                        <button type="button"
                            class="nav-link d-flex flex-column gap-1 {{ $activeTab == 'navs-mesages-card' ? 'active' : '' }} waves-effect"
                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-messages-card"
                            aria-controls="navs-messages-card"
                            aria-selected="{{ $activeTab == 'navs-mesages-card' ? 'true' : 'false' }}" tabindex="-1"
                            wire:click="setActiveTab('navs-mesages-card')">
                            <i class="ri-restaurant-line"></i> Receta
                        </button>
                    </li>
                    <li class="{{-- nav-item {{ $activeTab == 'navs-profile-card' ? 'move' : '' }}" --}} role="presentation">
                        <button type="button"
                            class="nav-link d-flex flex-column gap-1 {{ $activeTab == 'navs-profile-card' ? 'active' : '' }} waves-effect"
                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-profile-card"
                            aria-controls="navs-profile-card"
                            aria-selected="{{ $activeTab == 'navs-profile-card' ? 'true' : 'false' }}" tabindex="-1"
                            wire:click="setActiveTab('navs-profile-card')">
                            <i class="ri-money-dollar-circle-fill"></i> Precios
                        </button>
                    </li>
                @endif
                <div class="d-flex ms-auto">
                    <button type="button" class="btn rounded-pill btn-label-danger waves-effect"
                        wire:click.prevent='resetUIPrecios(), ResetInt()'
                        onclick="window.location='{{ route('producto_menus') }}'">
                        <i class="ri-arrow-left-line"></i> Regresar
                    </button>
                    <button type="button" class="btn rounded-pill btn-label-primary waves-effect me-2"
                        wire:click.prevent="Update()">
                        <i class="ri-save-line"></i> Actualizar Producto
                    </button>
            </ul>
        </div>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content pb-0">
            <div class="tab-pane fade {{ $activeTab == 'navs-home-card' ? 'show active' : '' }}" id="navs-home-card"
                role="tabpanel">
                <p class="card-text">
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 mb-3">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="producto" class="form-control"
                                placeholder="producto">
                            <label for="producto">Producto</label>
                            @error('producto')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <div class="form-floating form-floating-outline mb-2">
                            <select wire:model.lazy='marca' class="form-select form-select-md form-control">
                                <option value="">Elegir la Marca...</option>
                                @foreach ($Marcas as $m)
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
                            <label for="linea">Linea</label>
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
                            <label for="categoria">Categoria</label>
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
                            <label for="forma_venta">Forma de venta</label>
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
                            <select wire:model='status' class="form-select form-select-md">
                                <option value=""></option>
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
            @if ($selected_id > 0)
                <div class="tab-pane fade {{ $activeTab == 'navs-mesages-card' ? 'show active' : '' }}"
                    id="navs-messages-card" role="tabpanel">
                    @include('livewire.producto_menus.Receta')
                </div>

                <div class="tab-pane fade {{ $activeTab == 'navs-profile-card' ? 'show active' : '' }}"
                    id="navs-profile-card" role="tabpanel">
                    @include('livewire.producto_menus.Precios')
                </div>
            @endif
        </div>
    </div>
</div>
@include('common.notis')
