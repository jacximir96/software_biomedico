var tablaCronogramaLista = $("#tablaCronogramaLista").DataTable({
	processing: false,
   	serverSide: true,
	responsive: true,
	autoWidth: false,
   	ajax : {
		url: ruta + '/obtenerCronogramaLista',
	},
	"columnDefs":[{
        "searchable": true,
        "orderable" : true,
        "targets" : 0
    }],
	"order": [[0, "desc"]],
   	columns:[	
		{
			data: 'id_cronograma',
			name: 'id_cronograma',
			render: function (data, type, row, meta) {
				return meta.row + 1;
			}
		},
		{
			data:'nombre_equipo' ,
			name:'nombre_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		}, 
		{data:'cp_equipo' ,name:'cp_equipo'},
		{
			data:'nombre_mantenimiento' ,
			name:'nombre_mantenimiento',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{data:'fecha' ,name:'fecha'},
		{data:'fecha_final' ,name:'fecha_final'},
		{
			data:function (row) {
				if (row.codigo_ordenServicio == null && row.realizado == 1) {
					return row.otm_cronograma;
				}else{
					return row.codigo_ordenServicio;
				}	
			},name:'otm_cronograma'
		},
		{data:'ruc_proveedor' ,name:'ruc_proveedor'},
		{
			data:function (row) {
				if (row.iniciales_departamento == null && row.realizado == 1) {
					return row.iniciales_direccionEjecutiva;
				} else {
					return row.iniciales_departamento;
				}	
			},name:'iniciales_departamento'
		},
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
				if (row.pdf_cronograma) {
					return `
						<td style="text-align: center; text-transform: uppercase;">
							<a href="../public/storage/${row.pdf_cronograma}" download="Conformidad del Servicio" class="btn btn-default btn-sm">
								<i class="fas fa-download text-black"></i> Descargar Archivo
							</a>
						</td>
					`;
				} else {
					return '<td style="text-align: center; text-transform: uppercase;"><span style="color:red;">SIN ARCHIVO</span></td>'
				}
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
			data: "id_cronograma",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return `
					<div class="btn-group text-center">
						<button data-modal-target="editarModalCronograma" class="open-modal-btn hover:text-primary editar-btn" data-id="${data}" aria-label="Editar">
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"/>
								<path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67812 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67812 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906Z"/>
							</svg>
						</button>
						<button class="hover:text-danger eliminarRegistro" action="${ruta}/cronogramaLista/${data}" method="DELETE" pagina="cronogramasLista" aria-label="Eliminar">
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"/>
								<path d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"/>
								<path d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"/>
								<path d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"/>
							</svg>
						</button>
					</div>
				`;
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
	dom: 'rt',
	"drawCallback": function (settings) {
		var pageInfo = tablaCronogramaLista.page.info();
		updatePagination(pageInfo);
		updateInfo(pageInfo);
	},
});

var buttons = new $.fn.DataTable.Buttons(tablaCronogramaLista, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Cronograma de mantenimientos',
            "filename": 'CRONOGRAMA_MANTENIMIENTOS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">Excel</button>',
            "className": 'btn btn-sm btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            action: function ( e, dt, node, config ) {
                var myButton = this;
                var oldPageLength = dt.page.len();
                var oldPage = dt.page();

                dt.one( 'draw', function () {
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(myButton, e, dt, node, config);
                    dt.page.len(oldPageLength).draw(false);
                    dt.page(oldPage).draw(false);
                });

                dt.page.len(-1).draw();
            }
        },
        {
            "extend": 'pdf',
            "footer": false,
            "title": 'Cronograma de mantenimientos',
            "filename": 'CRONOGRAMA_MANTENIMIENTOS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['5%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '5%', '5%', '5%'];
                doc.styles.tableHeader.alignment = 'center';
                doc.defaultStyle.alignment = 'center';
                doc.styles.tableBodyEven.alignment = 'center';
                doc.styles.tableBodyOdd.alignment = 'center';
            },
            action: function ( e, dt, node, config ) {
                var myButton = this;
                var oldPageLength = dt.page.len();
                dt.one( 'draw', function () {
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(myButton, e, dt, node, config);
                });
                dt.page.len(-1).draw();
                dt.one('draw', function () {
                    dt.page.len(oldPageLength).draw();
                });
            }
        }
    ]
}).container();

$('#asignar-botones').append(buttons);

tablaCronogramaLista.on('order.dt search.dt draw.dt', function () {
    tablaCronogramaLista.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaCronogramaLista.page.info().start + i + 1;  })
}).draw();


function updatePagination(pageInfo) {
    var currentPage = pageInfo.page + 1;
    var totalPages = pageInfo.pages;

    var paginationList = $(".datatable-pagination-list");
    paginationList.empty();

    if (currentPage > 1) {
        paginationList.append('<li class="datatable-pagination-list-item"><a data-page="' + (currentPage - 1) + '" class="datatable-pagination-list-item-link">‹</a></li>');
    } else {
        paginationList.append('<li class="datatable-pagination-list-item datatable-disabled"><a class="datatable-pagination-list-item-link">‹</a></li>');
    }

    for (var i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            paginationList.append('<li class="datatable-pagination-list-item datatable-active"><a data-page="' + i + '" class="datatable-pagination-list-item-link">' + i + '</a></li>');
        } else {
            paginationList.append('<li class="datatable-pagination-list-item"><a data-page="' + i + '" class="datatable-pagination-list-item-link">' + i + '</a></li>');
        }
    }

    if (currentPage < totalPages) {
        paginationList.append('<li class="datatable-pagination-list-item"><a data-page="' + (currentPage + 1) + '" class="datatable-pagination-list-item-link">›</a></li>');
    } else {
        paginationList.append('<li class="datatable-pagination-list-item datatable-disabled"><a class="datatable-pagination-list-item-link">›</a></li>');
    }
}

function updateInfo(pageInfo) {
    var startRecord = pageInfo.start + 1;
    var endRecord = pageInfo.end;
    var totalRecords = pageInfo.recordsTotal;

    $('#datatable-info').text('Mostrando ' + startRecord + ' a ' + endRecord + ' de ' + totalRecords + ' registros');
}

$(document).on('click', '.datatable-pagination-list-item-link', function (e) {
    e.preventDefault();
    var page = $(this).data('page') - 1;
    tablaCronogramaLista.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaCronogramaLista.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaCronogramaLista.page.len(valor).draw();
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
	   
	   if(data.realizado === 0){
		$('#class_detalle').hide();
		$('#class_otm').hide();
		$('#class_archivo').hide();
		$('#divLista').hide();
	   } else if (data.realizado === 1){
		$('#class_detalle').show();
		$('#class_otm').show();
		$('#class_archivo').show();
		$('#divLista').show();	
	   }

	   if(data.id_mantenimiento === 1 || data.id_mantenimiento === 2){
		$('#valor_garantia').show();
		$('#monto_cronograma_div').show();
		$('#id_ordenServicio_editar').show();
		$('#otm_cronograma_editar').hide();
		$('#ods_editar').show();
		$('#otm_editar').hide();
		$('#monto_cronograma_div_editar').show();
	   }else{
		$('#valor_garantia').hide();
		$('#monto_cronograma_div').hide();
		$('#ods_editar').hide();
		$('#otm_editar').show();
		$('#id_ordenServicio_editar').hide();
		$('#otm_cronograma_editar').show();
		$('#monto_cronograma_div_editar').hide();
	   }

	   $('#mantenimiento_oculto2').val(data.id_mantenimiento);
	   $('#fecha_actual_editar').val(data.fecha);	
	   $('#fecha_final_editar').val(data.fecha_final);
	   $('#estado_departamento').val(data.estado_departamento);
	   $('#nombres_equipo_editar').val(data.id_equipo);
	   $('#nombres_mantenimiento_editar').val(data.id_mantenimiento);
	   $('#id_ordenServicio_editar').val(data.id_ordenServicio);
	   $('#cp_equipo').val(data.cp_equipo);
	   $('#cronograma_observacion_editar').val(JSON.parse(data.observacion));
	   $('#otm_cronograma_editar').val(data.otm_cronograma);
	   $('#id_tipoEquipamiento').val(data.id_tipoEquipamiento);
	   $('#id_ambiente').val(data.id_ambiente);
	   $('#garantia_edit').val(data.garantia);

	   if(data.monto_cronograma != null) {
	   	$('#monto_cronograma_editar').val(data.monto_cronograma);
	   } else {
		$('#monto_cronograma_editar').val(0);
	   }

	   $('#fecha_adquisicion_equipo').val(data.fecha_adquisicion_equipo);
	   $('#monto_adquisicion_equipo').val(data.monto_adquisicion_equipo);
	   $('#tiempo_vida_util_equipo').val(data.tiempo_vida_util_equipo);
	   $('#prioridad_equipo').val(data.prioridad_equipo);
	   $('#imagen_actual').val(data.imagen_equipo);
	   $('#customSwitch1_1').prop('checked', data.criterio_1 == 1 ? true : false);
	   $('#customSwitch3_1').prop('checked', data.criterio_3 == 1 ? true : false);
	   $('#customSwitch4_1').prop('checked', data.criterio_4 == 1 ? true : false);
	   $('#customSwitch5').prop('checked', diffAnios >= data.tiempo_vida_util_equipo ? true : false);
	   $('#customSwitch6_1').prop('checked', data.criterio_6 == 1 ? true : false);
	   $('#customSwitch7_1').prop('checked', data.criterio_7 == 1 ? true : false);
	   $('#customSwitch2').prop('checked', porcentajeAcumulado > 40);
	   $('#descargaLista').attr('href', '../public/storage/' + `${data.pdf_cronograma}`);
	   if (!data.imagen_equipo) {
		   $('#imagenEquipo').attr('src', '/img/equiposGarantia/sinImagen.jpg');
	   } else {
		   $('#imagenEquipo').attr('src', data.imagen_equipo);
	   }
	   $('#editFormCronogramaList').attr('action', ruta+`/cronogramaLista/${id}`);

/* 	   if($('#mantenimiento_oculto2').val() == 1 || $('#mantenimiento_oculto2').val() == 2) {
			$('#orden_servicio_cronograma').css("display","");
			$('#proveedor_cronograma').css("display","");
			$('#garantia_cronograma').css("display","");
			$('#monto_cronograma').css("display","");
			$('#otm_cronograma').css("display","none");
		}

		if($('#mantenimiento_oculto2').val() == 3 || $('#mantenimiento_oculto2').val() == 4) {
			$('#orden_servicio_cronograma').css("display","none");
			$('#proveedor_cronograma').css("display","none");
			$('#monto_cronograma').css("display","none");
			$('#otm_cronograma').css("display","");
		} */
   });
});







