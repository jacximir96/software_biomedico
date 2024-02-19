/*=============================================
DataTable de Jornadas Laborales
=============================================*/
$("#tablaRoles").DataTable({
	processing: true,
    serverSide: true,
	ajax :"/obtenerequiporeposicion",

	
	columns:[
		
	{data: null, // Utilizamos null ya que no hay una propiedad específica asociada
			name: 'correlativo', // Nombre de la columna
			render: function (data, type, row, meta) {
				// Devolvemos el número de fila más uno para hacerlo correlativo
				var correlativo = meta.row + meta.settings._iDisplayStart + 1;
                return correlativo;	
			}
		},
		{data:'nombre_equipo' ,name:'nombre_equipo'}, 
		{data:'marca_equipo' ,name:'marca_equipo'}, 
		{data:'modelo_equipo' ,name:'modelo_equipo'},
		{data:'serie_equipo' ,name:'serie_equipo'},
		{data:'cp_equipo' ,name:'cp_equipo'},
		{data:'criterio_1' ,name:'criterio_1',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}},
		{data:'criterio_2' ,name:'criterio_2',
		render:function (data,type,full,meta) {
			
			if (100*full.acumulado_cronograma/full.monto_adquisicion_equipo >= 40) {
				return 100*full.acumulado_cronograma/full.monto_adquisicion_equipo+'<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; 
			} else {
				return 100*full.acumulado_cronograma/full.monto_adquisicion_equipo+'<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; 
			}	
		}},
		{data:'criterio_3' ,name:'criterio_3',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}},
		{data:'criterio_4' ,name:'criterio_4',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}},
		{data:'criterio_5' ,name:'criterio_5',
		render: function(data, type, full, meta) {
			full.antiguedad_equipo
			if (full.antiguedad_equipo >= full.tiempo_vida_util_equipo) {
				return 'AE:'+full.antiguedad_equipo+'TV:'+full.tiempo_vida_util_equipo+'<div style="text-align: center;"> <i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return 'AE:'+full.antiguedad_equipo+'TV:'+full.tiempo_vida_util_equipo+'<div style="text-align: center;"> <i class="fas fa-times text-red" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}
	},
		{data:'criterio_6' ,name:'criterio_6',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}},
		{data:'criterio_7' ,name:'criterio_7',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
			}
		}},
		{ 
			data: "id_equipo",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return '<div style="text-align: center;">'+ 
				'<button class="btn btn-danger btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i> Dar de Baja</button>'+
				 '<a href="/reportesEquipos/EquiposPdf/'+data+'" class="btn btn-default btn-sm" target="_blank"><i class="fas fa-download text-black"></i> Tarjeta de Control</a>'+
				 '</div>'
				}
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

$('#tablaRoles').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        // $('#id').val(data.id_departamento);
        // $('#estado_departamento').val(data.estado_departamento);
        // $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: '/equiposReposicion/' + id,
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