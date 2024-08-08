{{-- CATALOGOS MINISTERIO DE ACIENDA --}}

    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ri-book-open-fill"></i>
            <div data-i18n="Admin Catálogos MH">Admin Catálogos MH</div>
        </a>
        <ul class="menu-sub">
            {{-- CATALOGOS DTE --}}
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="Catálogos DTE">Catálogos DTE</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('unidad_medidas') ? 'active' : '' }}">
                        <a href="{{ route('unidad_medidas') }}" class="menu-link">
                            <div data-i18n="Unidad Medidas">Unidad Medidas</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('actividad_economicas') ? 'active' : '' }}">
                        <a href="{{ route('actividad_economicas') }}" class="menu-link">
                            <div data-i18n="Actividad Económicas">Actividad Económicas</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
