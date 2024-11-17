<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"><b> {{ $componentName }} | {{ $pageTitle }} </b></h5>
            @can('Ajustes_Create')
                <div class="dropdown">
                    <a href="{{ route('nuevo_ajustes') }}" class="btn rounded-pill btn-label-primary waves-effect me-2">
                        <i class="ri-add-line"></i> Nuevo Ajuste
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
                <th class="text-center">FECHA</th>
                <th class="text-center">DETALLE</th>
                <th class="text-center">SUCURSAL</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">TIPO</th>
                <th class="text-center" style="width: 80px;">USUARIO</th>
                <th class="text-center">ESTATUS</th>
                <th class="text-center">ACTIONS</th>
            </thead>
            <tbody>
                @foreach ($ajustes as $ajuste)
                    <tr>
                        <td class="text-center">{{ $ajuste->id }}</td>
                        <td class="text-center">{{ $ajuste->fecha }}</td>
                        <td class="text-center">{{ $ajuste->detalle }}</td>
                        <td class="text-center">{{ $ajuste->Rsucursal->nombre ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="text-center"
                                wire:click="cargarProductosAjustes('{{ $ajuste->id }}')">
                                @php
                                    $totalProductos = DB::table('detalle_ajustes')
                                        ->where('ajuste', $ajuste->id)
                                        ->whereNull('deleted_at')
                                        ->sum('cantidad');

                                    echo $totalProductos;
                                @endphp
                            </a>
                        </td>
                        <td class="text-center">{{ $ajuste->tipo }}</td>
                        <td class="text-center"
                            style="width: 80px; max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $ajuste->Rusuario->name }}
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
                                    class="btn dropdown-toggle waves-effect btn-outline-{{ $ajuste->status === 'Autorizado' ? 'success' : ($ajuste->status === 'Pendiente' ? 'warning' : 'danger') }}"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    {{ !$isSuperUser || $ajuste->user === Auth::id() ? 'disabled' : '' }}
                                    {{ $ajuste->status === 'Anulado' || $ajuste->status === 'Autorizado' ? 'disabled' : '' }}>
                                    {{ $ajuste->status === 'Autorizado' ? 'Autorizado' : ($ajuste->status === 'Pendiente' ? 'Pendiente' : 'Anulado') }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            wire:click="confirmar('{{ $ajuste->id }}')">
                                            Autorizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            wire:click="anular('{{ $ajuste->id }}')">
                                            Anular
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-pill" role="group">
                                @if (
                                    $ajuste->user === Auth::id() &&
                                        $ajuste->status !== 'Anulado' &&
                                        $ajuste->status !== 'Autorizado' &&
                                        DB::table('detalle_ajustes')->where('ajuste', $ajuste->id)->whereNull('detalle_ajustes.deleted_at')->count() > 0)
                                    @can('Ajustes_Update')
                                        <a class="btn rounded-pill btn-icon btn-outline-warning waves-effect btn-sm"
                                            href="{{ route('editar_ajustes', ['idAjuste' => $ajuste->id]) }}">
                                            <i class="ri-edit-box-line"></i>
                                        </a>
                                    @endcan
                                @endif
                                @if (DB::table('detalle_ajustes')->where('ajuste', $ajuste->id)->whereNull('detalle_ajustes.deleted_at')->count() == 0)
                                    @can('Ajustes_Destroy')
                                        <a href="#" onclick="confirmDestroy({{ $ajuste->id }})"
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
            {{ $ajustes->links() }}
        </div>
        @include('livewire.ajustes.detalle_ajuste')
    </div>
</div>
@include('common.notis')
