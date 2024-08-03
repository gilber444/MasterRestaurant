<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('common.modalHeader')
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-8">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="name" class="form-control"
                                placeholder="Nombre del Usuario">
                            <label for="name">Nombre del Usuario</label>
                            @error('name')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="usuario" class="form-control" placeholder="Usuario">
                            <label for="usuario">Usuario</label>
                            @error('usuario')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-8">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="email" class="form-control"
                                placeholder="ej: laravel@dmin.com">
                            <label for="email">Correo Electronico</label>
                            @error('email')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" wire:model.lazy="phone" class="form-control"
                                placeholder="ej: 00000000">
                            <label for="phone">Telefono</label>
                            @error('phone')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="password" wire:model="password" class="form-control" placeholder="Contraseña">
                            <label for="password">Contraseña</label>
                            @error('password')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select class="form-select" wire:model="status" aria-label="Default select example">
                                <option value="" selected>Elegir</option>
                                <option value="ACTIVE">Activo</option>
                                <option value="LOCKED">Bloqueado</option>
                            </select>
                            <label for="status">Estatus</label>
                            @error('status')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select wire:model="profile" class="form-control" aria-label="Default select example">
                                <option value="" selected>Elegir</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label for="profile">Asignar Rol</label>
                            @error('profile')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <select wire:model="empresa" class="form-control" aria-label="Default select example">
                                <option value="" selected>Elegir</option>
                                <option value="1" >1</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razon }}</option>
                                @endforeach
                            </select>
                            <label for="empresa">Empresa</label>
                            @error('empresa')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-12">
                        <div class="mb-1">
                            <label for="formFile" class="form-label">Imagen del Perfil</label>
                            <input class="form-control" type="file" wire:model="image"
                                accept="image/x-png, image/x-gif, image/x-jpeg">
                            @error('image')
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
