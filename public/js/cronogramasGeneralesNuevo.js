/*=============================================
DataTable de Jornadas Laborales
=============================================*/
var tablaCronogramasGeneral = $("#tablaCronogramasGeneralesNuevo").DataTable({
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
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   3
        } ],
  
    select: {
        style:    'multi',
        selector: 'td:nth-child(4)'
    }
  });
  
  $('#guardarCronogramaGeneral').on('click', function (event) {
    event.preventDefault();
  
    $('#form').find('input[type="hidden"]').remove();
    var token_cronograma = $('#token').val();
    var mes_cronograma = $('#mes_cronograma').val();
    var año_cronograma = $('#año_cronograma').val();
    var seleccionados = tablaCronogramasGeneral.rows({ selected: true });
  
    if(!seleccionados.data().length)
      alert("No ha seleccionado ningún producto");
    else{
        $('<input>', {
            type: 'hidden',
            value: token_cronograma,
            name: 'token'
        }).appendTo('#form');
  
      seleccionados.every(function(key,data){
        /* console.log(this.data()[0]); */
  
        $('<input>', {
            type: 'hidden',
            value: this.data()[0],
            name: 'equipos_cronograma[]'
        }).appendTo('#form');
  
        $("#form").submit(); //submiteas el form
      });
    }
  });
  
  
  
  