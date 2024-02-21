/*=============================================
DataTable de Jornadas Laborales
=============================================*/


$("#tablaCronogramasGenerales").DataTable({
	processing: true,
    serverSide: true,
	ajax : ruta + "/obtenercronograma",

	columns :[
		// {data:'id_cronogramaGeneral',name:'id_cronogramaGeneral'},
		{data:'nombre_ambiente',name:'nombre_ambiente'},
		{data:'nombre_equipo',name:'nombre_equipo'},
		{data:'marca_equipo',name:'marca_equipo'},
		{data:'modelo_equipo',name:'modelo_equipo'},
		{data:'serie_equipo',name:'serie_equipo'},
		{data:'cp_equipo',name:'cp_equipo'},
		{data:'mes_cronogramaGeneral',name:'mes_cronogramaGeneral',
		render: function(data, type, full, meta) {
			switch(data) {
				case 1:
					return 'ENERO';
				case 2:
					return 'FEBRERO';
				case 3:
					return 'MARZO';
				case 4:
					return 'ABRIL';
				case 5:
					return 'MAYO';
				case 6:
					return 'JUNIO';
				case 7:
					return 'JULIO';
				case 8:
					return 'AGOSTO';
				case 9:
					return 'SEPTIEMBRE';
				case 10:
					return 'OCTUBRE';
				case 11:
					return 'NOVIEMBRE';
				case 12:
					return 'DICIEMBRE';
				default:
					return data;
			}
		}
		
	},
		{data:'año_cronogramaGeneral',name:'año_cronogramaGeneral'},
		{ 
			data: "id_cronogramaGeneral",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return ' <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+  
				 '<button class="btn btn-danger btn-sm eliminarRegistro" action="/cronogramasGeneral/'+ data +'" method=DELETE pagina="cronogramasGeneral" token=token>'+
					'<i class="fas fa-trash-alt text-white"></i>'+
				 '</button>'
			}
		},
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
$('#tablaCronogramasGenerales').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta + '/cronogramasgeneral/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        $('#id_equipo').val(data.id_equipo);
        $('#nombre_equipo').val(data.equipo.nombre_equipo);
        $('#marca_equipo').val(data.equipo.marca_equipo);
        $('#modelo_equipo').val(data.equipo.modelo_equipo);
        $('#serie_equipo').val(data.equipo.serie_equipo);
		$('#cp_equipo').val(data.equipo.cp_equipo);
		$('#mes_cronogramaGeneral').val(data.mes_cronogramaGeneral);
		$('#año_cronogramaGeneral').val(data.año_cronogramaGeneral);
        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: '/cronogramasGeneral/' + id,
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

