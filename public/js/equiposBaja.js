let tablaEquiposBaja = $("#tablaEquiposBaja").DataTable({
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
		url: ruta + "/obtenerEquipoBaja",
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
	columns: [
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
        {data:'idEquipo_baja' ,name:'idEquipo_baja'},
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
		  var pageInfo = tablaEquiposBaja.page.info();
		  updatePagination(pageInfo);
		  updateInfo(pageInfo);
	  },
	  initComplete: function () {
		EquipoFilterBaja(tablaEquiposBaja);
		MarcaFilterBaja(tablaEquiposBaja);
	}
});

var buttons = new $.fn.DataTable.Buttons(tablaEquiposBaja, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Equipos de baja',
            "filename": 'EQUIPOS DE BAJA',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">Excel</button>',
            "className": 'btn btn-sm btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
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
            "title": 'Equipos de baja',
            "filename": 'EQUIPOS DE BAJA',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['10%', '15%', '15%', '15%', '15%', '15%', '15%'];
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

tablaEquiposBaja.on('order.dt search.dt draw.dt', function () {
    tablaEquiposBaja.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaEquiposBaja.page.info().start + i + 1;  })
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
    tablaEquiposBaja.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaEquiposBaja.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaEquiposBaja.page.len(valor).draw();
});


function EquipoFilterBaja(tablaEquiposBaja) {
	tablaEquiposBaja.columns(1).every(function() {
		var column = tablaEquiposBaja.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR EL EQUIPO --</option></select>')
			.appendTo($('#equipoFilterBaja').empty())
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




function MarcaFilterBaja(tablaEquiposBaja) {
	tablaEquiposBaja.columns(2).every(function() {
		var column = tablaEquiposBaja.column(this, {
			search: 'applied'
		});
		var select = $('<select class="form-control select2 select-2" name="" id=""><option value="">-- SELECCIONAR LA MARCA --</option></select>')
			.appendTo($('#marcaFilterBaja').empty())
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

