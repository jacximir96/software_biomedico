
/*  Capturar ruta de mi servidor */
var ruta = $("#ruta").val();

/* Agregar red */
$(document).on("click",".agregarRed", function(){
    var url = $("#url_red").val();
    var icono = $("#icono_red").val().split(",")[0];
    var color = $("#icono_red").val().split(",")[1];

    $(".listadoRed").append(
        `<div class="col-lg-12">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <div class="input-group-text text-white" style="background:`+color+`">
              <i class="`+icono+`"></i>
            </div>
          </div>

          <input type="text" class="form-control" value="`+url+`">

          <div class="input-group-prepend">
            <div class="input-group-text" style="cursor:pointer">
              <span class="bg-danger px-2 rounded-circle eliminarRed" red="`+icono+`" url="`+url+`">&times;</span>
            </div>
          </div>
        </div>
      </div>`)

    /* Actualizar el registro en la BD */

    var listaRed = JSON.parse($("#listaRed").val());
    listaRed.push({
        "url":url,
        "icono":icono,
        "background":color
    })

    $("listaRed").val(JSON.stringify(listaRed));
})

var campo = $("#id_personal_externo").val();

                        if(campo != ''){
                            $('#nombres_profesional_texto').remove();
                            $('#fecha_actual_epp').remove();
                            $('#horario_jornada_profesional').remove();
                            $('#id_jornada_profesional').remove();
                            $('#id_calendario_epp').remove();
                        }
                        else{
                            $('#nombres_personal_texto').remove();
                            $('#fecha_actual_personal').remove();
                            $('#horario_jornada_personal').remove();
                            $('#id_jornada_personal').remove();
                            $('#id_calendario_personal').remove();
                        }


 /* Eliminar Red */

$(document).on("click",".eliminarRed", function(){
    $("listaRed").val(JSON.stringify(listaRed));
    var red= $(this).attr("red");
    var url= $(this).attr("url");

     for (var i = 0; i < listaRed.length; i++) {
         if (red == listaRed[i]["icono"] && url== listaRed[i]["url"]) {
             listaRed.splice(i,1);
             $(this).parent().parent().parent().parent().remove();
         }
    }
})

$("#tabla_ocultar").hide();



/* Ocultar listado de cronograma */
$(function(){
    $("#ocultar_listado").click(function(){
        $("#tabla_ocultar").toggle();
    });
});

/*Ocultar Fecha de HTML*/
$("#fecha_actual_epp").prop('disabled', true);
$("#fecha_actual_personal").prop('disabled', true);
$("#customSwitch2").prop('disabled', true);
$("#customSwitch5").prop('disabled', true);
/* $("#fecha_actual_calendario").prop('disabled', true); */
$('#boton_epp').on("click",function(){
    $("#fecha_actual_epp").prop('disabled', false);
    $("#fecha_actual_personal").prop('disabled', false);
    $("#boton_registro").attr('href','#');
})

$('#id_departamento_a').on('change',function(){
    var valor = $(this).val();

    if(valor == ''){
        $('#id_direccionEjecutiva_a').css("display","");
    }else{
        $('#id_direccionEjecutiva_a').css("display","none");
    }

});

$('#boton_equipo').on("click",function(){
    $("#customSwitch2").prop('disabled', false);
    $("#customSwitch5").prop('disabled', false);
})

$('#valor_garantia').css("display","none");
$('#orden_servicio_cronograma').css("display","none");
$('#proveedor_cronograma').css("display","none");
$('#garantia_cronograma').css("display","none");
$('#monto_cronograma').css("display","none");
$('#mantenimiento_equipo_vacio').css("","");

$("select[name=id_mantenimiento]").change(function(){
    var valor_selectMantenimiento = $('select[name=id_mantenimiento]').val();

    if(valor_selectMantenimiento == 1 || valor_selectMantenimiento == 2){
        $('#valor_garantia').css("display","");
    }else{
        $('#valor_garantia').css("display","none");
    }
});

$("#nombres_departamento").change(function(){
	console.log($("#nombres_departamento").val());
	if($("#nombres_departamento").val() == ''){
		$("#nombres_direccionEjecutiva").val('');
		$("#nombres_direccionEjecutiva_editar").css("display","");
	}else{
		$("#nombres_direccionEjecutiva_editar").css("display","none");
	}
});

$("#nombres_direccionEjecutiva").change(function(){
	console.log($("#nombres_direccionEjecutiva").val());
	if($("#nombres_direccionEjecutiva").val() == ''){
		$("#nombres_departamento").val('');
		$("#nombres_departamento_editar").css("display","");
	}else{
		$("#nombres_departamento_editar").css("display","none");
	}
});

if($('#mantenimiento_oculto').val() == 1 || $('#mantenimiento_oculto').val() == 2){
    $('#orden_servicio_cronograma').css("display","");
    $('#proveedor_cronograma').css("display","");
    $('#garantia_cronograma').css("display","");
    $('#monto_cronograma').css("display","");
    $('#otm_cronograma').css("display","none");
}

/*=============================================
PREVISUALIZAR IMÁGENES TEMPORALES
=============================================*/
$("#foto_administrador").change(function(){

	var imagen = this.files[0];
	var tipo = $(this).attr("name");

	/*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

    	$("input[type='file']").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen debe estar en formato JPG o PNG!',
		    time: 7

		 })

    }else if(imagen["size"] > 2000000){

    	$("input[type='file']").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen no debe pesar más de 2MB!',
		    time: 7

		 })

    }else{

    	var datosImagen = new FileReader;
        console.log(datosImagen);
    	datosImagen.readAsDataURL(imagen);

    	$(datosImagen).on("load", function(event){

    		var rutaImagen = event.target.result;

    		$(".previsualizarImg_"+tipo).attr("src", rutaImagen);

    	})

    }

})

/*=============================================
PREVISUALIZAR IMÁGENES TEMPORALES
=============================================*/
$("#pdf_ordenServicio").change(function(){

	var pdf_archivo = this.files[0];
	var tipo = $(this).attr("name");

	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(pdf_archivo["type"] != "application/pdf"){

    	$("#pdf_ordenServicio").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo debe estar en formato PDF!',
		    time: 7

		 })

    }else if(pdf_archivo["size"] > 20000000){

    	$("#pdf_ordenServicio").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo no debe pesar más de 20MB!',
		    time: 7

		 })

    }else{


    	var datosPdf_ordenServicio = new FileReader;
    	var probando = datosPdf_ordenServicio.readAsDataURL();

    }

})

/*=============================================
PREVISUALIZAR IMÁGENES TEMPORALES
=============================================*/
$("#pdf_ordenServicio_editar").change(function(){

	var pdf_archivo = this.files[0];
	var tipo = $(this).attr("name");

	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(pdf_archivo["type"] != "application/pdf"){

    	$("#pdf_ordenServicio_editar").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo debe estar en formato PDF!',
		    time: 7

		 })

    }else if(pdf_archivo["size"] > 20000000){

    	$("#pdf_ordenServicio").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo no debe pesar más de 20MB!',
		    time: 7

		 })

    }else{


    	var datosPdf_ordenServicio = new FileReader;
    	var probando = datosPdf_ordenServicio.readAsDataURL();

    }

})

/*=============================================
PREVISUALIZAR IMÁGENES TEMPORALES
=============================================*/
$("#pdf_cronograma").change(function(){

	var pdf_archivo = this.files[0];
	var tipo = $(this).attr("name");

	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(pdf_archivo["type"] != "application/pdf"){

    	$("#pdf_cronograma").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo debe estar en formato PDF!',
		    time: 7

		 })

    }else if(pdf_archivo["size"] > 20000000){

    	$("#pdf_ordenServicio").val("");

    	notie.alert({

		    type: 3,
		    text: '¡El archivo no debe pesar más de 20MB!',
		    time: 7

		 })

    }else{


    	var datosPdf_ordenServicio = new FileReader;
    	var probando = datosPdf_ordenServicio.readAsDataURL();

    }

})

/*=============================================
IMAGEN DE EQUIPOS SIN GARANTIA
=============================================*/
$("#imagen_equipo").change(function(){

	var imagen_archivo = this.files[0];
	var tipo = $(this).attr("name");
	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(imagen_archivo["type"] != "image/jpeg" && imagen_archivo["type"] != "image/png"){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen debe estar en formato JPG o PNG!',
		    time: 7

		 })

    }else if(imagen_archivo["size"] > 10000000){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen no debe pesar más de 10MB!',
		    time: 7

		 })

    }else{


    	var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen_archivo);

        $(datosImagen).on("load", function(event){

    		var rutaImagen = event.target.result;

    		$(".previsualizarImg_"+tipo).attr("src", rutaImagen);

    	})

    }

})

/*=============================================
IMAGEN DE EQUIPOS SIN GARANTIA
=============================================*/
$("#imagen_equipo_editar").change(function(){

	var imagen_archivo = this.files[0];
	var tipo = $(this).attr("name");
	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(imagen_archivo["type"] != "image/jpeg" && imagen_archivo["type"] != "image/png"){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen debe estar en formato JPG o PNG!',
		    time: 7

		 })

    }else if(imagen_archivo["size"] > 10000000){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen no debe pesar más de 10MB!',
		    time: 7

		 })

    }else{


    	var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen_archivo);

        $(datosImagen).on("load", function(event){

    		var rutaImagen = event.target.result;

    		$(".previsualizarImg_"+tipo).attr("src", rutaImagen);

    	})

    }

})

$("#imagen_equipoGarantia_editar").change(function(){

	var imagen_archivo = this.files[0];
	var tipo = $(this).attr("name");
	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(imagen_archivo["type"] != "image/jpeg" && imagen_archivo["type"] != "image/png"){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen debe estar en formato JPG o PNG!',
		    time: 7

		 })

    }else if(imagen_archivo["size"] > 10000000){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen no debe pesar más de 10MB!',
		    time: 7

		 })

    }else{


    	var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen_archivo);

        $(datosImagen).on("load", function(event){

    		var rutaImagen = event.target.result;

    		$(".previsualizarImg_"+tipo).attr("src", rutaImagen);

    	})

    }

})

/*=============================================
IMAGEN DE EQUIPOS SIN GARANTIA
=============================================*/
$("#imagen_equipoGarantia").change(function(){

	var imagen_archivo = this.files[0];
	var tipo = $(this).attr("name");
	/*=============================================
    VALIDAMOS EL FORMATO SEA PDF
    =============================================*/

    if(imagen_archivo["type"] != "image/jpeg" && imagen_archivo["type"] != "image/png"){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen debe estar en formato JPG o PNG!',
		    time: 7

		 })

    }else if(imagen_archivo["size"] > 10000000){

    	$("#imagen_equipo").val("");

    	notie.alert({

		    type: 3,
		    text: '¡La imagen no debe pesar más de 10MB!',
		    time: 7

		 })

    }else{


    	var datosImagen = new FileReader;
    	datosImagen.readAsDataURL(imagen_archivo);

        $(datosImagen).on("load", function(event){

    		var rutaImagen = event.target.result;

    		$(".previsualizarImg_"+tipo).attr("src", rutaImagen);

    	})

    }

})

/*=============================================
Preguntar antes de Eliminar Registro
=============================================*/

$(document).on("click", ".eliminarRegistro", function(){

	var action = $(this).attr("action");
    console.log(action);
  	var method = $(this).attr("method");
      console.log(method);
  	var pagina = $(this).attr("pagina");
      console.log(pagina);

	var token = $('meta[name="csrf-token"]').attr('content');
	console.log(token);
	

  	swal({
  		 title: '¿Está seguro de eliminar este registro?',
  		 text: "¡Si no lo está puede cancelar la acción!",
  		 type: 'warning',
  		 showCancelButton: true,
  		 confirmButtonColor: '#3085d6',
  		 cancelButtonColor: '#d33',
  		 cancelButtonText: 'Cancelar',
  		 confirmButtonText: 'Si, eliminar registro!'
  	}).then(function(result){

  		if(result.value){

  			var datos = new FormData();
  			datos.append("_method", method);
  			datos.append("_token", token);
			
  			$.ajax({

  				url: action,
  				method: "DELETE",
				  headers: {
					'X-CSRF-TOKEN': token
				},
  				data: datos,
  				cache: false,
  				contentType: false,
        		processData: false,
        		success:function(respuesta){

        			 if(respuesta == "ok"){

    			 		swal({
		                    type:"success",
		                    title: "¡El registro ha sido eliminado!",
		                    showConfirmButton: true,
		                    confirmButtonText: "Cerrar"

			             }).then(function(result){

			             	if(result.value){
                                 window.location = ruta+'/'+pagina;
			             	}


			             })

        			 }

        		},
		        error: function (jqXHR, textStatus, errorThrown) {
		            console.error(textStatus + " " + errorThrown);
		        }

  			})

  		}

  	})

})

$('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
})

$(document).on("click", ".eliminarRegistroPermisos", function(){

	var action = $(this).attr("action");
  	var method = $(this).attr("method");
  	var pagina = $(this).attr("pagina");
    var token = $(this).attr("token");
    var value = $(this).attr("value");

  	swal({
  		 title: '¿Está seguro de eliminar este registro?',
  		 text: "¡Si no lo está puede cancelar la acción!",
  		 type: 'warning',
  		 showCancelButton: true,
  		 confirmButtonColor: '#3085d6',
  		 cancelButtonColor: '#d33',
  		 cancelButtonText: 'Cancelar',
  		 confirmButtonText: 'Si, eliminar registro!'
  	}).then(function(result){

  		if(result.value){

  			var datos = new FormData();
  			datos.append("_method", method);
  			datos.append("_token", token);

  			$.ajax({

  				url: action,
  				method: "POST",
  				data: datos,
  				cache: false,
  				contentType: false,
        		processData: false,
        		success:function(respuesta){

        			 if(respuesta == "ok"){

    			 		swal({
		                    type:"success",
		                    title: "¡El registro ha sido eliminado!",
		                    showConfirmButton: true,
		                    confirmButtonText: "Cerrar"

			             }).then(function(result){

			             	if(result.value){
                                 window.location = ruta+'/'+pagina+'/'+value;
			             	}


			             })

        			 }

        		},
		        error: function (jqXHR, textStatus, errorThrown) {
		            console.error(textStatus + " " + errorThrown);
		        }

  			})

  		}

  	})

})

/* SummerNote */
$(".summernote").summernote();

/*=============================================
DataTable SERVIDOR de administradores
=============================================*/
/* $.ajax({

    url: ruta+"/administradores",
    success: function(respuesta){

    console.log("respuesta", respuesta);

    },
    error: function (jqXHR, textStatus, errorThrown) {
    console.error(textStatus + " " + errorThrown);
    }

}) */

function limpiarUrl(texto){
    var texto = texto.toLowerCase();
    texto = texto.replace(/[-\\´\\,\\.\\;\\:\\-\\_\\<\\>\\+\\*\\/\\¿\\?\\=\\(\\)\\&\\%\\$\\#\\"\\!\\°\\|\\{\\}\\[\\!\\¡\\'\\a-zA-ZñÑáéíóúÁÉÍÓÚ ]/g,'');
/*     texto = texto.replace(/[é]/g,'');
    texto = texto.replace(/[í]/g,'i');
    texto = texto.replace(/[ó]/g,'o');
    texto = texto.replace(/[ú]/g,'u');
    texto = texto.replace(/[ñ]/g,'n');
    texto = texto.replace(/ /g,'-'); */

    return texto;
}

function limpiarUrlMonto(texto){
    var texto = texto.toLowerCase();
    texto = texto.replace(/[-\\´\\,\\;\\:\\-\\_\\<\\>\\+\\*\\/\\¿\\?\\=\\(\\)\\&\\%\\$\\#\\"\\!\\°\\|\\{\\}\\[\\!\\¡\\'\\a-zA-ZñÑáéíóúÁÉÍÓÚ ]/g,'');
/*     texto = texto.replace(/[é]/g,'');
    texto = texto.replace(/[í]/g,'i');
    texto = texto.replace(/[ó]/g,'o');
    texto = texto.replace(/[ú]/g,'u');
    texto = texto.replace(/[ñ]/g,'n');
    texto = texto.replace(/ /g,'-'); */

    return texto;
}

$(document).on("keyup",".inputRuta",function(){
    $(this).val(
        limpiarUrl($(this).val())
    )
})

$(document).on("keyup",".inputRutaMonto",function(){
    $(this).val(
        limpiarUrlMonto($(this).val())
    )
})

$(document).on("click",".nav-link",function(){
        $(this).addClass("active");
})










