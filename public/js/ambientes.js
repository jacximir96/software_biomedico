var tablaAmbientes = $("#tablaAmbientes").DataTable({
    processing: false,
    serverSide: true,
	responsive: true,
    autoWidth: false,
	ajax :{
		url: ruta + '/obtenerambiente'
	},
	"columnDefs":[{
        "searchable": true,
        "orderable" : true,
        "targets" : 0
    }],
	"order": [[0, "desc"]],
	columns:[	
		{
			data: 'id_ambiente',
			name: 'id_ambiente',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
		},
		{
			data:'nombre_ambiente' ,
			name:'nombre_ambiente',
			render: function (item) {
                return item.toUpperCase();
            }
		}, 
		{
			data:'nombre_estado' ,
			name:'nombre_estado',
			render: function (item) {
                return item.toUpperCase();
            }
		}, 
		{
			data:'nombre_departamento',
			name:'nombre_departamento'
		}, 
		{
			data:function (row) {
				if (row.id_departamento != '') {
					return row.nombre_direccionAmbiente
				}else{
					return row.nombre_direccionDepartamento
				}
			},
			name:'id_departamento'
		}, 
		{ 
			data: "id_ambiente",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return `
					<div class="btn-group text-center">
						<button data-modal-target="editarModal" class="open-modal-btn hover:text-primary editar-btn" data-id="${data}" aria-label="Editar">
							<svg class="fill-current" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"/>
								<path d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67812 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67812 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906Z"/>
							</svg>
						</button>
						<button class="hover:text-danger eliminarRegistro" action="${ruta}/ambientes/${data}" method="DELETE" pagina="ambientes" aria-label="Eliminar">
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
		  var pageInfo = tablaAmbientes.page.info();
		  updatePagination(pageInfo);
		  updateInfo(pageInfo);
	}
});

var buttons = new $.fn.DataTable.Buttons(tablaAmbientes, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Ambientes',
            "filename": 'AMBIENTES',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">Excel</button>',
            "className": 'btn btn-sm btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
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
            "title": 'Ambientes',
            "filename": 'AMBIENTES',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3, 4]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['5%', '45%', '20%', '10%', '20%'];
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

tablaAmbientes.on('order.dt search.dt draw.dt', function () {
    tablaAmbientes.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaAmbientes.page.info().start + i + 1;  })
}).draw();
$('#tablaAmbientes').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    $.get(ruta + '/ambientes/json/' + id, function(data) {
        $('#id').val(data.id_ambiente);
        $('#nombre_ambiente').val(data.nombre_ambiente);
        $('#estado_ambiente').val(data.estado_ambiente);
        $('#id_departamento').val(data.id_departamento);
        $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
		$('#editForm').attr('action', ruta+`/ambientes/${id}`);
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
    tablaAmbientes.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaAmbientes.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaAmbientes.page.len(valor).draw();
});
