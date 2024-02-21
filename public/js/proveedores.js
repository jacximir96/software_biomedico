/*=============================================
DataTable de Jornadas Laborales
=============================================*/
$("#tablaProveedores").DataTable({

	processing: true,
    serverSide: true,
	lengthChange: false,
	ajax :ruta +"/obtenerproveedor",

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
		{data:'ruc_proveedor',name:'ruc_proveedor'},
		{data:'razonSocial_proveedor' ,name:'razonSocial_proveedor'}, //nombre de equipo
		{data:'estado_proveedor' ,name:'estado_proveedor'}, // marca de equipo
		{data:'direccion_proveedor' ,name:'direccion_proveedor'}, // modelo de equipo
		{data:'distrito_proveedor' ,name:'distrito_proveedor'}, // serie de equipo
		{data:'provincia_proveedor' ,name:'provincia_proveedor'}, // codigo patronal de equip
		{data:'departamento_proveedor' ,name:'departamento_proveedor'}, // tipo de equipo
		{ 
			data: "id_proveedor",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return'<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+ 
				 '<button class="btn btn-danger btn-sm eliminarRegistro" action="/equipos/'+ data +'" method=DELETE pagina="equipos">'+
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
	  },
});


$('#tablaProveedores').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta +'/proveedores/json/' + id, function(data) {
        // Completa el formulario del modal con los datos recibidos
        //$('#id').val(data.id_departamento);
        $('#txtdni').val(data.ruc_proveedor);
		$('#txtrazon').val(data.razonSocial_proveedor);
		$('#txtgrupo').val(data.estado_proveedor);
		$('#txtdireccion').val(data.direccion_proveedor);
		$('#txtdistrito').val(data.distrito_proveedor);
		$('#txtprovincia').val(data.provincia_proveedor);
		$('#txtdepartamento').val(data.departamento_proveedor);
		

		

        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: ruta +'/proveedores/' + id,
                type: 'POST',
                data: formData,
                success: function(response) {
                    //console.log(response);
                    // Cierra el modal de edición
                    //$('#editModal').modal('hide');
                    // Recarga los datos en la tabla
                    // location.reload();
                    // return false;
                },
                error: function(xhr, status, error) {
					console.error(textStatus + " " + errorThrown);
                }
            });
            location.reload();
        });
		
    });
    
});
