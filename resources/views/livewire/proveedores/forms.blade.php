<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-8 mb-3">
                        <label class="form-label">Nombre del Proveedor</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="nombre"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='nombre' class="form-control"
                                placeholder="Nombre del Proveedor">
                        </div>
                        @error('nombre')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <label class="form-label">Razón Social</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="razon_social"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='razon_social' class="form-control"
                                placeholder="Razón Social">
                        </div>
                        @error('razon_social')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 mb-3">
                        <label class="form-label">Actividad Económica</label>
                        <div class="input-group">
                            <select class="form-select" wire:model='actividad'>
                                <option selected="">Elegir Actividad Economica</option>
                                @foreach ($actividadEconomica as $a)
                                    <option value="{{ $a->id }}">{{ $a->codigo }} - {{ $a->valor }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('actividad')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Tipo Persona</label>
                        <div class="input-group">
                            <select class="form-select" wire:model='tipoPersona'>
                                <option selected="">Elegir Tipo de Persona</option>
                                @foreach ($tipoPersonas as $p)
                                    <option value="{{ $p->id }}">{{ $p->codigo }} - {{ $p->valor }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('tipoPersona')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Departamento</label>
                        <div class="input-group">
                            <select class="form-select" wire:model='departamento'>
                                <option selected="">Elegir Departamento</option>
                                @foreach ($departamentos as $d)
                                    <option value="{{ $d->id }}">{{ $d->codigo }} - {{ $d->departamento }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('departamento')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Municipio</label>
                        <div class="input-group">
                            <select class="form-select" wire:model='municipio'>
                                <option selected="">Elegir Municipio</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}">{{ $m->codigo }} - {{ $m->municipio }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('municipio')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Distrito</label>
                        <div class="input-group">
                            <select class="form-select" wire:model='distrito'>
                                <option selected="">Elegir Distrito</option>
                                @foreach ($distritos as $d)
                                    <option value="{{ $d->id }}">{{ $d->codigo }} - {{ $d->distrito }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('distrito')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 mb-3">
                        <label class="form-label">Direccion</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="direccion"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='direccion' class="form-control">
                        </div>
                        @error('direccion')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Telefono</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="telefono"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='telefono' class="form-control"
                                placeholder="0000-0000">
                        </div>
                        @error('telefono')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">Correo</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="correo"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='correo' class="form-control"
                                placeholder="prueba@gmail">
                        </div>
                        @error('correo')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">N° Registro</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="registro"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='registro' class="form-control">
                        </div>
                        @error('registro')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-3 mb-3">
                        <label class="form-label">NIT</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="nit"><i class='bx bx-edit'></i></span>
                            <input type="text" wire:model.lazy='nit' class="form-control"
                                placeholder="0000-00000-0">
                        </div>
                        @error('nit')
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
