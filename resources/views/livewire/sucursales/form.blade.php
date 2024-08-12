<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-3 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='numero' class="form-control" placeholder="Numero">
                            <label for="">Numero</label>
                        </div>
                        @error('numero') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-9 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='nombre' class="form-control" placeholder="Nombre de la Sucrusal">
                            <label for="">Nombre de la Sucursal</label>
                        </div>
                        @error('nombre') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="form-floating form-floating-outline">
                            <textarea wire:model='direccion' cols="30" rows="3" class="form-control" placeholder="Direccion de la Sucursal"></textarea>
                            <label for="">Direccion</label>
                        </div>
                        @error('direccion') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='telefono' class="form-control" placeholder="00000000">
                            <label for="">Telefono</label>
                        </div>
                        @error('nit') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" wire:model.lazy='cajas' class="form-control" placeholder="Cajas">
                            <label for="">Cantidad de Cajas</label>
                        </div>
                        @error('cajas') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="inputGroupSelect01">Tipo Establecimiento</label>
                            <select class="form-select" id="inputGroupSelect01" wire:model.lazy='tipo'>
                                <option selected="">Elegir...</option>
                                @foreach ($establecimientos as $estable )
                                <option value="{{$estable->id}}">{{$estable->valor}}</option>
                                @endforeach
                            </select>
                          </div>
                        @error('reposable') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-12 mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="inputGroupSelect01">Empresa</label>
                            <select class="form-select" id="inputGroupSelect01" wire:model.lazy='empresa'>
                                <option selected="">Elegir...</option>
                                @foreach ($empresas as $empresa )
                                <option value="{{$empresa->id}}">{{$empresa->empresa}}</option>
                                @endforeach
                            </select>
                          </div>
                        @error('reposable') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='depto' wire:click='updateDepto' wire:change="updateDepto()">
                            <option selected="">Elegir Departamento...</option>
                            @foreach ($departamentos as $depto )
                            <option value="{{$depto->id}}">{{$depto->departamento}}</option>
                            @endforeach
                        </select>
                        @error('depto') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='muni' wire:click='updateMuni' wire:change="updateMuni()">
                            <option selected="">Elegir Municipio...</option>
                            @foreach ($municipios as $muni )
                            <option value="{{$muni->id}}">{{$muni->municipio}}</option>
                            @endforeach
                        </select>
                        @error('muni') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                        <select class="form-select" wire:model.lazy='distrito'>
                            <option selected="">Elegir Distrito...</option>
                            @foreach ($distritos as $dis )
                            <option value="{{$dis->id}}">{{$dis->distrito}}</option>
                            @endforeach
                        </select>
                        @error('distrito') <span class="text-danger er">{{ $message}}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
