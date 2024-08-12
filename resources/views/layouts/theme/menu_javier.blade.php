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
                    <li class="menu-item {{ Request::is('ambiente_destinos') ? 'active' : '' }}">
                        <a href="{{ route('ambiente_destinos') }}" class="menu-link">
                            <div data-i18n="Ambiente Destino">Ambiente Destino</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_documentos') ? 'active' : '' }}">
                        <a href="{{ route('tipo_documentos') }}" class="menu-link">
                            <div data-i18n="Tipo Documentos">Tipo Documentos</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('modelo_facturacions') ? 'active' : '' }}">
                        <a href="{{ route('modelo_facturacions') }}" class="menu-link">
                            <div data-i18n="Modelo de Facturación">Modelo de Facturación</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_transmisions') ? 'active' : '' }}">
                        <a href="{{ route('tipo_transmisions') }}" class="menu-link">
                            <div data-i18n="Tipo Transmisión">Tipo Transmisión</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_contingencias') ? 'active' : '' }}">
                        <a href="{{ route('tipo_contingencias') }}" class="menu-link">
                            <div data-i18n="Tipo Contingencias">Tipo Contingencias</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('retencion_ivas') ? 'active' : '' }}">
                        <a href="{{ route('retencion_ivas') }}" class="menu-link">
                            <div data-i18n="Retención IVA">Retención IVA</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('generacion_documentos') ? 'active' : '' }}">
                        <a href="{{ route('generacion_documentos') }}" class="menu-link">
                            <div data-i18n="Generación Documentos">Generación Documentos</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_establecimientos') ? 'active' : '' }}">
                        <a href="{{ route('tipo_establecimientos') }}" class="menu-link">
                            <div data-i18n="Tipo Establecimientos">Tipo Establecimientos</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_servicio_medicos') ? 'active' : '' }}">
                        <a href="{{ route('tipo_servicio_medicos') }}" class="menu-link">
                            <div data-i18n="Servicio Médico">Servicio Médico</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tipo_items') ? 'active' : '' }}">
                        <a href="{{ route('tipo_items') }}" class="menu-link">
                            <div data-i18n="Tipo Item">Tipo Item</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('actividad_economicas') ? 'active' : '' }}">
                        <a href="{{ route('actividad_economicas') }}" class="menu-link">
                            <div data-i18n="Actividad Económicas">Actividad Económicas</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('departamentos') ? 'active' : '' }}">
                        <a href="{{ route('departamentos') }}" class="menu-link">
                            <div data-i18n="Departamentos">Departamentos</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('municipios') ? 'active' : '' }}">
                        <a href="{{ route('municipios') }}" class="menu-link">
                            <div data-i18n="Municipios">Municipios</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('distritos') ? 'active' : '' }}">
                        <a href="{{ route('distritos') }}" class="menu-link">
                            <div data-i18n="Distritos">Distritos</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('unidad_medidas') ? 'active' : '' }}">
                        <a href="{{ route('unidad_medidas') }}" class="menu-link">
                            <div data-i18n="Unidad Medidas">Unidad Medidas</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('tributos') ? 'active' : '' }}">
                        <a href="{{ route('tributos') }}" class="menu-link">
                            <div data-i18n="Tributos">Tributos</div>
                        </a>
                    </li>
                    <li class="menu-item {{-- Request::is('condicion_operacions') ? 'active' : '' --}}">
                        <a href="{{-- route('condicion_operacions') --}}" class="menu-link">
                            <div data-i18n="Condición Operación">Condición Operación</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
