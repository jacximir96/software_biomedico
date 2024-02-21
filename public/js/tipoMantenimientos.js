/*=============================================
DataTable Servidor de departamentos
=============================================*/

/* Petición AJAX */
$.ajax({
    url: ruta +'/tipoMantenimientos',
    success: function(respuesta){
        console.log("respuesta",respuesta);
    },

    error: function(jqXHR,textStatus,errorThrown){
        console.error(textStatus + " " + errorThrown);
    }
})
/* Fin de Petición AJAX */

/*=============================================
DataTable de administradores
=============================================*/
var tablaTipoMantenimientos = $("#tablaTipoMantenimientos").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: ruta +'/tipoMantenimientos'
    },

    "columnDefs":[{
        "searchable": true,
        "orderable" : true,
        "targets" : 0
    }],

    "order": [[0, "desc"]],

    /* Creamos columnas para visualizar */
    columns: [
        {
            data: 'id_mantenimiento',
            name: 'id_mantenimiento'
        },
        {
            data: 'nombre_mantenimiento',
            name: 'nombre_mantenimiento',
            render: function (item) {
                return item.toUpperCase();
            }/* El render para poner mayusculas en la vista */
        },
        {
            data: 'nombre_estado',
            name: 'nombre_estado'
        },
        {
            data: 'acciones',
            name: 'acciones'
        }
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

tablaTipoMantenimientos.on('order.dt search.dt', function(){
    tablaTipoMantenimientos.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell,i){cell.innerHTML = i+1})
}).draw();
