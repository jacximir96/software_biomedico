/*=============================================
DataTable Servidor de departamentos
=============================================*/

/* Petición AJAX */
$.ajax({
    url: 'http://192.168.6.113/software_biomedico/public/departamentos',
    success: function(respuesta){
        console.log("respuesta",respuesta);
    },

    error: function(jqXHR,textStatus,errorThrown){
        console.error(textStatus + " " + errorThrown);
    }
})
/* Fin de Petición AJAX */

/*=============================================
DataTable de departamentos
=============================================*/
var tablaDepartamentos = $("#tablaDepartamentos").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: 'http://192.168.6.113/software_biomedico/public/departamentos'
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
            data: 'id_departamento',
            name: 'id_departamento'
        },
        {
            data: 'nombre_departamento',
            name: 'nombre_departamento',
            render: function (item) {
                return item.toUpperCase();
            }/* El render para poner mayusculas en la vista */
        },
        {
            data: 'iniciales_departamento',
            name: 'iniciales_departamento'
        },
        {
            data: 'nombre_estado',
            name: 'nombre_estado',
            render: function (item) {
                return item.toUpperCase();
            }/* El render para poner mayusculas en la vista */
        },
        {
            data: 'nombre_direccionEjecutiva',
            name: 'nombre_direccionEjecutiva',
            render: function (item) {
                return item.toUpperCase();
            }/* El render para poner mayusculas en la vista */
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

tablaDepartamentos.on('order.dt search.dt', function(){
    tablaDepartamentos.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell,i){cell.innerHTML = i+1})
}).draw();
