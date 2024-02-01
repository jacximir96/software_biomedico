<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ url('/') }}/vistas/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Software Biomédico</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @foreach ($administradores as $element)
                @if ($_COOKIE["email_login"] == $element->email)
                   @if ($element->foto == "")
                    <img src="{{ url('/') }}/vistas/img/admin.png" class="img-circle elevation-2" alt="User Image">
                   @else
                   <img src="{{ url('/') }}/{{$element->foto}}" class="img-circle elevation-2" alt="User Image">
                   @endif
                @endif
            @endforeach

        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{-- Verificar el usuario que ingresó al sistema --}}
            @foreach ($administradores as $element)
                @if ($_COOKIE["email_login"] == $element->email)
                    {{$element->name}}
                @endif
            @endforeach
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Verificar el usuario que ingresó al sistema --}}
                    @foreach ($administradores as $element)
                        @if ($_COOKIE["email_login"] == $element->email)

                                <!--=====================================
                                Botón Dashboard
                                ======================================-->
                                <li class="nav-item">
                                    <a href="{{ url("/dashboard") }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Inicio</p>
                                    </a>
                                </li>

                                <!--=====================================
                                Botón Dashboard
                                ======================================-->
                                <li class="nav-item">
                                    <a href="{{ url("/manual") }}" class="nav-link">
                                    <i class="nav-icon fas fa-book-open"></i>
                                    <p>Manual</p>
                                    </a>
                                </li>



                                <!--=====================================
                                Botón Administradores
                                ======================================-->
                                <!-- <li class="nav-item">
                                    <a href="{{ url("/administradores") }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>Administradores</p>
                                    </a>
                                </li> -->

                                <!--=====================================
                                Botón Dirección Ejecutiva
                                ======================================-->
                                <li class="nav-item">
                                    <a href="{{ url("/direccionesEjecutivas") }}" class="nav-link">
                                        <i class="nav-icon fas fa-boxes"></i>
                                        <p>Direcciones Ejecutivas</p>
                                    </a>
                                </li>

                                <!--=====================================
                                Botón Departamentos
                                ======================================-->
                                <li class="nav-item">
                                    <a href="{{ url("/departamentos") }}" class="nav-link">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p>Departamentos</p>
                                    </a>
                                </li>

                                <!--=====================================
                                Botón Departamentos
                                ======================================-->
                                @canany(['ver_ambientes','crear_ambientes','editar_ambientes','eliminar_ambientes'])
                                <li class="nav-item">
                                    <a href="{{ url("/ambientes") }}" class="nav-link">
                                        <i class="nav-icon fas fa-hotel"></i>
                                        <p>Ambientes</p>
                                    </a>
                                </li>
                                @endcan

                                <!--=====================================
                                Gestión de Equipos
                                ======================================-->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-medical-alt"></i>
                                    <p>
                                        Equipos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>

                                    <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url("/equipos") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Equipos por Servicio</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url("/equiposGarantia") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Equipos por Compra</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url("/equiposReposicion") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Equipos por Reposición</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url("/equiposBaja") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Equipos de Baja</p>
                                        </a>
                                    </li>

                                    </ul>
                                </li>

                                <!--=====================================
                                Botón Proveedores
                                ======================================-->
                                @canany(['ver_proveedores','crear_proveedores','editar_proveedores','eliminar_proveedores'])
                                <li class="nav-item">
                                    <a href="{{ url("/proveedores") }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-cog"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                                @endcan

                                <!--=====================================
                                Botón Mantenimientos
                                ======================================-->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-wrench"></i>
                                    <p>
                                        Mantenimientos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>

                                    <ul class="nav nav-treeview">

                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                                <p>Por Servicio<i class="right fas fa-angle-left"></i></p>
                                            </a>

                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="{{ url("/cronogramasGeneral") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cronograma General</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/cronogramas") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cronograma (Calendario)</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/cronogramasLista") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cronograma (Lista)</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/tipoMantenimientos") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Tipo de Mantenimiento</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/historialEquipos") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Historial</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/ordenServicios") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Orden de Servicio</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item has-treeview">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-arrow-circle-right"></i>
                                                <p>Por Compra<i class="right fas fa-angle-left"></i></p>
                                            </a>

                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="{{ url("/cronogramasGeneralNuevo") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cronograma General</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/cronogramasCalendario") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cronograma (Calendario)</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ url("/historialEquiposCompra") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Historial</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <!--=====================================
                                Botón Gestión de Usuarios
                                ======================================-->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chart-pie"></i>
                                    <p>
                                        Gestión de Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>

                                    <ul class="nav nav-treeview">

                                    @canany(['ver_usuarios','crear_usuarios','editar_usuarios','eliminar_usuarios'])
                                    <li class="nav-item">
                                        <a href="{{ url("/administradores") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                        </a>
                                    </li>
                                    @endcan


                                    <li class="nav-item">
                                        <a href="{{ url("/roles") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                        </a>
                                    </li>

                                    </ul>
                                </li>

                                <!--=====================================
                                Botón Reportes
                                ======================================-->
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Reportes
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>

                                    <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ url("/reportesEntreFechas") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Entre Fechas</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url("/reportesFormato7") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Formato 7.1</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url("/reportesFormato8") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Formato 8</p>
                                        </a>
                                    </li>

                                    </ul>
                                </li>

                        @endif
                    @endforeach

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
