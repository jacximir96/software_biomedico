/*=============================================
DataTable de Jornadas Laborales
=============================================*/
$("#tablaOrdenServicios").DataTable({
    processing: true,
    serverSide: true,
	ajax :ruta +"/obtenerequiposervicios",

	columns:[	
		{
			data: null, // Utilizamos null ya que no hay una propiedad específica asociada
			name: 'correlativo', // Nombre de la columna
			render: function (data, type, row, meta) {
				// Devolvemos el número de fila más uno para hacerlo correlativo
				var correlativo = meta.row + meta.settings._iDisplayStart + 1;
                return correlativo;	
			}
		},
		{data:'codigo_ordenServicio' ,name:'codigo_ordenServicio'}, 
		{data:'expediente_ordenServicio' ,name:'expediente_ordenServicio'}, 
		{data: function (row) {
			return moment(row.fecha_ordenServicio).format('DD/MM/YYYY'); // Formatear usando moment.js
		}
			 ,name:'fecha_ordenServicio'}, // modelo de equipo
		{data:'monto_ordenServicio' ,name:'monto_ordenServicio',
		render: function (data, type, row) {
            // Aquí formateamos el valor como moneda
            return 'S/.' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
	},
	{ 
		
		data: 'pdf_ordenServicio', // Nombre de la propiedad que contiene el enlace al PDF
            name: 'Acciones', // Nombre de la columna
			render: function(data, type, full, meta) {
				// Verificar si data.pdf_ordenServicio es nulo
				if (full.pdf) {
                    return '<a href="' + data + '" download="Orden de Servicio" class="btn btn-default btn-sm"><i class="fas fa-download text-black"></i> Descargar Archivo</a>';
                } else {
                    return'<button class="btn btn-default btn-sm" disabled><i class="fas fa-download text-black"></i> Descargar Archivo</button>';;
                }
					// Si el enlace comienza con '/storage/', el archivo se encuentra en la carpeta 'storage', por lo que renderizamos el botón de descarga
					
			
					// Si el enlace no comienza con '/storage/', el archivo no se encuentra en la carpeta 'storage', por lo que deshabilitamos el botón y mostramos un mensaje indicando que el PDF no está disponible
			
			}
	},
	{ 
		data: "id_ordenServicio",
		name: 'acciones',
		render: function(data, type, full, meta) {
			return '<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+
			 '<button class="btn btn-danger btn-sm eliminarRegistro" action="'+ruta+'/ordenServicios/'+ data +'" method=DELETE pagina="ordenServicios">'+
				'<i class="fas fa-trash-alt text-white"></i>'+
			 '</button>'
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
$('#tablaOrdenServicios').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta +'/ordenservicio/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        $('#codigo_ordenServicio').val(data.codigo_ordenServicio);
        $('#fecha_ordenServicio').val(data.fecha_ordenServicio);
		$('#expediente_ordenServicio').val(data.expediente_ordenServicio);
		$('#monto_ordenServicio').val(data.monto_ordenServicio);
		//	$('#pdf_archivo_editar_actual').val(data.pdf_ordenServicio);
		 $('#pdf_archivo_editar_actual').val(data.pdf_ordenServicio);

		// $('#pdf_archivo_editar_actual').val(data.pdf_ordenServicio);


		

        // $('#estado_departamento').val(data.estado_departamento);
        // $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();

            var formData = new FormData(this);
			var pdfArchivoEditar = document.getElementById('pdf_ordenServicio_editar').files[0];

            // Agregar el archivo PDF al formData si está presente
            if (pdfArchivoEditar) {
                formData.append('pdf_archivo_editar', pdfArchivoEditar);
            }
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: ruta+'/ordenServicios/' + id,
                type: 'POST',
                data: formData,
				contentType: false,
                processData: false, // No procesar los datos (ya están en FormData)
                success: function(response) {
					alert(response);
                    
                    // Muestra los datos de sesión devueltos en la respuesta JSON
                    console.log('Datos de sesión:', response.sesion);
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