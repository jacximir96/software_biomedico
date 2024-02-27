/*=============================================
DataTable de Jornadas Laborales
=============================================*/

$("#tablaAmbientes").DataTable({
    
	processing: true,
    serverSide: true,
	lengthChange: false,
	ajax :{
		url: ruta + '/obtenerambiente'
	}
	,
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
		{data:'nombre_ambiente' ,name:'nombre_ambiente'}, 
		{data:'nombre_estado' ,name:'nombre_estado'}, 
		{data:'nombre_departamento' ,name:'nombre_departamento'}, 
		{data:function (row) {
			if (row.id_departamento == '') {
				return row.nombre_direccionAmbiente
			}else{
				return row.nombre_direccionDepartamento
			}
		}
			,name:'id_departamento'}, 
		{ 
			data: "id_ambiente",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return'<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+ 
				 '<button class="btn btn-danger btn-sm eliminarRegistro" action="'+ ruta +'/ambientes/'+ data +'" method=DELETE pagina="ambientes">'+
					'<i class="fas fa-trash-alt text-white"></i>'+
				 '</button>'
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
$('#tablaAmbientes').on('click', '.editar-btn', function() {
    var id = $(this).data('id');

    // Realiza una petición AJAX para obtener los datos del registro
    $.get(ruta + '/ambientes/json/' + id, function(data) {
        // console.log("Datos recibidos:",data);
        // Completa el formulario del modal con los datos recibidos
        //$('#id').val(data.id_departamento);
        $('#nombre_ambiente').val(data.nombre_ambiente);
        $('#estado_ambiente').val(data.estado_ambiente);
        $('#id_departamento').val(data.id_departamento);
        $('#id_direccionEjecutiva').val(data.id_direccionEjecutiva);

		$('#editForm').attr('action', ruta+`/ambientes/${id}`);
        
		
    });
    
});
