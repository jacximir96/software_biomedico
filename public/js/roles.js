/*=============================================
DataTable de Jornadas Laborales
=============================================*/
let tablaEquiposReposicion = $("#tablaEquiposReposicion").DataTable({
	processing: false,
    serverSide: true,
	responsive: true,
	autoWidth: false,
	ajax : {
		url: ruta + "/obtenerequiporeposicion",

	},
	"columnDefs":[{
        "searchable": true,
        "orderable" : true,
        "targets" : 0
    }],
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
			data:'nombre_equipo' ,
			name:'nombre_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		}, 
		{
			data:'marca_equipo' ,
			name:'marca_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'modelo_equipo' ,
			name:'modelo_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{
			data:'serie_equipo' ,
			name:'serie_equipo',
			render: function (item) {
                return item.toUpperCase();
            }
		},
		{data:'cp_equipo' ,name:'cp_equipo'},
		{data:'criterio_1' ,name:'criterio_1',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}},
		{data:'criterio_2' ,name:'criterio_2',
		render:function (data,type,full,meta) {
			
			if (100*full.acumulado_cronograma/full.monto_adquisicion_equipo >= 40) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}	
		}},
		{data:'criterio_3' ,name:'criterio_3',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}},
		{data:'criterio_4' ,name:'criterio_4',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}},
		{data:'criterio_5' ,name:'criterio_5',
		render: function(data, type, full, meta) {
			full.antiguedad_equipo
			if (full.antiguedad_equipo >= full.tiempo_vida_util_equipo) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}
	},
		{data:'criterio_6' ,name:'criterio_6',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}},
		{data:'criterio_7' ,name:'criterio_7',
		render: function(data, type, full, meta) {
			if (data === 0) {
				return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>';
			} else {
				return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>';
			}
		}},
		{ 
			data: "id_equipo",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return `
					<div class="btn-group text-center">
						<button data-modal-target="editarModal" class="open-modal-btn hover:text-primary editar-btn" data-id="${data}" aria-label="Editar">
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"/>
								<path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67812 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67812 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906Z"/>
							</svg> Dar de baja
						</button>
						<a href="${ruta}/reportesEquipos/EquiposPdf/${data}" target="_blank" class="hover:text-primary">
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"/>
								<path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67812 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67812 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906Z"/>
							</svg> Tarjeta de Control
						</a>
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
		  var pageInfo = tablaEquiposReposicion.page.info();
		  updatePagination(pageInfo);
		  updateInfo(pageInfo);
	  },
	  initComplete: function () {
		EquipoFilterReposicion(tablaEquiposReposicion);
		MarcaFilterReposicion(tablaEquiposReposicion);
	}
});

var buttons = new $.fn.DataTable.Buttons(tablaEquiposReposicion, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Equipos de reposición',
            "filename": 'EQUIPOS DE REPOSICIÓN',
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
            "title": 'Equipos de reposición',
            "filename": 'EQUIPOS DE REPOSICIÓN',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['4%', '10%', '10%', '10%', '8%', '8%', '8%', '8%', '8%', '5%', '5%', '5%', '5%', '2%', '2%', '2%'];
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

tablaEquiposReposicion.on('order.dt search.dt draw.dt', function () {
    tablaEquiposReposicion.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaEquiposReposicion.page.info().start + i + 1;  })
}).draw();
$('#tablaEquiposReposicion').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        // $('#id').val(data.id_departamento);
        // $('#estado_departamento').val(data.estado_departamento);
        // $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
        // Continúa con los demás campos

		$('#editForm').attr('action', ruta+`/equiposReposicion/${id}`);
	  
   
    
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
    tablaEquiposReposicion.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaEquiposReposicion.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaEquiposReposicion.page.len(valor).draw();
});

function EquipoFilterReposicion(tablaEquiposReposicion) {
	tablaEquiposReposicion.columns(1).every(function() {
		var column = tablaEquiposReposicion.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR EL EQUIPO --</option></select>')
			.appendTo($('#equipoFilterReposicion').empty())
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

function MarcaFilterReposicion(tablaEquiposReposicion) {
	tablaEquiposReposicion.columns(2).every(function() {
		var column = tablaEquiposReposicion.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR LA MARCA --</option></select>')
			.appendTo($('#marcaFilterReposicion').empty())
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

