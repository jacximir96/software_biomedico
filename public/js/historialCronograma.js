var tablaHistorial = $("#historial").DataTable({
	processing: false,
   	serverSide: true,
	responsive: true,
	autoWidth: false,
   	ajax : {
		url: ruta +"/obtenercronogramafecha"
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
	   {data:'nombre_equipo' ,name:'nombre_equipo'}, //nombre de equipo
	   {data:'cp_equipo' ,name:'cp_equipo'}, // marca de equipo
	   {data:'nombre_mantenimiento' ,name:'nombre_mantenimiento'}, // modelo de equipo
	    {data: function (row) {
			return moment(row.fecha).format('DD/MM/YYYY'); 
		}
		,name:'fecha'}, // serie de equipo
	    {data: function (row) {
			return moment(row.fecha_final).format('DD/MM/YYYY'); 
		},name:'fecha_final'}, // codigo patronal de equip
		{ 
			data: "id_cronograma",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return `
					<div class="btn-group text-center">
						<button data-modal-target="editarModal" class="open-modal-btn hover:text-primary editar-btn" data-id="${data}" aria-label="Editar"> Registrar
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
		var pageInfo = tablaHistorial.page.info();
		updatePagination(pageInfo);
		updateInfo(pageInfo);
	},
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

$('#historial').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    $.get(ruta +'/cronogramasfecha/json/' + id, function(data) {
		console.log(data);
		if(data.id_mantenimiento === 1 || data.id_mantenimiento === 2){
			$('#ods').show();
			$('#garantiaVer').show();
			$('#otm').hide();
		} else {
			$('#garantiaVer').hide();
			$('#ods').hide();
			$('#otm').show();
		}

		$('#mantenimiento_oculto1').val(data.id_mantenimiento);
        $('#cronograma_equipo').val(data.id_equipo);
        $('#nombre_equipo').val(data.equipo.nombre_equipo);
		$('#cronograma_fecha').val(data.fecha);
		$('#cronograma_fecha_final').val(data.fecha_final);
		$('#id_ordenServicio').val(data.id_ordenServicio);
		$('#id_proveedor').val(data.id_proveedor);
		$('#id_departamento').val(data.id_departamento);
		$('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
		$('#cronograma_garantia').val(data.garantia);
		$('#cronograma_observacion').val(data.observacion);
		$('#monto_cronograma').val(data.monto_cronograma);
		$('#otm_cronograma').val(data.otm_cronograma);
		$('#pdf_archivo_final').val(data.pdf_cronograma);
        $('#editForm').attr('action', ruta+`/cronogramas/${id}`);

		if($('#mantenimiento_oculto1').val() == 1 || $('#mantenimiento_oculto1').val() == 2) {
			$('#orden_servicio_cronograma').css("display","");
			$('#proveedor_cronograma').css("display","");
			$('#garantia_cronograma').css("display","");
			$('#monto_cronograma').css("display","");
			$('#otm_cronograma').css("display","none");
		}

		if($('#mantenimiento_oculto1').val() == 3 || $('#mantenimiento_oculto1').val() == 4) {
			$('#orden_servicio_cronograma').css("display","none");
			$('#proveedor_cronograma').css("display","none");
			$('#monto_cronograma').css("display","none");
			$('#otm_cronograma').css("display","");
		}
    });
});
