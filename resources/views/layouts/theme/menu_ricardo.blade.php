{{-- Productos --}}

<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon ri-product-hunt-fill"></i>
        <div data-i18n="Admin Productos">Admin Productos</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ Request::is('productos') ? 'active' : '' }}">
            <a href="{{ route('productos') }}" class="menu-link">
                <div data-i18n="Productos">Productos</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('precios') ? 'active' : '' }}">
            <a href="{{ route('productos') }}" class="menu-link">
                <div data-i18n="Precios">Precios</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('categorias') ? 'active' : '' }}">
            <a href="{{ route('productos') }}" class="menu-link">
                <div data-i18n="Categorias">Categorias</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('uminterno') ? 'active' : '' }}">
            <a href="{{ route('productos') }}" class="menu-link">
                <div data-i18n="Unidad de Medida">Unidad de Medida</div>
            </a>
        </li>
    </ul>
</li>