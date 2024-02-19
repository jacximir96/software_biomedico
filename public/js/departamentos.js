/*=============================================
DataTable Servidor de departamentos
=============================================*/

/* Petición AJAX */
$.ajax({
    url: 'http://127.0.0.1:8000/departamentos',
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
        url: 'http://127.0.0.1:8000/departamentos'
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

$('#tablaDepartamentos').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get('/departamentos/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        $('#id').val(data.id_departamento);
        $('#nombre_departamento').val(data.nombre_departamento);
        $('#iniciales_departamento').val(data.iniciales_departamento);
        $('#estado_departamento').val(data.estado_departamento);
        $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: '/departamentos/' + id,
                type: 'POST',
                data: formData,
                success: function(response) {
                    //console.log(response.data);
                    // Cierra el modal de edición
                    //$('#editModal').modal('hide');
                    // Recarga los datos en la tabla
                    // location.reload();
                    // return false;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
            location.reload();
        });
    });
    
});
