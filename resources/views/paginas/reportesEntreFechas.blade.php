@foreach ($administradores as $element)
@if ($_COOKIE["email_login"] == $element->email)
@extends('plantilla')
@section('content')

<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Reportes entre fechas
            </h2>

            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ url("/") }}">Inicio /</a>
                    </li>
                    <li class="font-medium text-primary">Reportes entre fechas</li>
                </ol>
            </nav>
        </div>

        <h4
            class="mb-6 text-black dark:text-white">
            Bienvenidos, aquí se detallarán los reportes entre fechas.
        </h4>

        <div class="rounded-lg shadow-md border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <form action="{{ url('/') }}/reportesEntreFechas/entreFechasPDF" method="get" target="_blank">
                <div class="flex flex-wrap justify-between items-center p-4 border-b px-4 py-6 md:px-6 xl:px-7.5">
                    <div>
                        <h2 class="text-gray-700 text-xl font-bold text-black dark:text-white">Mantenimientos por orden de servicio</h2>
                    </div>

                    <div id="asignar-botones">
                        <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium 
                                text-white hover:bg-opacity-90 min-w-150 ml-333 button-general">
                            Generar reporte (PDF)
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap gap-5.5 p-6.5">
                    <div class="w-full-mitad md:w-full">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Fecha de inicio
                        </label>
                        <input name="fecha_inicial_reportes" required autofocus onfocus="(this.type='date')"
                            class="form-datepicker w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                    </div>

                    <div class="w-full-mitad md:w-full">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Fecha de fin
                        </label>
                        <input name="fecha_inicial_reportes" required autofocus onfocus="(this.type='date')"
                            class="form-datepicker w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                    </div>
                </div>
            </form>

            <form action="{{ url('/') }}/reportesEntreFechas/entreFechasOTM" method="get" target="_blank">
                <div class="flex flex-wrap justify-between items-center p-4 border-b border-t px-4 py-6 md:px-6 xl:px-7.5">
                    <div>
                        <h2 class="text-gray-700 text-xl font-bold text-black dark:text-white">Mantenimientos por OTM</h2>
                    </div>

                    <div id="asignar-botones">
                        <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium 
                                text-white hover:bg-opacity-90 min-w-150 ml-333 button-general">
                            Generar reporte (PDF)
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap gap-5.5 p-6.5">
                    <div class="w-full-mitad md:w-full">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Fecha de inicio
                        </label>
                        <input name="fecha_inicial_reportes" required autofocus onfocus="(this.type='date')"
                            class="form-datepicker w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                    </div>

                    <div class="w-full-mitad md:w-full">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Fecha de fin
                        </label>
                        <input name="fecha_final_reportes" required autofocus onfocus="(this.type='date')"
                            class="form-datepicker w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
      function dropdown() {
        return {
          options: [],
          selected: [],
          show: false,
          open() {
            this.show = true;
          },
          close() {
            this.show = false;
          },
          isOpen() {
            return this.show === true;
          },
          select(index, event) {
            if (!this.options[index].selected) {
              this.options[index].selected = true;
              this.options[index].element = event.target;
              this.selected.push(index);
            } else {
              this.selected.splice(this.selected.lastIndexOf(index), 1);
              this.options[index].selected = false;
            }
          },
          remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);
          },
          loadOptions() {
            const options = document.getElementById("select").options;
            for (let i = 0; i < options.length; i++) {
              this.options.push({
                value: options[i].value,
                text: options[i].innerText,
                selected:
                  options[i].getAttribute("selected") != null
                    ? options[i].getAttribute("selected")
                    : false,
              });
            }
          },
          selectedValues() {
            return this.selected.map((option) => {
              return this.options[option].value;
            });
          },
        };
      }
    </script>

@if (Session::has("ok-crear"))
    <script>
        notie.alert({type:1,text:'!El Rol ha sido creado correctamente', time:10})
    </script>
@endif

@if (Session::has("no-validacion"))
    <script>
        notie.alert({type:2,text:'!Hay campos no válidos en el formulario', time:10})
    </script>
@endif

@if (Session::has("error"))
    <script>
        notie.alert({type:3,text:'!Error en el gestor de roles', time:10})
    </script>
@endif

@if (Session::has("ok-editar"))
    <script>
        notie.alert({type:1,text:'!El Rol ha sido actualizado correctamente', time:10})
    </script>
@endif

@if (Session::has("ok-eliminar"))
    <script>
        notie.alert({ type: 1, text: '¡El Rol ha sido eliminado correctamente!', time: 10 })
    </script>
@endif

@if (Session::has("no-borrar"))
    <script>
        notie.alert({ type: 2, text: '¡Este administrador no se puede borrar!', time: 10 })
    </script>
@endif

@endsection

@endif

@endforeach
