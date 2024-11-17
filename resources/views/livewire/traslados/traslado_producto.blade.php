<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Traslado - Productos</h5>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-sm">
                            <thead>
                                <th class="text-center">ID Producto</th>
                                <th class="text-center">CANTIDAD</th>
                                <th class="text-center">PRODUCTO</th> 
                                <th class="text-center">MEDIDA</th>    
                                <th class="text-center">CATEGORIA</th>                                  
                                <th></th>
                            </thead>
                            <tbody> 
                                @foreach ($detalleAjustes as $det)
                                    <tr>
                                        <td class="text-center">{{ $det['producto_id'] }}</td>
                                        <td class="text-center">{{ number_format($det['cantidad'], 0) }}</td>
                                        <td class="text-center">{{ $det['producto'] }}</td>
                                        <td class="text-center">{{ $det['medida'] }}</td>
                                        <td class="text-center">{{ $det['categoria'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                    data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>