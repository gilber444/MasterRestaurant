<div wire:ignore.self class="modal fade" id="MyModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MyModal">Reporte de Kardex
                </h5>
                <h6 class="text-center text-warning" wire:loading> POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" id="imprimir">
                <div class="row">
                    <div class="col text-center">
                        <h6>Kardex de {{ $producto }}</h6>
                        <h6> Desde {{  \Carbon\Carbon::parse($desde)->format('d/m/Y') }} hasta {{  \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</h6>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="table-responsible">
                            <table class="table table-sm" id="tabla">
                                <thead>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Sucursal</th>
                                    <th class="text-center">Entrada</th>
                                    <th class="text-center">Salida</th>
                                    <th class="text-center">Saldo</th>
                                </thead>
                                <tbody>
                                    @foreach ($inicial as $ini )
                                        <tr>
                                            <td class="text-center">{{  \Carbon\Carbon::parse($ini->fecha)->format('d/m/Y') }}</td>
                                            <td>Saldo Anterior</td>
                                            <td class="text-center">{{ $ini->Rsucursal->nombre }}</td>
                                            <td class="text-center">{{ $ini->ingreso }}</td>
                                            <td class="text-center">{{ $ini->egreso }}</td>
                                            <td class="text-center">{{ $ini->saldo }}</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($kardes as $item )
                                        <tr>
                                            <td class="text-center">{{  \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                                            <td>{{ $item->descripcion }}</td>
                                            <td class="text-center">{{ $item->Rsucursal->nombre }}</td>
                                            <td class="text-center">{{ number_format($item->ingreso,0) }}</td>
                                            <td class="text-center">{{ number_format($item->egreso,0) }}</td>
                                            <td class="text-center">{{ number_format($item->saldo,0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="exportToExcel('#imprimir', 'Reporte de Kardex')" class="btn btn-primary"> <i class="fa-solid fa-file-export"></i> Exportar a Excel</button>
                <button onclick="imprimirDiv()" class="btn btn-primary"><i class="fa-solid fa-print"></i> Imprimir</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
