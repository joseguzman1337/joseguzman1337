function validar(form){

      $.ajax({//Ajax
          type: 'POST',
          url: '../asignacionSalones/validar.php',
          async: false,
          dataType: 'json',
          data:$(form).serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.valida===false){
                    $(" #mostrarResultados").css('display','');
                    $(" #mostrarResultados").html('<p>' + data.Error + '</p>');
                    $(" #mostrarResultados").delay(900).fadeOut(1000);
              		alert(data.Error);
                    return false;
               }else{
                   	$('#mostrarResultados').html("");
      		        rangoFechas(form);
               }
          }  
    });      
}
function rangoFechas(form){
		
		informeEspaciosLibres(form);
}

function informeEspaciosOcupados(form, fechas){
    var horaInicio=document.getElementById("datetimepicker1").value+":00";
    var horaFinal=document.getElementById("datetimepicker2").value+":00";
    var accesoDiscapacitados = $("#accDiscapacitados").is(':checked') ? 1 : 0;
    $.ajax({
    	url: '../asignacionSalones/informeEspacios.php',
    	type: 'POST',
    	dataType: 'json',
    	data: {Fechas: fechas, HoraInicio:horaInicio, HoraFinal: horaFinal, AccesoDiscapacitados: accesoDiscapacitados},
    })
    .done(function(data) {
    	pintarInformeEspaciosOcupados(form, data);
    })
}
function informeEspaciosLibres(form){
   

     $('#actionID').val('SalonesLibres');
    $.ajax({//Ajax
          type: 'POST',
          url: '../asignacionSalones/SalonesDisponibles_html.php',
          async: false,
          dataType: 'html',
          data:$(form).serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
            console.log(data);
               $("#mostrarResultados").html(data);
          }  
    });
    
}
function pintarInformeEspaciosOcupados(form, listaSalonesOcupados){
	$.ajax({
		url: '../asignacionSalones/informeEspaciosOcupados.php',
		type: 'POST',
		dataType: 'json',
		data: {ListaSalonesOcupados: listaSalonesOcupados},
	})
	.done(function(data) {
		$(" #mostrarResultados").html(data);
	})
}

function pintarInformeEspaciosLibres(form, listaSalonesLibres){
	$.ajax({
		url: '../asignacionSalones/pintarInformeEspaciosLibres.php',
		type: 'POST',
		dataType: 'html',
		data: {ListaSalonesLibres: listaSalonesLibres},
	})
	.done(function(data) {
		$(" #mostrarResultadosEspaciosLibres").html(data);
	})
}
