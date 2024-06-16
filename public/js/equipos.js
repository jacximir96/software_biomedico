let tablaEquipos = $("#tablaEquipos").DataTable({
	
	processing: true,
   	serverSide: true,
   	lengthChange: false,
   	ajax :ruta +"/obtener",
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
	   
	   {data:'nombre_tipoEquipamiento' ,name:'nombre_tipoEquipamiento'}, // tipo de equipo
	   {data:function (row) {
		   if (row.id_departamento == '') {
			   return row.iniciales_direccionAmbiente
		   }else{
			   return row.iniciales_direccionDepartamento
		   }	
	   },name:'id_departamento'},
	   {data:'iniciales_departamento' ,name:'iniciales_departamento'},// 
	   {data:'nombre_ambiente' ,name:'nombre_ambiente'},
	   {data: function (row) {
		   return moment(row.fecha_adquisicion_equipo).format('DD/MM/YYYY'); // Formatear usando moment.js
	   }
		   ,name:'fecha_adquisicion_equipo'},
		   {data:'monto_adquisicion_equipo',name:'monto_adquisicion_equipo',
	   render: function (data, type, row) {
		   // Aquí formateamos el valor como moneda
		   return 'S/.' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	   }
	   },
	   {
		data: 'estado',
		name: 'estado',
		render: function (data, type, row) {
			return data === 0 ? 'Servicio' : 'Garantia';
		}
	   },

	   {data:'cp_equipo' ,name:'cp_equipo'}, // codigo patronal de equip  
	   {data:'antiguedad_equipo' ,name:'antiguedad_equipo'},
	   {data:'tiempo_vida_util_equipo' ,name:'tiempo_vida_util_equipo'},
	   {data:'prioridad_equipo',name:'prioridad_equipo'},
	   
	   {
		   data:'imagen_equipo',name: 'imagen_equipo',
		   render: function (data,type,full,meta) {
			   return '<img style=width:200px; height:200px; src="' + data + '" alt="Imagen" onclick="showImageModal(\'' + data + '\')">';
		   }
	   },
	   {
			data: 'id_equipo',
			name: 'id_equipo',
			render: function(data, type, full, meta) {
				return '<a href="'+	ruta+'/reportesEquipos/EquiposPdf/'+ data +'" class="btn btn-default btn-sm">'+
				'<i class="fas fa-download text-black"></i> Descargar Archivo</a>'
			}
		},
	   { 
		   data: "id_equipo",
		   name: 'acciones',
		   render: function(data, type, full, meta) {
			   return' <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+ 
				'<button class="btn btn-danger btn-sm eliminarRegistro" action="'+ruta+'/equipos/'+ data +'" method=DELETE pagina="equipos">'+
				   '<i class="fas fa-trash-alt text-white"></i>'+
				'</button>'
		   }
	   }
	   //  {data:'imagen_equipo',name:'imagen_equipo'}
   ],
   
	buttons: [
	   {
		   //Botón para Excel
		   extend: 'excel',
		   footer: false,
		   title: 'EQUIPOS POR MANTENIMIENTO',
		   filename: 'EQUIPOS_MANTENIMIENTO',
		   //Aquí es donde generas el botón personalizado
		   text: "<button class='btn btn-success btn-sm boton-general' style='float:left;'><i class='fas fa-file-excel'></i> Exportar a Excel</button>",
		   action: function(e, dt, node, config) {
			   var dtButton = this; // Guardamos una referencia al botón para la acción
		   
			   // Guardamos la longitud de página actual y la página actual
			   var currentPageLen = dt.page.len();
			   var currentPage = dt.page.info().page;
		   
			   // Mostramos un modal indicando que se está generando el archivo Excel
			   $("body").css({opacity:.65,'pointer-events':'none'});
			   $('#dataTableSpinner').show();
			   
		   
			   // Ocultamos la tabla durante el proceso de exportación
			   dt.table().container().style.display = "none";
		   
			   // Evento que se ejecutará después de que se redibuje la tabla
			   dt.one('draw', function() {
				   // Llamamos a la acción de exportación de Excel
				   $.fn.DataTable.ext.buttons.excelHtml5.action.call(dtButton, e, dt, node, config);
		   
				   // Restauramos la longitud de página y la página actual después de un breve tiempo
				   setTimeout(function() {
					   // Restauramos la longitud de página
					   dt.page.len(currentPageLen).draw(false);
					   // Restauramos la página actual
					   dt.page(currentPage).draw('page');
					   // Mostramos nuevamente la tabla después de la exportación
					   dt.table().container().style.display = "";
					   // Ocultamos el modal una vez que se haya generado el archivo Excel
					   $('#dataTableSpinner').hide();
					   $("body").css({opacity:'','pointer-events':''});
				   }, 250);
			   });
		   
			   // Cambiamos la longitud de página a -1 para mostrar todos los registros y redibujamos la tabla
			   dt.page.len(-1).draw(false);
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
	 },


	 initComplete: function () {
		direccionEjecutivaFilter(tablaEquipos);
		departamentoFilter(tablaEquipos);
		estadoFilter(tablaEquipos);
		marcaFilter(tablaEquipos);
	}

});





function direccionEjecutivaFilter(tablaEquipos) {

	tablaEquipos.columns(7).every(function() {
		var column = tablaEquipos.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR LA DIRECCION EJECUTIVA --</option></select>')
			.appendTo($('#direccionEjecutivaFilter').empty())
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


function departamentoFilter(tablaEquipos) {
	tablaEquipos.columns(8).every(function() {
		var column = tablaEquipos.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="codigo_departamentoFilter" id="codigo_departamentoFilter"><option value="">-- SELECCIONAR EL DEPARTAMENTO --</option></select>')
			.appendTo($('#departamentoFilter').empty())
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

function estadoFilter(tablaEquipos) {
    tablaEquipos.columns(11).every(function() {
        var column = this;

        var select = $('<select class="form-control select2 select-2" name="codigo_estadoFilter" id="codigo_estadoFilter"><option value="">-- SELECCIONAR EL ESTADO --</option><option value="0">Servicio</option><option value="1">Garantia</option></select>')
            .appendTo($('#estadoFilter').empty())
            .on('change', function() {
                var val = $(this).val();

                // Convert the selection to the corresponding value in the column
                column
                    .search(val ? val : '', true, false)
                    .draw();
            });

        // Initialize select2
        $('.select2').select2();
    });
}


function marcaFilter(tablaEquipos) {
    var select = $('<select class="form-control select2 select-2" name="codigo_marcaFilter" id="codigo_marcaFilter"><option value="">-- SELECCIONAR LA MARCA --</option></select>')
        .appendTo($('#marcaFilter').empty())
        .on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
            );

            tablaEquipos.column(2)
                .search(val ? '^' + val + '$' : '', true, false)
                .draw();
        });

    // Obtener todas las marcas únicas en la tabla
    tablaEquipos.column(2).data().unique().sort().each(function(d, j) {
        select.append('<option value="' + d + '">' + d + '</option>');
    });

    // Establecer la opción seleccionada si ya hay un filtro aplicado
    var currSearch = tablaEquipos.column(2).search();
    if (currSearch) {
        select.val(currSearch.substring(1, currSearch.length - 1));
    }

    // Inicializar select2
    $('.select2').select2();
}









$('#tablaEquipos').on('click', '.editar-btn', function() {
   var id = $(this).data('id');
   

   // Realiza una petición AJAX para obtener los datos del registro
   $.get( ruta + '/equipos/json/' + id, function(data) {
	   var fechaAdquisicionEquipo = new Date(data.fecha_adquisicion_equipo);
		console.log(data);
   // Calcula la diferencia en meses entre la fecha_adquisicion_equipo y la fecha actual
	   var diffMeses = (new Date().getFullYear() - fechaAdquisicionEquipo.getFullYear()) * 12;
	   diffMeses -= fechaAdquisicionEquipo.getMonth();
	   diffMeses += new Date().getMonth();

	   // Divide la diferencia en meses por 12 y redondea el resultado
	   var diffAnios = Math.round(diffMeses / 12);
	   var porcentajeAcumulado = 0;

	   $.each(data.cronogramas, function(index, valor) {
		   porcentajeAcumulado += (valor.monto_cronograma * 100) / data.monto_adquisicion_equipo;
	   });
	   // var porcentajeAcumulado = 0;
	   
	   // 	porcentajeAcumulado += (data.cronogramas.monto_cronograma * 100) / data.monto_adquisicion_equipo;
	   
		//console.log("Porcentaje acumulado:", porcentajeAcumulado);

	   //console.log(diffAnios);
	   // Completa el formulario del modal con los datos recibidos
	   $('#nombre_equipo').val(data.nombre_equipo);
	   $('#marca_equipo').val(data.marca_equipo);
	   $('#estado_departamento').val(data.estado_departamento);
	   $('#modelo_equipo').val(data.modelo_equipo);
	   $('#serie_equipo').val(data.serie_equipo);
	   $('#cp_equipo').val(data.cp_equipo);
	   $('#id_tipoEquipamiento').val(data.id_tipoEquipamiento);
	   $('#id_ambiente').val(data.id_ambiente);
	   $('#fecha_adquisicion_equipo').val(data.fecha_adquisicion_equipo);
	   $('#monto_adquisicion_equipo').val(data.monto_adquisicion_equipo);
	   $('#tiempo_vida_util_equipo').val(data.tiempo_vida_util_equipo);
	   $('#prioridad_equipo').val(data.prioridad_equipo);
	   $('#id_direccionEjecutiva_editar').val(data.id_direccionEjecutiva);
	   $('#id_departamento_editar').val(data.id_departamento);
	   $('#estado_editar').val(data.estado);
	   $('#imagen_actual').val(data.imagen_equipo);
	   // $('#customSwitch1_1').val(data.criterio_1);
	   $('#customSwitch1_1').prop('checked', data.criterio_1 == 1 ? true : false);
	   $('#customSwitch3_1').prop('checked', data.criterio_3 == 1 ? true : false);
	   $('#customSwitch4_1').prop('checked', data.criterio_4 == 1 ? true : false);
	   $('#customSwitch5').prop('checked', diffAnios >= data.tiempo_vida_util_equipo ? true : false);
	   $('#customSwitch6_1').prop('checked', data.criterio_6 == 1 ? true : false);
	   $('#customSwitch7_1').prop('checked', data.criterio_7 == 1 ? true : false);
	   $('#customSwitch2').prop('checked', porcentajeAcumulado > 40);
	   if (!data.imagen_equipo) {
		   // Si no hay URL de imagen, establece una imagen predeterminada
		   $('#imagenEquipo').attr('src', '/img/equiposGarantia/sinImagen.jpg'); // Ruta de la imagen predeterminada
	   } else {
		   // Si hay una URL de imagen, establece la imagen recibida
		   $('#imagenEquipo').attr('src', data.imagen_equipo);
	   }
	   $('#editForm').attr('action', ruta+`/equipos/${id}`);
	  
   });
   
});







