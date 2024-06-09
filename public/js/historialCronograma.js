$("#historial").DataTable({

	processing: true,
   serverSide: true,
   lengthChange: false,
   ajax :ruta +"/obtenercronogramafecha",
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
				return' <button class="btn btn-warning btn-sm editar-btn" style="text-align: center;"  data-toggle="modal" data-target="#editarModal" data-id="' +data+'">Registrar	</button>';
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

  	}
});
$('#historial').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta +'/cronogramasfecha/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
		

		if(data.id_mantenimiento === 1 || data.id_mantenimiento === 2){
			$('#ods').show();
			$('#garantiaVer').show();
			$('#otm').hide();
			
		   }else{
			$('#garantiaVer').hide();
			$('#ods').hide();
			$('#otm').show();
		   }


		$('#mantenimiento_oculto').val(data.id_mantenimiento);
        $('#cronograma_equipo').val(data.id_equipo);
         $('#nombre_equipo').val(data.equipo.nombre_equipo);
		$('#cronograma_fecha').val(data.fecha);
		$('#cronograma_fecha_final').val(data.fecha_final);
		 $('#id_ordenServicio').val(data.id_ordenServicio);

		//$('#cronograma_realizado').val(data.realizado);
		 $('#id_proveedor').val(data.id_proveedor);
		$('#id_departamento').val(data.id_departamento);
		$('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);
		 $('#cronograma_garantia').val(data.garantia);
		$('#cronograma_observacion').val(data.observacion);
		 $('#monto_cronograma').val(data.monto_cronograma);
		$('#otm_cronograma').val(data.otm_cronograma);
		$('#pdf_archivo_final').val(data.pdf_cronograma);
        
        // $('#id_departamento').val(data.id_departamento);
       
        // Continúa con los demás campos
        $('#editForm').attr('action', ruta+`/cronogramas/${id}`);
    });
    
});
