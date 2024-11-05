@extends('plantilla')
@section('content')

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-9 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Manual de usuario
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Manual de usuario</li>
                </ol>
            </nav>
        </div>

        <h4
            class="mb-6 text-black dark:text-white">
            Bienvenidos al sistema Biomédico, para cualquier información pueden revisar el siguiente manual del usuario.
        </h4>

        <iframe src="https://docs.google.com/viewer?srcid=1PoUIh7yyjqkw5lGnSdBad4hxM1vVreSu&pid=explorer&efh=false&a=v&chrome=false&embedded=true"
            width="100%" height="680px">
        </iframe>
    </div>
</main>

<!-- <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bienvenidos al Sistema Biomédico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url("/") }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Manual de Usuario</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <p>Bienvenidos al sistema Biomédico, para cualquier información pueden revisar el siguiente manual del usuario.</p>

                            </br>

                            <iframe src="https://docs.google.com/viewer?srcid=1PoUIh7yyjqkw5lGnSdBad4hxM1vVreSu&pid=explorer&efh=false&a=v&chrome=false&embedded=true"
                                width="100%" height="680px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> -->
@endsection