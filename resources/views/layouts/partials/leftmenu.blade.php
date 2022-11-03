<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ url('/') }}" class="waves-effect">
                        <i class="dripicons-home"></i>
                        <span>Pantalla de inicio</span>
                    </a>
                </li>
                 @can('Ver Usuario')
                <li>

                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-lock"></i>
                        <span>Seguridad</span>
                    </a>
                    <ul class="sub-menu" >
                        @can('Ver Usuario')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Usuarios</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('usuarios') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan
                         @can('Ver Role')
                         <li>
                            <a href="javascript: void(0);" class="has-arrow">Roles</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('roles') }}">Ver datos</a></li>
                                <li><a href="{{ url('roles/create') }}">Nuevo Role</a></li>
                            </ul>
                        </li>
                        @endcan
                         @can('Ver Permisos')
                         <li>
                            <a href="javascript: void(0);" class="has-arrow">Permisos</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('permission') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan
                         @can('Ver Gerencia')
                         <li>
                            <a href="javascript: void(0);" class="has-arrow">Gerencias</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('gerencia') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan
                        @can('Ver Historial de Montos')
                         <li>
                            <a href="javascript: void(0);" class="has-arrow">Historial de montos</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('historialmontos') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan
                        @can('Ver LogSistema')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Logs del sistema</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('logs') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan
                        @can('Ver Log del sistema')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Historial de logueo</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('logins') }}">Ver datos</a></li>

                            </ul>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endcan

                 <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="dripicons-user"></i>
                        <span>Registros generales</span>
                    </a>
                    <ul class="sub-menu" >
                        @can('Ver Monto Global')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Monto global</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('montoglobal') }}">Ver datos</a></li>


                            </ul>
                        </li>
                        @endcan
                        @can('Ver Tasa')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Tasa del dólar</a>
                            <ul class="sub-menu" >
                                <li><a href="{{ url('tasa') }}">Ver datos</a></li>


                            </ul>
                        </li>
                        @endcan
                       @can('Ver Titulares')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Titulares</a>
                            <ul class="sub-menu" >
                                @can('Ver Titulares')
                                <li><a href="{{ url('personal') }}">Ver datos</a></li>
                                @endcan
                                @can('Registrar Titulares')
                                <li><a href="{{ url('personal/create') }}">Registro de datos</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                          <li>
                            <a href="javascript: void(0);" class="has-arrow">Beneficiarios</a>
                            <ul class="sub-menu" >
                                @can('Ver Beneficiario')
                                <li><a href="{{ url('beneficiario') }}">Ver datos</a></li>
                                @endcan
                                @can('Registrar Beneficiario')
                                <li><a href="{{ url('beneficiario/create') }}">Registro de datos</a></li>
                                @endcan

                            </ul>
                        </li>
                        @can('Ver Proveedores')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Proveedores</a>
                            <ul class="sub-menu" >
                                @can('Ver Proveedores')
                                <li><a href="{{ url('proveedores') }}">Ver datos</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                         <li>
                            <a href="javascript: void(0);" class="has-arrow">Facturas</a>
                            <ul class="sub-menu" >
                                @can('Ver Factura')
                                <li><a href="{{ url('facturas') }}">Ver datos</a></li>
                                @endcan
                                @can('Registrar Factura')
                                <li><a href="{{ url('facturas/create') }}">Registro de datos</a></li>
                                @endcan

                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">Reembolsos</a>
                            <ul class="sub-menu" >
                                @can('Ver Reembolso')
                                <li><a href="{{ url('reembolsos') }}">Ver datos</a></li>
                                @endcan
                                @can('Registrar Reembolso')
                                <li><a href="{{ url('reembolsos/create') }}">Registro de datos</a></li>
                                @endcan

                            </ul>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
Footer
