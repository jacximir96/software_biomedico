/*=============================================
DataTable de Jornadas Laborales
=============================================*/
$("#tablaHistorialEquipos").DataTable({

	processing: true,
    serverSide: true,
	ajax :ruta +"/obtenerhistorialequipos",
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
	
		{data:'nombre_equipo' ,name:'nombre_equipo'}, //nombre de equipo
		{data:'marca_equipo' ,name:'marca_equipo'}, // marca de equipo
		{data:'modelo_equipo' ,name:'modelo_equipo'}, // modelo de equipo
		{data:'serie_equipo' ,name:'serie_equipo'}, // serie de equipo
		{data:'cp_equipo' ,name:'cp_equipo'}, // codigo patronal de equip
		{ 
			data: "id_equipo",
			name: 'Acciones',
			render: function(data, type, full, meta) {
				return '<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'">Historial</button>';
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

$('#tablaHistorialEquipos').on('click', '.editar-btn', function() {
    let id = $(this).data('id');
	console.log(id);
   
	if ($.fn.DataTable.isDataTable('#historialCompra1')) {
        $('#historialCompra1').DataTable().destroy();
    }


	$.get(ruta +'/equipoDatos/json/' + id, function(data) {

		
		$('#id_equipoHistorial').val(data[0].id_equipo);
		
		        console.log("Datos recibidos:",data);
				
				var tabla = $('#historialCompra2 tbody').empty();
				

		            var fila = '<tr>' +
		                '<th>' + 'Equipo:' + '</th>' +
		                '<td>' + data[0].nombre_equipo + '</td>' +
		                '</tr>'+
						'<tr>' +
		                '<th>' + 'Marca:' + '</th>' +
		                '<td>' + data[0].marca_equipo  + '</td>' +
		                '</tr>'+
						'<tr>' +
		                '<th>' + 'Modelo:' + '</th>' +
		                '<td>' + data[0].modelo_equipo  + '</td>' +
		                '</tr>'+
						'<tr>' +
		                '<th>' + 'Serie:' + '</th>' +
		                '<td>' + data[0].serie_equipo  + '</td>' +
		                '</tr>'+
						'<tr>' +
		                '<th>' + 'Cod.Patr:' + '</th>' +
		                '<td>' + data[0].cp_equipo  + '</td>' +
		                '</tr>';
					
		           tabla.append(fila);

	});


	if ($.fn.DataTable.isDataTable('#historialCompra1')) {
        $('#historialCompra1').DataTable().destroy();
    }


	$('#historialCompra1').DataTable({
		processing: true,
		serverSide: true,
		ajax :ruta +"/mantenimientoServicioHistorial/json/" + id,
		pageLength: 5,
		columns:[
			{
				data: null, 
				name: 'correlativo', 
				render: function (data, type, row, meta) {
					var correlativo = meta.row + meta.settings._iDisplayStart + 1;
					return correlativo;	
				}
			},
		
			{data:'nombre_mantenimiento' ,name:'nombre_mantenimiento'}, 
			{
				data: null,
				name: 'fecha',
				render: function (data, type, row) {
					return 'Inicio: ' + row.fecha + ' <br>Fin: ' + row.fecha_final;
				}
			},
			{data:'codigo_ordenServicio' ,name:'codigo_ordenServicio'},
			{
				data: 'realizado',
				name: 'realizado',
				render: function (data, type, row) {
					if (data == 1) {
						return '<span style="color:green;">Realizado</span>';
					} else {
						return '<span style="color:red;">No Realizado</span>';
					}
				}
			},
			{
				data: null,
				name: 'pdf_cronograma',
				render: function (data, type, row) {
					if (row.pdf_cronograma) {
						return `
							<td style="text-align: center; text-transform: uppercase;">
								<a href="../storage/${row.pdf_cronograma}" download="Archivo de finalización" class="btn btn-default btn-sm">
									<i class="fas fa-download text-black"></i>
								</a>
							</td>
						`;
					} else {
						return '<td style="text-align: center; text-transform: uppercase;"><span style="color:red;">SIN ARCHIVO</span></td>'
					}
				}
			},
		],
	});
});



