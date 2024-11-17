{{-- Productos --}}

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon ri-git-repository-commits-fill"></i>
        <div data-i18n="Admin Insumos">Admin Insumos</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ Request::is('productos') ? 'active' : '' }}">
            <a href="{{ route('productos') }}" class="menu-link">
                <div data-i18n="Productos">Productos</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('productosCategorias') ? 'active' : '' }}">
            <a href="{{ route('productosCategorias') }}" class="menu-link">
                <div data-i18n="Categorias">Categorias</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('productosUnidadMedidas') ? 'active' : '' }}">
            <a href="{{ route('productosUnidadMedidas') }}" class="menu-link">
                <div data-i18n="Unidad de Medida">Unidad de Medida</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('productosMarcas') ? 'active' : '' }}">
            <a href="{{ route('productosMarcas') }}" class="menu-link">
                <div data-i18n="Marcas">Marcas</div>
            </a>
        </li>
    </ul>
</li>