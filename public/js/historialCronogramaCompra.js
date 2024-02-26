
$("#historialCronogramaCompra").DataTable({

	processing: true,
   serverSide: true,
   lengthChange: false,
   ajax :ruta +"/obtenercronogramacompra",
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
	   {data:'nombre_equipoGarantia' ,name:'nombre_equipoGarantia'}, //nombre de equipo
	    {data: function (row) {
			return moment(row.fecha).format('DD/MM/YYYY'); 
		}
		,name:'fecha'}, // serie de equipo
	    {data: function (row) {
			return moment(row.fecha_final).format('DD/MM/YYYY'); 
		},name:'fecha_final'}, // codigo patronal de equip
        {data:'cp_equipoGarantia',name:"cp_equipoGarantia"},
		{ 
			data: "id_cronogramaCalendario",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return' <button class="btn btn-warning btn-sm editar-btn"  data-toggle="modal" data-target="#editarModal" data-id="' +data+'">Registrar</button>';
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
$('#historialCronogramaCompra').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta +'/cronogramasfechacompras/json/' + id, function(data) {
		$('#cronograma_equipo').val(data.id_equipoGarantia);
         $('#nombre_equipoGarantia').val(data.equipo.nombre_equipoGarantia);
		$('#cronograma_fecha').val(data.fecha);
		$('#cronograma_fecha_final').val(data.fecha_final);
		$('#cronograma_realizado').val(data.realizado);
		$('#cronograma_observacion').val(data.observacion);
		 $('#pdf_archivo_final').val(data.pdf_cronograma);
         $('#pdf_archivo_final').val(data.pdf_cronograma);
         //id_proveedor
        $('#id_proveedor').val(data.id_proveedor);
       
        // Continúa con los demás campos
        $('#editForm').submit(function(event) {
            event.preventDefault();
            // var formData = $(this).serialize();
			var formData = new FormData(this);
			var pdfArchivoEditar = document.getElementById('pdf_archivo_final').files[0];

            // Agregar el archivo PDF al formData si está presente
            if (pdfArchivoEditar) {
                formData.append('pdf_archivo_final', pdfArchivoEditar);
            }
            // event.preventDefault();
    
            // // Serializar los datos del formulario
            // var formData = $(this).serialize();
            // var pdfArchivoEditar = document.getElementById('pdf_archivo_final').files[0];

            // // Convertir la cadena serializada a un objeto FormData
            // var formDataObject = new FormData();
            // // Agregar los datos serializados al objeto FormData
            // formDataObject.append('formData', formData);
            
            // // Agregar el archivo PDF al formData si está presente
            // if (pdfArchivoEditar) {
            //     formDataObject.append('pdf_archivo_final', pdfArchivoEditar);
            // }
    
            // Realiza una petición AJAX para actualizar el registro
            $.ajax({
                url: ruta+'/cronogramasCalendario/' + id,
                type: 'POST',
                data:formData,
				contentType: false,
                processData: false, // No procesar los datos (ya están en FormData)
                success: function(response) {
                    location.reload();
                    // if (response) {
                        
                    // }
                }, 
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
           
        });
    });   
});
