$.ajax({
    url: ruta + '/direccionesEjecutivas',
    success: function (respuesta) {
        console.log("respuesta", respuesta);
    },

    error: function (jqXHR, textStatus, errorThrown) {
        console.error(textStatus + " " + errorThrown);
    }
});

var tablaDireccionesEjecutivas = $("#tablaDireccionesEjecutivas").DataTable({
    processing: false,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
        url: ruta + '/direccionesEjecutivas'
    },
    "columnDefs":[{
        "searchable": true,
        "orderable" : true,
        "targets" : 0
    }],

    "order": [[0, "desc"]],
    columns: [
        {
            data: 'id_direccionEjecutiva',
            name: 'id_direccionEjecutiva',
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'nombre_direccionEjecutiva',
            name: 'nombre_direccionEjecutiva',
            render: function (item) {
                return item.toUpperCase();
            }
        },
        {
            data: 'iniciales_direccionEjecutiva',
            name: 'iniciales_direccionEjecutiva',
            render: function (item) {
                return item.toUpperCase();
            }
        },
        {
            data: 'nombre_estado',
            name: 'nombre_estado'
        },
        {
            data: 'acciones',
            name: 'acciones',
        }
    ],
    "paging": true,
    "pageLength": 10,
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
        var pageInfo = tablaDireccionesEjecutivas.page.info();
        updatePagination(pageInfo);
        updateInfo(pageInfo);
    }
});

var buttons = new $.fn.DataTable.Buttons(tablaDireccionesEjecutivas, {
    buttons: [
        {
            "extend": 'excel',
            "footer": false,
            "title": 'Direcciones ejecutivas',
            "filename": 'DIRECCIONES_EJECUTIVAS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-success px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">Excel</button>',
            "className": 'btn btn-sm btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3]
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
            "title": 'Direcciones ejecutivas',
            "filename": 'DIRECCIONES_EJECUTIVAS',
            "text": '<button class="inline-flex items-center justify-center gap-2.5 rounded-md bg-danger px-6 py-4 text-center font-medium text-white hover:bg-opacity-90 min-w-150">PDF</button>',
            "className": 'btn btn-sm btn-danger',
            exportOptions: {
                columns: [0, 1, 2, 3]
            },
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function(doc) {
                doc.content[1].table.widths = ['20%', '30%', '30%', '20%'];
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

tablaDireccionesEjecutivas.on('order.dt search.dt draw.dt', function () {
    tablaDireccionesEjecutivas.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) { cell.innerHTML = tablaDireccionesEjecutivas.page.info().start + i + 1;  })
}).draw();

$('#tablaDireccionesEjecutivas').on('click', '.editar-btn', function () {
    var id = $(this).data('id');

    $.get(ruta + '/direccionesejecutivas/json/' + id, function (data) {
        $('#nombre_direccionEjecutiva').val(data.nombre_direccionEjecutiva);
        $('#iniciales_direccionEjecutiva').val(data.iniciales_direccionEjecutiva);
        $('#estado_direccionEjecutiva').val(data.estado_direccionEjecutiva);
        $('#editForm').attr('action', ruta + `/direccionesEjecutivas/${id}`);
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
    tablaDireccionesEjecutivas.page(page).draw(false);
});

$('.datatable-input').on('keyup', function() {
    tablaDireccionesEjecutivas.search(this.value).draw();
});

$('.datatable-selector').on('change', function() {
    var valor = $(this).val();
    tablaDireccionesEjecutivas.page.len(valor).draw();
});
