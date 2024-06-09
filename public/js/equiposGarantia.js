/*=============================================
DataTable de Jornadas Laborales
=============================================*/
let tablaEquiposGarantia = $("#tablaEquiposGarantia").DataTable({
	processing: true,
    serverSide: true,
	ajax :ruta+"/obtenerequipogarantia",

	columns: [
		{data:'nombre_equipoGarantia' ,name:'nombre_equipoGarantia'}, //nombre de equipo
		{data:'marca_equipoGarantia' ,name:'marca_equipoGarantia'}, // marca de equipo
		{data:'modelo_equipoGarantia' ,name:'modelo_equipoGarantia'}, // modelo de equipo
		{data:'serie_equipoGarantia' ,name:'serie_equipoGarantia'}, // serie de equipo
		{data:'cp_equipoGarantia' ,name:'cp_equipoGarantia'}, //nombre de equipo
		{data:function (row) {
			if (row.id_departamento == '') {
				return row.iniciales_direccionAmbiente
			}else{
				return row.iniciales_direccionDepartamento
			}	
		},
		name: 'id_departamento'
	}, // marca de equipo
		{data:'iniciales_departamento' ,name:'iniciales_departamento'}, // modelo de equipo
		{data:'nombre_ambiente' ,name:'nombre_ambiente'}, // serie de equipo
		{data: function (row) {
			return moment(row.fecha_adquisicion_equipoGarantia).format('DD/MM/YYYY'); // Formatear usando moment.js
		}
			,name:'fecha_adquisicion_equipoGarantia'},
		{data:'monto_adquisicion_equipoGarantia',name:'monto_adquisicion_equipoGarantia',
		render: function (data, type, row) {
            // Aquí formateamos el valor como moneda
            return 'S/.' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
		},
		{data:'antiguedad_equipoGarantia',name:'antiguedad_equipoGarantia'},
		{data:'tiempo_vida_util_equipoGarantia',name:'tiempo_vida_util_equipoGarantia'},
		{
			data:'imagen_equipoGarantia',name: 'imagen_equipoGarantia',
			render: function (data,type,full,meta) {
				return '<img style="width:200px; height:200px;" src="' + data + '" alt="Imagen" onclick="showImageModal(\'' + data + '\')">';
			}
		},
		{
			data: "id_equipoGarantia",
			name: 'id_equipoGarantia',
			render: function(data, type, full, meta) {
				return '<a href="'+	ruta+'/reportesEquiposGarantia/EquiposGarantiaPdf/'+ data +'" class="btn btn-default btn-sm">'+
				'<i class="fas fa-download text-black"></i> Descargar Archivo</a>'
			}
		},
		{ 
			data: "id_equipoGarantia",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return'<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+
				 '<button class="btn btn-danger btn-sm eliminarRegistro" action="'+ruta+'/equiposGarantia/'+ data +'" method=DELETE pagina="equiposGarantia">'+
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

	  initComplete: function () {
		direccionEjecutivaFilterGarantia(tablaEquiposGarantia);
		departamentoFilterGarantia(tablaEquiposGarantia);
		ambienteFilterGarantia(tablaEquiposGarantia);
		marcaFilterGarantia(tablaEquiposGarantia);
	}
});
$('#tablaEquiposGarantia').on('click', '.editar-btn', function() {
    var id = $(this).data('id');
	


    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta +'/equipogarantia/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        $('#id').val(data.id_departamento);
        $('#nombre_equipo').val(data.nombre_equipoGarantia);
		$('#marca_equipo').val(data.marca_equipoGarantia);
        $('#modelo_equipo').val(data.modelo_equipoGarantia);
        $('#serie_equipo').val(data.serie_equipoGarantia);
        $('#cp_equipo').val(data.cp_equipoGarantia);
		$('#id_ambiente').val(data.id_ambiente);
		$('#fecha_adquisicion_equipo').val(data.fecha_adquisicion_equipoGarantia);
        $('#monto_adquisicion_equipo').val(data.monto_adquisicion_equipoGarantia);
		$('#tiempo_vida_util_equipo').val(data.tiempo_vida_util_equipoGarantia);
		$('#tiempo_vida_util_equipo').val(data.tiempo_vida_util_equipoGarantia);
		$('#imagen_actual').val(data.imagen_equipoGarantia);
		if (!data.imagen_equipoGarantia) {
			// Si no hay URL de imagen, establece una imagen predeterminada
			$('#imagenEquipo').attr('src', '/img/equiposGarantia/sinImagen.jpg'); // Ruta de la imagen predeterminada
		} else {
			// Si hay una URL de imagen, establece la imagen recibida
			$('#imagenEquipo').attr('src', data.imagen_equipoGarantia);
		}
		$('#editForm').attr('action', ruta+`/equiposGarantia/${id}`);
		
    });
    
});

function direccionEjecutivaFilterGarantia(tablaEquiposGarantia) {

	tablaEquiposGarantia.columns(5).every(function() {
		var column = tablaEquiposGarantia.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR LA DIRECCION EJECUTIVA --</option></select>')
			.appendTo($('#direccionEjecutivaFilterGarantia').empty())
			.on('change', function() {
				var val = $.fn.dataTable.util.escapeRegex(
					$(this).val()
				);

				column
					.search(val ? '^' + val + '$' : '', true, false)
					.draw();
			});

			column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );

		var currSearch = column.search();

		if (currSearch) {
			select.val(currSearch.substring(1, currSearch.length - 1));
		}

		$('.select2').select2();
	});
}


function departamentoFilterGarantia(tablaEquiposGarantia) {
	tablaEquiposGarantia.columns(6).every(function() {
		var column = tablaEquiposGarantia.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR EL DEPARTAMENTO --</option></select>')
			.appendTo($('#departamentoFilterGarantia').empty())
			.on('change', function() {
				var val = $.fn.dataTable.util.escapeRegex(
					$(this).val()
				);

				column
					.search(val ? '^' + val + '$' : '', true, false)
					.draw();
			});

			column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );

		var currSearch = column.search();

		if (currSearch) {
			select.val(currSearch.substring(1, currSearch.length - 1));
		}

		$('.select2').select2();
	});
}

// function estadoFilter(tablaEquipos) {
//     tablaEquipos.columns(11).every(function() {
//         var column = this;

//         var select = $('<select class="form-control select2 select-2" name="codigo_estadoFilter" id="codigo_estadoFilter"><option value="">-- SELECCIONAR EL ESTADO --</option><option value="0">Servicio</option><option value="1">Garantia</option></select>')
//             .appendTo($('#estadoFilter').empty())
//             .on('change', function() {
//                 var val = $(this).val();

//                 // Convert the selection to the corresponding value in the column
//                 column
//                     .search(val ? val : '', true, false)
//                     .draw();
//             });

//         // Initialize select2
//         $('.select2').select2();
//     });
// }


function marcaFilterGarantia(tablaEquiposGarantia) {
    var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR LA MARCA --</option></select>')
        .appendTo($('#marcaFilterGarantia').empty())
        .on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
            );

            tablaEquiposGarantia.column(2)
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
        });

    // Obtener todas las marcas únicas en la tabla
    tablaEquiposGarantia.column(2).data().unique().sort().each(function(d, j) {
        select.append('<option value="' + d + '">' + d + '</option>');
    });

    // Establecer la opción seleccionada si ya hay un filtro aplicado
    var currSearch = tablaEquiposGarantia.column(2).search();
    if (currSearch) {
        select.val(currSearch.substring(1, currSearch.length - 1));
    }

    // Inicializar select2
    $('.select2').select2();
}


function ambienteFilterGarantia(tablaEquiposGarantia) {
	tablaEquiposGarantia.columns(7).every(function() {
		var column = tablaEquiposGarantia.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR EL AMBIENTE --</option></select>')
			.appendTo($('#ambienteFilterGarantia').empty())
			.on('change', function() {
				var val = $.fn.dataTable.util.escapeRegex(
					$(this).val()
				);

				column
					.search(val ? '^' + val + '$' : '', true, false)
					.draw();
			});

			column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );

		var currSearch = column.search();

		if (currSearch) {
			select.val(currSearch.substring(1, currSearch.length - 1));
		}

		$('.select2').select2();
	});
}




