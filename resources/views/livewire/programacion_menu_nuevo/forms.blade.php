<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none; " aria-hidden="true">
    <div class="modal-dialog modal-lg" style="--bs-modal-width: 50rem;" role="document">
        <div class="modal-content" style="overflow:hidden;">
            <div class="modal-body">
                <div class="tab-content" style="border-radius: 1rem; margin-bottom: 0rem;">
                    <div class="tab-pane fade active show" id="form-tabs-personal" role="tabpanel">
                        <form>
                            <h5 class="mb-7">Resumen - Productos Insuficiente <i class="ri-arrow-down-wide-line"></i> </h5>
                            <div class="row mt-2">
                                @if ($existenciasInsuficientes)
                                    @foreach ($existenciasInsuficientes as $i)
                                        <div class="d-flex justify-content-between align-items-center border-bottom py-4 mb-4">
                                            <h6 class="m-0 " style="flex: 2; font-size: 0.8rem;">
                                                {{ $i['producto_name'] }} <i class="ri-arrow-right-double-fill"></i>
                                            </h6>
                                            <p class="m-0 d-none d-sm-block w-10" style="font-size: 0.8rem !important; flex: 1;">
                                                <span style="font-weight: bold; color: orange;">Existencias:</span>  {{ floor($i['existencia_number']) }} Unidades
                                            </p>
                                            <p class="m-0 d-none d-sm-block w-10" style="font-size: 0.8rem; !important; flex: 1;">
                                                <span style="font-weight: bold; color: red;">Requerido:</span> 
                                                {{ $i['existencia_formula'] }} Unidades
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
