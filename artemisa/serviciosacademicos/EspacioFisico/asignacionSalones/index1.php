<?php
include("../templates/template.php");

$db = writeHeader('Reporte de Salones',true);
// $db = writeHeader("Formularios Asignaci&oacute;n Salones",true);
?>

    <link rel="stylesheet" type="text/css" href="./css/jquery.datetimepicker.css"/>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/jquery.datetimepicker.js"></script>
  	<link rel="stylesheet" type="text/css" href="./css/styleTablas.css">
	<div>
		<h1>Informe espacios disponibles</h1>
	</div>
 	<form name="salonesDisponibles" id="salonesDisponibles" action="">
		<div>
	        <label>Fecha Inicio:</label>
	        <input type="text" name="fechaInicio" id="fechaInicio" size="10"/>
	    </div>
	    <div>
			<label>Fecha Final: </label>
			<input type="text" name="fechaFinal" id="fechaFinal" value="" size="10"/>
		</div>
		<div>
	        <label>Hora Inicio:</label>
	        <input type="text" name="datetimepicker1" id="datetimepicker1" value="06:00" size="5"/>
	    </div>
	    <div>
			<label>Hora Final: </label>
			<input type="text" name="datetimepicker2" id="datetimepicker2" value="22:00" size="5"/>
		</div>
		<div>
			<label>D&iacute;a: </label>
			<select id="dia" name="dia" multiple size="7">
				<option value="1">Lunes</option>
				<option value="2">Martes</option>
				<option value="3">Miercoles</option>
				<option value="4">Jueves</option>
				<option value="5">Viernes</option>
				<option value="6">S&aacute;bado</option>
				<option value="7">Domingo</option>
			</select>
		</div>
		<div>
			<label>Acceso a discapacitados: </label>
			<input type="checkbox" name="accDiscapacitados" id="accDiscapacitados"><br>
		</div>
		<div>
			<input type="button" value="Buscar Espacios Ocupados" onclick="validar('#salonesDisponibles')"></input>
		</div>
    </form>
    <br>
    <div id="mostrarResultadosEspaciosLibres"></div>
    <div id="mostrarResultados"></div>

<script>
$('#fechaInicio').datetimepicker({
    lang:'es',
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
})
.datetimepicker({value:'',step:10});

$('#fechaFinal').datetimepicker({
    lang:'es',
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
})
.datetimepicker({value:'',step:10});

$('#datetimepicker1').datetimepicker({
    datepicker:false,
    format:'H:i',
    step:30
});

$('#datetimepicker2').datetimepicker({
    datepicker:false,
    format:'H:i',
    step:30
});
function validar(form){
    $.ajax({
      	url: './validar.php',
      	type: 'POST',
      	dataType: 'json',
      	data: $(form).serialize(),
      })
      .done(function(data) {
      	if (data.valida==true) {
        	$('#mostrarResultados').html("");
      		rangoFechas(form);
      	}else{
      		$(" #mostrarResultados").css('display','');
            $(" #mostrarResultados").html('<p>' + data.Error + '</p>');
            $(" #mostrarResultados").delay(900).fadeOut(1000);
      		alert(data.Error);
      	}
      })        
}
function rangoFechas(form){
	var fechaInicio=document.getElementById("fechaInicio").value;
	var fechaFinal=document.getElementById("fechaFinal").value;
	var items = [];
	$('#dia option:selected').each(function(){ items.push($(this).val()); });
	if (items.length === 0) {
		$('#dia').each(function(){ items.push("1","2","3","4","5","6","7") });
	}
	$.ajax({
		url: './calculoFechas.php',
		type: 'POST',
		dataType: 'json',
		data: {FechaInicio:fechaInicio, FechaFinal: fechaFinal ,dia:items},
	})
	.done(function(data) {
		if (data==null) {
			$(" #mostrarResultados").css('display','');
            $(" #mostrarResultados").html('<p>Error: No se encuentra información. Verifique las opciones anteriores.  </p>');
            $(" #mostrarResultados").delay(900).fadeOut(1000);
			alert("No se encuentra información");
		}else{
			// informeEspaciosOcupados(form, data);
			informeEspaciosLibres(form, data);
		}
	})	
}

function informeEspaciosOcupados(form, fechas){
    var horaInicio=document.getElementById("datetimepicker1").value+":00";
    var horaFinal=document.getElementById("datetimepicker2").value+":00";
    var accesoDiscapacitados = $("#accDiscapacitados").is(':checked') ? 1 : 0;
    $.ajax({
    	url: './informeEspacios.php',
    	type: 'POST',
    	dataType: 'json',
    	data: {Fechas: fechas, HoraInicio:horaInicio, HoraFinal: horaFinal, AccesoDiscapacitados: accesoDiscapacitados},
    })
    .done(function(data) {
    	pintarInformeEspaciosOcupados(form, data);
    })
}
function informeEspaciosLibres(form, fechas){
    var horaInicio=document.getElementById("datetimepicker1").value+":00";
    var horaFinal=document.getElementById("datetimepicker2").value+":00";
    var accesoDiscapacitados = $("#accDiscapacitados").is(':checked') ? 1 : 0;
    $.ajax({
    	url: './informeEspaciosLibres.php',
    	type: 'POST',
    	dataType: 'html',
    	data: {Fechas: fechas, HoraInicio:horaInicio, HoraFinal: horaFinal, AccesoDiscapacitados: accesoDiscapacitados},
    })
    .done(function(data) {
    	$(" #mostrarResultados").html(data);
    	// pintarInformeEspaciosLibres(form, data);
    })
}
function pintarInformeEspaciosOcupados(form, listaSalonesOcupados){
	$.ajax({
		url: './informeEspaciosOcupados.php',
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
		url: './pintarInformeEspaciosLibres.php',
		type: 'POST',
		dataType: 'html',
		data: {ListaSalonesLibres: listaSalonesLibres},
	})
	.done(function(data) {
		$(" #mostrarResultadosEspaciosLibres").html(data);
	})
}
</script>