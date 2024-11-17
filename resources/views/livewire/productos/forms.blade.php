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

                                <div class="input-group col-md-6 mb-5 w-50">
                                    <label class="input-group-text" for="inputGroupSelect01">Marca</label>
                                    <select wire:model.lazy="marca" class="form-select " data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Marca</option>
                                        @forelse ($marcas as $marca)
                                            <option value="{{ $marca->id }}" >{{ $marca->nombre }}</option>
                                        @empty
                                            <option value=""></option>
                                        @endforelse
                                    </select>

                                    @error('marca')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-5 w-100">
                                    <label class="input-group-text" for="inputGroupSelect01">Categorias De Productos</label>
                                    <select wire:model.lazy="categoria" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Categoria</option>
                                        @forelse ($categorias as $cat)
                                            <option value="{{ $cat->id }}" >{{ $cat->categoria }}</option>
                                        @empty
                                            <option value=""></option>
                                        @endforelse
                                    </select>

                                    @error('categoria')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group col-md-6 mb-5 w-50">
                                    <label class="input-group-text" for="inputGroupSelect01">UM Interno</label>
                                    <select wire:model.lazy="unidad_medida" class="form-select " data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="" >Seleccionar Unidad</option>
                                        @forelse ($unidadesInterno as $uni)
                                            <option value="{{ $uni->id }}" >{{ $uni->nombre }}</option>
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

                                <div class="input-group mb-5 w-50">
                                    <label class="custom-file-label mb-2" style="font-size: 13px">Imagen del producto: {{ $image }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="file" id="imageInput" class="form-control custom-file-input" wire:model="image"
                                            accept="image/x-png, image/x-gif, image/x-jpeg">
                                    </div>

                                    @error('image')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-5 w-50" style="margin-top: 1.62rem;">
                                    <label class="input-group-text" for="inputGroupSelect01">Activo</label>
                                    <select wire:model.lazy="presentacion" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                        <option value="">Seleccionar estado</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>

                                    @error('presentacion')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group input-group-merge w-50">
                                    <input type="text" id="imageChange" wire:model.lazy="imageChange" class="form-control" value="" style="display: none;" >
                                    @error('imageChange')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </form>

                        @if($activateNewSection)
                            <form class="mt-5">
                                <h6 class="mb-3">2. Administracion De Costos</h6>
                                <div class="row mt-6">
                                    <div class="input-group input-group-merge mb-5" style="width:50%;">
                                         <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="ri-formula" style="color: #8e8e8e;"></i>
                                        </span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" wire:model.lazy="civa" wire:keydown.enter="actualizarCostoSinIva1" class="form-control" id="basic-icon-default-fullname" placeholder="C/IVA" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').slice(0, 5);">
                                            <label for="civa">C/IVA</label>

                                            @error('civa')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="input-group input-group-merge mb-5" style="width: 50%;">
                                        <span id="basic-icon-default-fullname2" class="input-group-text">
                                            <i class="ri-formula " style="color: #8e8e8e;"></i>
                                        </span>

                                        <div class="form-floating form-floating-outline">
                                            <input type="text" wire:model.lazy="csiva"  class="form-control" id="basic-icon-default-fullname" placeholder="C.S/IVA" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').slice(0, 5);">
                                            <label for="csiva">C.S/IVA</label>

                                            @error('csiva')
                                                <span class="text-danger er">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </form>
                        @endif 
                    </div>

                    <div class="tab-pane fade" id="form-tabs-social" role="tabpanel" style="height: 33.6rem;overflow: hidden;overflow-y: auto;padding: 0rem 0rem;">
                        <form style="display: grid;grid-template-columns: repeat(4,1fr);gap: 1.2rem;padding: 0rem 1rem;"  id="image-gallery">
                            @if($activateNewSection)
                                @foreach ($allImages as $imageGalery)
                                    <div style=" width: 11.5rem;">

                                        <div 
                                        class="image-preview {{ basename($imageGalery) == $image ? 'selected-image' : 'no-selected-image' }}" 
                                        style="background-color: {{ basename($imageGalery) == $image ? '#00cc21' : '#f2f2f2' }};" id="preview-{{ basename($imageGalery) }}"
                                        >
                                            <img src="{{ asset($imageGalery) }}" alt="{{ basename($imageGalery) }}" style="max-width: 11.5rem !important; min-width: 11.5rem !important; max-height: 11.5rem !important; min-height: 11.5rem !important; padding: 0.5rem; object-fit: cover;" class="w-px-40 h-auto">

                                            
                                        </div>


                                        @if (basename($imageGalery) != $image)
                                            <div class="demo-inline-spacing" >
                                                <style>
                                                    .selected-image-b{
                                                        display: none !important;
                                                    }

                                                </style>
                                                <button onclick="highlightImage('{{ basename($imageGalery) }}')" type="button" class="btn btn-icon btn-label-primary waves-effect {{ basename($imageGalery) == $image ? 'selected-image-b' : 'no-selected-image-b' }}">
                                                    <span class="tf-icons ri-check-double-line ri-22px"></span>
                                                </button>

                                                <button wire:click.prevent="eliminarImagen('{{ basename($imageGalery) }}')"  type="button" class="btn btn-icon btn-label-secondary waves-effect {{ basename($imageGalery) == $image ? 'selected-image-b' : 'no-selected-image-b' }}"  >
                                                    <i  class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
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
                    document.getElementById(`preview-${imageName}`).style.backgroundColor = '#FFB400';
                        const previouslySelectedElement = document.querySelector('.selected-image');
                        if (previouslySelectedElement) {
                            previouslySelectedElement.style.backgroundColor = '#f2f2f2';
                            previouslySelectedElement.classList.remove('selected-image');
                        }
                    let buttonsImg = document.querySelectorAll('.selected-image-b');
                    console.log()
                    buttonsImg.forEach(function(button) {
                        button.style.setProperty('display', 'inline-block', 'important');
                    });

                    // Actualizar la imagen previamente seleccionada
                    previousSelectedImage = imageName;

                    // Llenar el input con el nombre de la imagen seleccionada
                    document.querySelector('input[wire\\:model\\.lazy="imageChange"]').value = imageName;

                    // Si necesitas que se actualice en Livewire, dispara un evento de entrada en el input
                    document.querySelector('input[wire\\:model\\.lazy="imageChange"]').dispatchEvent(new Event('input'));
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

                function confirmDestroyImg(imgDelete) {
                    Swal.fire({
                        title: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
                        text: "",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('ejecutar funcion')
                            Livewire.dispatch('eliminarImagen', {
                                imgDelete: imgDelete
                            });
                        }
                    });
                }

                
            </script>

            <div class="modal-footer">
                @include('common.modalFooter')
            </div>
        </div>
    </div>
</div>
