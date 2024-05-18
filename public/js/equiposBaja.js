$("#equiposBaja").DataTable({
	processing: true,
    serverSide: true,
	ajax :ruta+"/obtenerEquipoBaja",

	columns: [
        {
            data: null, // Utilizamos null ya que no hay una propiedad específica asociada
            name: 'correlativo', // Nombre de la columna
            render: function (data, type, row, meta) {
                // Devolvemos el número de fila más uno para hacerlo correlativo
                var correlativo = meta.row + meta.settings._iDisplayStart + 1;
                return correlativo;	
            }
        },
		{data:'nombre_equipo' ,name:'nombre_equipo'}, //nombre de equipo
		{data:'marca_equipo' ,name:'marca_equipo'}, // marca de equipo
		{data:'modelo_equipo' ,name:'modelo_equipo'}, // modelo de equipo
		{data:'serie_equipo' ,name:'serie_equipo'}, // serie de equipo
		{data:'cp_equipo' ,name:'cp_equipo'}, //nombre de equipo
        {data:'idEquipo_baja' ,name:'idEquipo_baja'}, //nombre de equipo
	],
    "language": {

	    "sProcessing": "Procesando...",
	    "sLengthMenu": "Mostrar _MENU_ registros",
	    "sZeroRecords": "No se encontraron resultados",
	    "sEmptyTable": "Ningún dato disponible en esta tabla",
	    "sInfo": "Mostrando registros del _START_ al _END_",
	    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
	    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix": "",
	    "sSearch": "Buscar:",
	    "sUrl": "",
	    "sInfoThousands": ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	      "sFirst": "Primero",
	      "sLast": "Último",
	      "sNext": "Siguiente",
	      "sPrevious": "Anterior"
	    },
	    "oAria": {
	      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
	      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      }
});
