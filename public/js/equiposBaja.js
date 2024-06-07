let equiposBaja = $("#equiposBaja").DataTable({
	processing: true,
    serverSide: true,
	ajax :ruta+"/obtenerEquipoBaja",

	columns: [
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
		{data:'cp_equipo' ,name:'cp_equipo'}, //nombre de equipo
        {data:'idEquipo_baja' ,name:'idEquipo_baja'}, //nombre de equipo
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
		EquipoFilterBaja(equiposBaja);
		MarcaFilterBaja(equiposBaja);
	}
});


function EquipoFilterBaja(equiposBaja) {
	equiposBaja.columns(1).every(function() {
		var column = equiposBaja.column(this, {
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




function MarcaFilterBaja(equiposBaja) {
	equiposBaja.columns(2).every(function() {
		var column = equiposBaja.column(this, {
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

