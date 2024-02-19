

/*=============================================
DataTable de Jornadas Laborales
=============================================*/
$("#tablaHistorialCompras").DataTable({

	processing: true,
    serverSide: true,
	ajax :"/obtenerhistorialcompras",
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
	
		{data:'nombre_equipoGarantia' ,name:'nombre_equipoGarantia'}, //nombre de equipo
		{data:'marca_equipoGarantia' ,name:'marca_equipoGarantia'}, // marca de equipo
		{data:'modelo_equipoGarantia' ,name:'modelo_equipoGarantia'}, // modelo de equipo
		{data:'serie_equipoGarantia' ,name:'serie_equipoGarantia'}, // serie de equipo
		{data:'cp_equipoGarantia' ,name:'cp_equipoGarantia'}, // codigo patronal de equip
		{ 
			data: "id_equipoGarantia",
			name: 'Acciones',
			render: function(data, type, full, meta) {
				return  '<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'">Historial</button>'
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

$('#tablaHistorialCompras').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get('/historialgarantia/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
		$('#id_equipoHistorial').val(data.id_equipoGarantia);
		var tabla = $('#miTabla tbody').empty();
		
		// console.log(data.cronogramas.fecha);
        // Itera sobre los datos recibidos y agrega filas a la tabla
       
            var fila = '<tr>' +
                '<th>' + 'Equipo:' + '</th>' +
                '<td>' + data.nombre_equipoGarantia + '</td>' +
                '</tr>'+
				'<tr>' +
                '<th>' + 'Marca:' + '</th>' +
                '<td>' + data.marca_equipoGarantia + '</td>' +
                '</tr>'+
				'<tr>' +
                '<th>' + 'Modelo:' + '</th>' +
                '<td>' + data.modelo_equipoGarantia + '</td>' +
                '</tr>'+
				'<tr>' +
                '<th>' + 'Serie:' + '</th>' +
                '<td>' + data.serie_equipoGarantia + '</td>' +
                '</tr>'+
				'<tr>' +
                '<th>' + 'Cod.Patr:' + '</th>' +
                '<td>' + data.cp_equipoGarantia + '</td>' +
                '</tr>';
            
           tabla.append(fila);
			console.log(Date());
		   var table = $('#historialCompra tbody').empty();
			let team;
        // Itera sobre los datos recibidos y agrega filas a la tabla
		for (let i = 0; i < data.cronogramas.length; i++) {
			console.log(data.cronogramas[i].pdf_cronograma);
			 team += '<tr>' +
                
			 '<td style="' + (data.cronogramas[i].fecha< Date() && data.cronogramas[i].realizado == 0 ? 'color:red;' : '') + '">' + data.cronogramas[i].fecha + '<br>' + data.cronogramas[i].fecha_final + '</td>' +
			 '<td style="' + (data.cronogramas[i].realizado == 1 ? '' : 'color:red;') + '">' + (data.cronogramas[i].realizado == 1 ? 'REALIZADO' : 'NO REALIZADO') + '</td>'+
			 '<td>' + (data.cronogramas[i].pdf_cronograma ? '<a href="' + data.cronogramas[i].pdf_cronograma + '" download="Archivo de finalización" class="btn btn-default btn-sm"><i class="fas fa-download text-black"></i></a>' : '') + '</td>'

   
			 '</tr>';
				
			
		}
            
            
           table.append(team);
       
        // Continúa con los demás campos
    });
    
});



