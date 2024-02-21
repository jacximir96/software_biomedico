/*=============================================
DataTable de Jornadas Laborales
=============================================*/

/*=============================================
DataTable de Jornadas Laborales
=============================================*/
var table = $("#tablaCronogramasGeneralNuevo").DataTable({
  processing: true,
  serverSide: true,
  ajax:ruta + "/obtenercronogramageneralnuevo",
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
    {data:'nombre_ambiente' ,name:'nombre_ambiente'}, //nombre de equipo
		{data:'nombre_equipoGarantia' ,name:'nombre_equipoGarantia'}, // marca de equipo
		{data:'marca_equipoGarantia' ,name:'marca_equipoGarantia'}, // modelo de equipo
		{data:'modelo_equipoGarantia' ,name:'modelo_equipoGarantia'}, // serie de equipo
		{data:'serie_equipoGarantia' ,name:'serie_equipoGarantia'}, // codigo patronal de equip
		{data:'cp_equipoGarantia' ,name:'cp_equipoGarantia'}, // tipo de equipo
		{data: 'mes_cronogramaGeneralNuevo',
            name: 'mes_cronogramaGeneralNuevo',
            render: function(data, type, full, meta) {
                switch(data) {
                    case 1:
                        return 'ENERO';
                    case 2:
                        return 'FEBRERO';
                    case 3:
                        return 'MARZO';
                    case 4:
                        return 'ABRIL';
                    case 5:
                        return 'MAYO';
                    case 6:
                        return 'JUNIO';
                    case 7:
                        return 'JULIO';
                    case 8:
                        return 'AGOSTO';
                    case 9:
                        return 'SEPTIEMBRE';
                    case 10:
                        return 'OCTUBRE';
                    case 11:
                        return 'NOVIEMBRE';
                    case 12:
                        return 'DICIEMBRE';
                    default:
                        return data;
                }
            }
          },
		{data:'año_cronogramaGeneralNuevo' ,name:'año_cronogramaGeneralNuevo'},// 
		{data:'realizado' ,name:'realizado',
    render: function(data, type, full, meta) {
      if (data === null) {
          return '<div style="text-align: center;"><i class="fas fa-times text-red" style=text-align:center;></i></div>'; // Cambia a otro nombre si el valor es null
      } else {
          return '<div style="text-align: center;"><i class="fas fa-check text-green" style="text-align:center;"></i></div>'; // Devuelve el valor original si no es null
      }
  }},
    { 
			data: "id_cronogramaGeneralNuevo",
			name: 'acciones',
			render: function(data, type, full, meta) {
				return '<button class="btn btn-warning btn-sm editar-btn" data-toggle="modal" data-target="#editarModal" data-id="' +data+'"><i class="fas fa-pencil-alt text-white"></i></button>'+  
				 '<button class="btn btn-danger btn-sm eliminarRegistro" action="/cronogramasGeneralNuevo/'+ data +'" method=DELETE pagina="cronogramasGeneralNuevo">'+
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
  },
  
});

$('#vender').on('click', function (event) {
  event.preventDefault();

  $('#form').find('input[type="hidden"]').remove();
  var token_cronograma = $('#token').val();
  var mes_cronograma = $('#mes_cronograma').val();
  var año_cronograma = $('#año_cronograma').val();
  var seleccionados = table.rows({ selected: true });

  if(!seleccionados.data().length)
    alert("No ha seleccionado ningún producto");
  else{
      console.log(token_cronograma);
      console.log(mes_cronograma);
      console.log(año_cronograma);

      $('<input>', {
          type: 'hidden',
          value: token_cronograma,
          name: 'token'
      }).appendTo('#form');

    seleccionados.every(function(key,data){
      console.log(this.data()[0]);

      $('<input>', {
          type: 'hidden',
          value: this.data()[0],
          name: 'equipos_cronograma[]'
      }).appendTo('#form');

      $("#form").submit(); //submiteas el form
    });
  }
});

$('#tablaCronogramasGeneralNuevo').on('click', '.editar-btn', function() {
  var id = $(this).data('id');

  // Realiza una petición AJAX para obtener los datos del registro
  $.get(ruta +'/cronogramageneralnuevo/json/' + id, function(data) {
      // console.log("Datos recibidos:",data);
      // Completa el formulario del modal con los datos recibidos
      //$('#id').val(data.id_departamento);
      $('#id_equipo').val(data.id_equipoGarantia);
      $('#nombre_equipoGarantia').val(data.equipogarantia.nombre_equipoGarantia);
      $('#marca_equipo').val(data.equipogarantia.marca_equipoGarantia);
      $('#modelo_equipo').val(data.equipogarantia.modelo_equipoGarantia);
      $('#serie_equipo').val(data.equipogarantia.serie_equipoGarantia);
      $('#cp_equipo').val(data.equipogarantia.cp_equipoGarantia);
      $('#mes_cronogramaGeneral').val(data.mes_cronogramaGeneralNuevo);
      $('#año_cronogramaGeneral').val(data.año_cronogramaGeneralNuevo);



      
      // Continúa con los demás campos
      $('#editForm').submit(function(event) {
          event.preventDefault();
          var formData = $(this).serialize();
  
          // Realiza una petición AJAX para actualizar el registro
          $.ajax({
              url:ruta + '/cronogramasGeneralNuevo/' + id,
              type: 'POST',
              data: formData,
              success: function(response) {
                
              },
              error: function(xhr, status, error) {
        console.error(textStatus + " " + errorThrown);
              }
          });
          location.reload();
      });
  
  });
  
});