$("#tablaCronogramaLista").DataTable({
	
	processing: true,
   serverSide: true,
   lengthChange: false,
   ajax :ruta +"/obtenerCronogramaLista",
   columns:[	
	   {
		   data: null, 
		   name: 'correlativo', 
		   render: function (data, type, row, meta) {
			   var correlativo = meta.row + meta.settings._iDisplayStart + 1;
			   return correlativo;	
		   }
	   },
	   {data:'nombre_equipo' ,name:'nombre_equipo'}, 
	   {data:'cp_equipo' ,name:'cp_equipo'},
       {data:'nombre_mantenimiento' ,name:'nombre_mantenimiento'},
       {data:'fecha' ,name:'fecha'},
       {data:'fecha_final' ,name:'fecha_final'},




       {data:function (row) {
        if (row.codigo_ordenServicio == null && row.realizado == 1) {
            return row.otm_cronograma;
        }else{
            return row.codigo_ordenServicio;
        }	
    },name:'otm_cronograma'},
    

       {data:'ruc_proveedor' ,name:'ruc_proveedor'},

	   {data:function (row) {
        if (row.iniciales_departamento == null && row.realizado == 1) {
            return row.iniciales_direccionEjecutiva;
        }else{
            return row.iniciales_departamento;
        }	
    },name:'iniciales_departamento'},



	{
		data: function(row) {
			return row.garantia + ' MESES';
		},
		name: 'garantia'
	},
	
       {data:'observacion' ,name:'observacion'},
       {
		data: 'monto_cronograma',
		name: 'monto_cronograma',
		render: function(data, type, row) {

			if (data === null || typeof data === 'undefined') {
				return 'S/. 0.00';
			}

			if (type === 'display' || type === 'filter') {
				return 'S/. ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
			}
			return data;
		}
	},

	{
		data: null,
		name: 'acciones', 
		render: function(data, type, row) {
			return `
				<td style="text-align: center; text-transform: uppercase;">
					<a href="../storage/app/${row.pdf_cronograma}" download="Conformidad del Servicio" class="btn btn-default btn-sm">
						<i class="fas fa-download text-black"></i> Descargar Archivo
					</a>
				</td>
			`;
		}
	},
	{
		data: null,
		name: 'estado', 
		render: function(data, type, row) {
			if (row.realizado === 0) {
				return '<td style="text-align: center; text-transform: uppercase;"><span style="color:red;">NO REALIZADO</span></td>';
			} else if (row.realizado === 1) {
				return '<td style="text-align: center; text-transform: uppercase;"><span style="color:green;">REALIZADO</span></td>';
			} else {
				return '<td style="text-align: center; text-transform: uppercase;">--</td>'; // o algún valor predeterminado
			}
		}
	},
	{ 
		data: 'id_cronograma',
		name: 'acciones',
		render: function(data, type, full, meta) {
			return' <button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModalCronograma" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+ 
			 '<button class="btn btn-danger btn-sm eliminarRegistro" action="'+ruta+'/cronogramaLista/'+ data +'" method=DELETE pagina="cronogramasLista">'+
				'<i class="fas fa-trash-alt text-white"></i>'+
			 '</button>'
		}
	}
	
   ],
   
	// buttons: [
	//    {
	// 	   //Botón para Excel
	// 	   extend: 'excel',
	// 	   footer: false,
	// 	   title: 'EQUIPOS POR MANTENIMIENTO',
	// 	   filename: 'EQUIPOS_MANTENIMIENTO',
	// 	   //Aquí es donde generas el botón personalizado
	// 	   text: "<button class='btn btn-success btn-sm boton-general' style='float:left;'><i class='fas fa-file-excel'></i> Exportar a Excel</button>",
	// 	   action: function(e, dt, node, config) {
	// 		   var dtButton = this; // Guardamos una referencia al botón para la acción
		   
	// 		   // Guardamos la longitud de página actual y la página actual
	// 		   var currentPageLen = dt.page.len();
	// 		   var currentPage = dt.page.info().page;
		   
	// 		   // Mostramos un modal indicando que se está generando el archivo Excel
	// 		   $("body").css({opacity:.65,'pointer-events':'none'});
	// 		   $('#dataTableSpinner').show();
			   
		   
	// 		   // Ocultamos la tabla durante el proceso de exportación
	// 		   dt.table().container().style.display = "none";
		   
	// 		   // Evento que se ejecutará después de que se redibuje la tabla
	// 		   dt.one('draw', function() {
	// 			   // Llamamos a la acción de exportación de Excel
	// 			   $.fn.DataTable.ext.buttons.excelHtml5.action.call(dtButton, e, dt, node, config);
		   
	// 			   // Restauramos la longitud de página y la página actual después de un breve tiempo
	// 			   setTimeout(function() {
	// 				   // Restauramos la longitud de página
	// 				   dt.page.len(currentPageLen).draw(false);
	// 				   // Restauramos la página actual
	// 				   dt.page(currentPage).draw('page');
	// 				   // Mostramos nuevamente la tabla después de la exportación
	// 				   dt.table().container().style.display = "";
	// 				   // Ocultamos el modal una vez que se haya generado el archivo Excel
	// 				   $('#dataTableSpinner').hide();
	// 				   $("body").css({opacity:'','pointer-events':''});
	// 			   }, 250);
	// 		   });
		   
	// 		   // Cambiamos la longitud de página a -1 para mostrar todos los registros y redibujamos la tabla
	// 		   dt.page.len(-1).draw(false);
	// 	   }
	//    },
	   
	// ],

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


$('#tablaCronogramaLista').on('click', '.editar-btn', function() {
   var id = $(this).data('id');
   console.log(id);

   $.get( ruta + '/cronogramaLista/json/' + id, function(data) {
	console.log(data);
	   var fechaAdquisicionEquipo = new Date(data.fecha_adquisicion_equipo);

	   var diffMeses = (new Date().getFullYear() - fechaAdquisicionEquipo.getFullYear()) * 12;
	   diffMeses -= fechaAdquisicionEquipo.getMonth();
	   diffMeses += new Date().getMonth();

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
	   $('#fecha_actual_editar').val(data.fecha);	
	   $('#fecha_final_editar').val(data.fecha_final);
	   $('#estado_departamento').val(data.estado_departamento);
	   $('#nombres_equipo_editar').val(data.id_equipo);
	   $('#nombres_mantenimiento_editar').val(data.id_mantenimiento);
	   $('#cp_equipo').val(data.cp_equipo);
	   $('#id_tipoEquipamiento').val(data.id_tipoEquipamiento);
	   $('#id_ambiente').val(data.id_ambiente);
	   $('#fecha_adquisicion_equipo').val(data.fecha_adquisicion_equipo);
	   $('#monto_adquisicion_equipo').val(data.monto_adquisicion_equipo);
	   $('#tiempo_vida_util_equipo').val(data.tiempo_vida_util_equipo);
	   $('#prioridad_equipo').val(data.prioridad_equipo);
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
	   $('#editFormCronogramaList').attr('action', ruta+`/cronogramaLista/${id}`);
	  
   });
   
});







