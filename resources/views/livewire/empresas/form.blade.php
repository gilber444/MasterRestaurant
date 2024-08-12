<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-8 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='empresa' class="form-control" placeholder="Nombre de la empresa" autocomplete="false">
                            <label for="">Empresa</label>
                        </div>
                        @error('empresa')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='telefono' class="form-control" placeholder="Telefono" autocomplete="false">
                            <label for="">Telefono</label>
                        </div>
                        @error('telefono')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='razon' class="form-control" placeholder="Razon Social de la empresa">
                            <label for="">Razon Social</label>
                        </div>
                        @error('razon')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <textarea wire:model='direccion' cols="30" rows="3" class="form-control" placeholder="Direccion de la empresa"></textarea>
                            <label for="">Direccion</label>
                        </div>
                        @error('direccion')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='nit' class="form-control" placeholder="NIT">
                            <label for="">NIT</label>
                        </div>
                        @error('nit')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='registro' class="form-control" placeholder="Registro">
                            <label for="">Registro</label>
                        </div>
                        @error('registro')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='responsable' class="form-control" placeholder="Responsable">
                            <label for="">Responsable</label>
                        </div>
                        @error('responsable') <!-- Corrige el nombre aquí -->
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='giro' class="form-control" placeholder="Giro">
                            <label for="">Giro</label>
                        </div>
                        @error('giro')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='tipoContribuyente' class="form-control" placeholder="Tipo de Contribuyente">
                            <label for="">Tipo Contribuyente</label>
                        </div>
                        @error('tipoContribuyente')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='correo' class="form-control" placeholder="Correo Electronico">
                            <label for="">Correo Electronico</label>
                        </div>
                        @error('correo')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="input-group" wire:ignore>
                            <label class="input-group-text" for="inputGroupSelect01">Actividad Economica</label>
                            <select id="select2ActiEmpresa" class="select2 form-select form-select-lg select2-hidden-accessible" data-allow-clear="true" data-select2-id="select2ActiEmpresa" tabindex="-1" aria-hidden="true" wire:model.lazy='actividad' style="width: 100%;">
                                <option selected="">Elegir... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                @forelse ($actividades as $ac)
                                    <option value="{{ $ac->id }}">{{ $ac->codigo }} {{ $ac->valor }}</option>
                                @empty
                                    <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                                @endforelse
                            </select>
                        </div>
                        <span>{{ $actividadSelectName }}</span>
                        @error('actividad')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='depto' wire:click='updateDepto' wire:change="updateDepto()">
                            <option selected="">Elegir Departamento...</option>
                            @foreach ($departamentos as $depto)
                                <option value="{{ $depto->id }}">{{ $depto->departamento }}</option>
                            @endforeach
                        </select>
                        @error('depto')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='muni' wire:click='updateMuni' wire:change="updateMuni()">
                            <option selected="">Elegir Municipio...</option>
                            @foreach ($municipios as $muni)
                                <option value="{{ $muni->id }}">{{ $muni->municipio }}</option>
                            @endforeach
                        </select>
                        @error('muni')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='distrito'>
                            <option selected="">Elegir Distrito...</option>
                            @foreach ($distritos as $dis)
                                <option value="{{ $dis->id }}">{{ $dis->distrito }}</option>
                            @endforeach
                        </select>
                        @error('distrito')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="file" class="form-control custom-file-input" wire:model="image" accept="image/x-png, image/x-gif, image/x-jpeg">
                        </div>
                        <div class="d-flex align-items-center avatar-group">
                            @if ($image)
                                <div class="avatar pull-up" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $image->getClientOriginalName() }}">
                                    <img src="{{ $image->temporaryUrl() }}" alt="{{ $image->getClientOriginalName() }}" class="rounded-circle" width="38" height="38">
                                </div>
                            @else
                                <p>Sin imágen</p>
                            @endif
                        </div>
                        @error('image')
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
