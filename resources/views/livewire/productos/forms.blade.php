<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none; " aria-hidden="true">
    <div class="modal-dialog modal-lg" style="--bs-modal-width: 60rem;" role="document">
        <div class="modal-content" style="overflow:hidden;">
            @include('common.modalHeader')

            <div class="modal-body">
                @if($activateNewSection)
                    <div class="card-header overflow-hidden" style="margin-bottom:-15px;margin-top: -23px;">
                @else
                    <div class="card-header overflow-hidden">
                @endif     
                        <ul class="nav nav-tabs" role="tablist">
                        
                            @if($activateNewSection)
                                <li class="nav-item" role="presentation" >
                                    <button class="nav-link waves-effect active" data-bs-toggle="tab" data-bs-target="#form-tabs-personal" role="tab" aria-selected="true" >
                                    <span class="ri-user-line ri-20px d-sm-none"></span><span class="d-none d-sm-block">Informacion General <i class="ri-arrow-down-s-line"></i></span>
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link waves-effect" data-bs-toggle="tab" data-bs-target="#form-tabs-social" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="ri-facebook-circle-fill ri-20px d-sm-none"></span><span class="d-none d-sm-block"> Galeria De Productos <i class="ri-arrow-down-s-line"></i></span>
                                    </button>
                                </li>
                            @endif
                            
                            <span class="tab-slider" style="left: 0px; width: 210px; bottom: 0px;"></span>
                            
                        </ul>
                    </div>

            @if(!$activateNewSection)
                <div class="tab-content" style="margin-top: -4rem; border: 1px solid #e6e6e6; border-radius: 1rem; margin-bottom: 0rem;">
            @else
                <div class="tab-content" style="margin-top: 1rem; border: 1px solid #e6e6e6; border-radius: 1rem; margin-bottom: 0rem;">
            @endif
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <form>
                            <h6 class="mb-7">1. Detalles Del Producto</h6>
                            <div class="row mt-2">

                                <div class="input-group input-group-merge mb-5 w-100">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="ri-barcode-line" style="color: #8e8e8e;"></i>
                                    </span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" wire:model.lazy="codigo_barra" class="form-control" placeholder="0000000">
                                        <label for="codigo_barra">Codigo De Barra</label>

                                        @error('codigo_barra')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="input-group input-group-merge mb-5 w-50">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="ri-text" style="color: #8e8e8e;"></i>
                                    </span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" wire:model.lazy="producto" class="form-control" placeholder="Nombre del Producto">
                                        <label for="producto">Nombre De Producto</label>

                                        @error('producto')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group input-group-merge  mb-5 w-50">
                                    <span id="basic-icon-default-fullname2" class="input-group-text">
                                        <i class="ri-text" style="color: #8e8e8e;"></i>
                                    </span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" wire:model.lazy="marca" class="form-control" placeholder="Nombre del Marca">
                                        <label for="marca">Nombre De La Marca</label>

                                        @error('marca')
                                            <span class="text-danger er">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-5 w-100">
                                    <label class="input-group-text" for="inputGroupSelect01">Categorias De Productos</label>
                                    <select wire:model.lazy="categoria" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Categoria</option>
                                        <option value="Carnes & Otros">Carnes & Otros</option>
                                        <option value="Granos Basicos">Granos Basicos</option>
                                        <option value="Bebidas & Lacteos">Bebidas & Lacteos</option>
                                    </select>

                                    @error('categoria')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group col-md-6 mb-5 w-50">
                                    <label class="input-group-text" for="inputGroupSelect01">UM Interno</label>
                                    <select wire:model.lazy="unidad_medida" class="form-select " data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Unidad</option>
                                        @forelse ($unidades as $uni)
                                            <option value="{{ $uni->id }}" >{{ $uni->valor }}</option>
                                        @empty
                                            <option value=""></option>
                                        @endforelse
                                    </select>

                                    @error('unidad_medida')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-5 w-50">
                                    <label class="input-group-text" for="inputGroupSelect01">UM Hacienda</label>
                                    <select id="multicol-country" wire:model.lazy="unidad_medida_mh" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Unidad</option>
                                        @forelse ($unidades as $uni)
                                            <option value="{{ $uni->id }}" >{{ $uni->valor }}</option>
                                        @empty
                                            <option value=""></option>
                                        @endforelse
                                    </select>

                                    @error('unidad_medida_mh')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-5">
                                    <label class="custom-file-label mb-2" style="font-size: 13px">Imagen del producto: {{ $image }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="file" id="imageInput" class="form-control custom-file-input" wire:model="image"
                                            accept="image/x-png, image/x-gif, image/x-jpeg">
                                    </div>

                                    @error('image')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group input-group-merge w-50">
                                    <input type="text" id="imageChange" wire:model.lazy="imageChange" class="form-control" value="" >
                                    @error('imageChange')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </form>

                        @if($activateNewSection)
                            <form class="mt-5">
                                <h6 class="mb-3">2. Administracion De Precios</h6>
                                <div class="row mt-2">
                                    <div class="input-group input-group-merge mb-5" style="width: 50%;">
                                        <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="ri-formula " style="color: #8e8e8e;"></i>
                                        </span>

                                        <div class="form-floating form-floating-outline">
                                            <input type="text" wire:model.lazy="csiva" class="form-control" id="basic-icon-default-fullname" placeholder="C.S/IVA"">
                                            <label for="csiva">C.S/IVA</label>

                                            @error('csiva')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="input-group input-group-merge mb-5" style="width:50%;">
                                         <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="ri-formula" style="color: #8e8e8e;"></i>
                                        </span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" wire:model.lazy="civa" class="form-control" id="basic-icon-default-fullname" placeholder="C/IVA">
                                            <label for="civa">C/IVA</label>

                                            @error('civa')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif 
                    </div>

                    <div class="tab-pane fade" id="form-tabs-social" role="tabpanel">
                        <form style="display: grid;grid-template-columns: repeat(4,1fr);gap: 2.2rem;">
                            @if($activateNewSection)
                                @if ($image != null )
                                    @foreach ($allImages as $imageGalery)
                                        <div class="image-preview" style="background-color: {{ basename($imageGalery) == $image ? '#00cc21' : '#f2f2f2' }};" id="preview-{{ basename($imageGalery) }}">
                                            <img src="{{ asset($imageGalery) }}" alt="{{ basename($imageGalery) }}" style="max-width: 12rem !important; min-width: 12rem !important; max-height: 12rem !important; min-height: 12rem !important; padding: 1rem; object-fit: cover;" class="w-px-40 h-auto" onclick="highlightImage('{{ basename($imageGalery) }}')">
                                        </div>
                                    @endforeach
                                    
                                @endif


                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <script>
                let previousSelectedImage = null;

                function highlightImage(imageName) {
                    // Restablecer el fondo de la imagen previamente seleccionada
                    if (previousSelectedImage) {
                        document.getElementById(`preview-${previousSelectedImage}`).style.backgroundColor = '#f2f2f2';
                    }

                    // Cambiar el fondo de la imagen actualmente seleccionada
                    document.getElementById(`preview-${imageName}`).style.backgroundColor = '#875BE7';

                    // Actualizar la imagen previamente seleccionada
                    previousSelectedImage = imageName;

                    // Llenar el input con el nombre de la imagen seleccionada
                    document.querySelector('input[wire\\:model\\.lazy="presentacion"]').value = imageName;

                    // Si necesitas que se actualice en Livewire, dispara un evento de entrada en el input
                    document.querySelector('input[wire\\:model\\.lazy="presentacion"]').dispatchEvent(new Event('input'));
                }

                document.addEventListener('DOMContentLoaded', function () {
                    // Selecciona los elementos del DOM
                    const imageInput = document.getElementById('imageInput');
                    const presentacionInput = document.getElementById('imageChange');

                    // Agrega un evento de cambio para el input de archivo
                    imageInput.addEventListener('change', function () {
                        if (imageInput.files.length > 0) {
                            // Si hay un archivo en el input, limpia el campo de texto
                            presentacionInput.value = '';
                        }
                    });

                    // Agrega un evento de cambio para el campo de texto
                    presentacionInput.addEventListener('input', function () {
                        if (presentacionInput.value.trim() !== '') {
                            // Si el campo de texto no está vacío, limpia el input de archivo
                            imageInput.value = '';
                        }
                    });
                });
            </script>

            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
