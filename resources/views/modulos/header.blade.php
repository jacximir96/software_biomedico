<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">
            @foreach($cantidadNotificacionesCronogramaNuevo as $key => $value)
                {{$value->cantidad}}
            @endforeach
          </span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            @foreach($cantidadNotificacionesCronogramaNuevo as $key => $value)
                {{$value->cantidad}} Notificaciones
            @endforeach
          </span>

            @foreach($notificacionesCronogramaNuevo as $key => $valueNotificaciones)
                    <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <p>{{$valueNotificaciones->nombre_equipoGarantia}}</p>
                            <p># Cod. Patrimonial: {{$valueNotificaciones->cp_equipoGarantia}}</p>
                        </a>
            @endforeach

         <!--  <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
            </a> -->

<!--           <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
            </a> -->

          <div class="dropdown-divider"></div>
          <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link">

            @foreach ($administradores as $element)
                @if ($_COOKIE["email_login"] == $element->email)
                    Hola, {{$element->name}}
                @endif
            @endforeach

        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout')}}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i>
        </a>

        <form action="{{ route('logout')}}" id="logout-form" method="POST" style="display: none;">
            @csrf
        </form>
      </li>

    </ul>
  </nav>
