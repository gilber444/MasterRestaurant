<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle }} </b></h5>
            @can('Compras_Create')
                <div class="dropdown">
                    <a href="{{ route('nueva_compra') }}" class="btn rounded-pill btn-label-primary waves-effect me-2">
                        <i class="ri-add-line"></i> Nueva compra
                    </a>
                </div>
            @endcan
        </div>
        <hr class="my-2">
        @include('common.searchbox')
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-sm">
            <thead>
                <th class="text-center">ID</th>
                <th class="text-center">FECHA COMPRA</th>
                <th class="text-center">CONDICION PAGO</th>
                <th class="text-center">PROVEEDOR</th>
                <th class="text-center">FECHA PAGO</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center" style="width: 80px;">USUARIO</th>
                <th class="text-center">ESTATUS</th>
                <th class="text-center">ACTIONS</th>
            </thead>
            <tbody>
                @foreach ($compras as $compra)
                    <tr>
                        <td class="text-center">{{ $compra->id }}</td>
                        <td class="text-center">{{ $compra->fechaCompra }}</td>
                        <td class="text-center">{{ $compra->Rcondicion->valor ?? 'N/A' }}</td>
                        <td class="text-center">{{ $compra->Rproveedor->nombre ?? 'N/A' }}</td>
                        <td class="text-center">{{ $compra->fechaPago}}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="text-center"
                                wire:click="cargarProductosCompras('{{ $compra->id }}')">
                                @php
                                    $totalProductos = DB::table('detalle_compras')
                                        ->where('compra', $compra->id)
                                        ->whereNull('deleted_at')
                                        ->sum('cantidad');

                                    echo $totalProductos;
                                @endphp
                            </a>
                        </td>
                        <td class="text-center"
                            style="width: 80px; max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $compra->Rusuario->name }}
                        </td>

                        @php
                            $isSuperUser = DB::table('users')
                                ->where('id', Auth::id())
                                ->where('profile', 'Super')
                                ->exists();
                        @endphp

                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button"
                                    class="btn dropdown-toggle waves-effect btn-outline-{{ $compra->estado === 'Autorizado' ? 'success' : ($compra->estado === 'Pendiente' ? 'warning' : 'danger') }}"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    {{ !$isSuperUser || $compra->user === Auth::id() ? 'disabled' : '' }}
                                    {{ $compra->estado === 'Anulado' || $compra->estado === 'Autorizado' ? 'disabled' : '' }}>
                                    {{ $compra->estado === 'Autorizado' ? 'Autorizado' : ($compra->estado === 'Pendiente' ? 'Pendiente' : 'Anulado') }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            wire:click="confirmar('{{ $compra->id }}')">
                                            Autorizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            wire:click="anular('{{ $compra->id }}')">
                                            Anular
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-pill" role="group">
                                @if (
                                    $compra->user === Auth::id() &&
                                        $compra->estado !== 'Anulado' &&
                                        $compra->estado !== 'Autorizado' &&
                                        DB::table('detalle_compras')->where('compra', $compra->id)->whereNull('detalle_compras.deleted_at')->count() > 0)
                                    @can('Compras_Update')
                                        <a class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                            href="{{ route('editar_compras', ['idCompra' => $compra->id]) }}">
                                            <i class="ri-edit-box-line"></i>
                                        </a>
                                    @endcan
                                @endif 
                                @if (DB::table('detalle_compras')->where('compra', $compra->id)->whereNull('detalle_compras.deleted_at')->count() == 0)
                                    @can('Compras_Destroy')
                                        <a href="#" onclick="confirmDestroy({{ $compra->id }})"
                                            class="btn rounded-pill btn-icon btn-outline-danger waves-effect btn-sm"><i
                                                class="ri-delete-bin-line"></i>
                                        </a>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer p-1">
            {{ $compras->links() }}
        </div>
        @include('livewire.compras.detalle_compras')
    </div>
</div>
@include('common.notis')
