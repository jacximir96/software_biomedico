let tablaHistorialEquipos = $("#tablaHistorialEquipos").DataTable({
    processing: false,
    serverSide: true,
	responsive: {
        details: {
            type: 'column',
            target: 'td.expand-control',
        }
    },
	autoWidth: false,
	ajax : {
		url: ruta + "/obtenerhistorialequipos",
	},
	"createdRow": function(row, data, dataIndex) {
        $(row).addClass('cursor-pointer');
    },
    "columnDefs": [
        {
            targets: 0,
            className: 'expand-control',
            orderable: false,
            data: null,
            defaultContent: '',
            responsivePriority: 1
        },
        {
            targets: 1,
            responsivePriority: 2,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        }
    ],
	"order": [[0, "desc"]],
	columns:[
		{
			data: 'id_equipo',
			name: 'id_equipo',
			render: function (data, type, row, meta) {
				return meta.row + 1;
			}
		},
		{
			data:'nombre_equipo',
			name:'nombre_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'marca_equipo',
			name:'marca_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'modelo_equipo',
			name:'modelo_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'serie_equipo',
			name:'serie_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'cp_equipo',
			name:'cp_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{ 
			data: "id_equipo",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return `
					<div class="btn-group text-center">
						<button data-modal-target="editarModal" class="open-modal-btn hover:text-primary editar-btn" data-id="${data}" aria-label="Editar"> Historial
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"/>
								<path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67812 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67812 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906Z"/>
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
		var pageInfo = tablaHistorialEquipos.page.info();
		updatePagination(pageInfo);
		updateInfo(pageInfo);
	}
});

var buttons = new $.fn.DataTable.Buttons(tablaHistorialEquipos, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Historial de equipos',
            "filename": 'HISTORIAL_EQUIPOS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">Excel</button>',
            "className": 'btn btn-sm btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
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
            "title": 'Historial de equipos',
            "filename": 'HISTORIAL_EQUIPOS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['5%', '25%', '25%', '25%', '10%', '10%'];
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

tablaHistorialEquipos.on('order.dt search.dt draw.dt', function () {
    tablaHistorialEquipos.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaHistorialEquipos.page.info().start + i + 1;  })
}).draw();

$('#tablaHistorialEquipos').on('click', '.editar-btn', function() {
    let id = $(this).data('id');
	console.log(id);
   
	if ($.fn.DataTable.isDataTable('#historialCompra1')) {
        $('#historialCompra1').DataTable().destroy();
    }

	var boton = document.getElementById("historialServicioImprimir");
    boton.href = ruta + '/reportesEquipos/EquiposPdf/' + id;

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
		processing: false,
		serverSide: true,
		ajax :ruta +"/mantenimientoServicioHistorial/json/" + id,
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
								<a href="../public/storage/${row.pdf_cronograma}" download="Archivo de conformidad" class="btn btn-default btn-sm">
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
		dom: 'rt'
	});
});

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
    tablaHistorialEquipos.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaHistorialEquipos.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaHistorialEquipos.page.len(valor).draw();
});