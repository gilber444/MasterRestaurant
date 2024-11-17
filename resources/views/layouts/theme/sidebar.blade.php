<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <span style="color: var(--bs-primary)">
                    @php
                        $empresa = DB::table('empresas')->first();
                    @endphp
                    @if ($empresa)
                        <img src="{{ route('empresas.mostrar', ['imagen' => $empresa->image]) }}" width="30px" class="responsive">
                    @endif
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2 text-sm">
                @php
                    $empresa = DB::table('empresas')->first();
                @endphp
                @if ($empresa)
                    {{ $empresa->razon }}
                @endif
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    @include('layouts.theme.menu')
</aside>
