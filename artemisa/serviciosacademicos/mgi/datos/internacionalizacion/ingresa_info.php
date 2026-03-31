<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
require_once("../templates/template.php");
$db = writeHeader("Internacionalizacion",TRUE);
$utils = new Utils_datos();

?>
<form action="" method="post" id="form_procesa" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<legend>Estudiante Internacionalización Nuevo Registro</legend>
		<input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?=$_REQUEST['codigoestudiante']?>"/>
		<label class="grid-2-12"><span style="font-size:20px"><?=$_REQUEST['nombres']." ".$_REQUEST['apellidos']."<br>"?><br></span></label><br>				
		
		<label for="tipoestudiante" class="grid-2-12">Tipo Estudiantes: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipoest1 = "select idsituacionmovilidad, nombre from situacionmovilidad where idpadresituacionmovilidad is null and codigoestado=100";
		$tipoest1 = $db->Execute($query_tipoest1);
		$totalRows_tipoest1= $tipoest1->RecordCount();
		?>		
		<select name="tipoestudiante" id="tipoestudiante" style='font-size:0.8em' class="required">
		<option value=""></option>
		<?php while($row_tipoest1= $tipoest1->FetchRow()) {
		?>
		<option value="<?php echo $row_tipoest1['idsituacionmovilidad']?>">
		<?php echo $row_tipoest1['nombre']; ?>
		</option>
		<?php
		}
		?>
		</select>
		
		<label for="tiposituaestudiante" class="grid-2-12">Tipo Situación Estudiante: <span class="mandatory">(*)</span></label>		
		<select id="tiposituaestudiante" name="tiposituaestudiante" style='font-size:0.8em' class="required">
		<option value=""></option>
		</select>
		
		<div id='dibuja_otro'></div>
		<div class="vacio"></div>
		<label for="periodoinicial" class="grid-2-12">Periodo Inicio: <span class="mandatory">(*)</span></label>		
		<input type="text" minlength="5" class="required number" name="periodoinicial" id="periodoinicial" title="Periodo Inicial" tabindex="1" maxlength="5" autocomplete="off" /><span style="font-style:italic">(Ejm: 20112)</span>
		<?php //$utils->getSemestresSelect($db,"periodoinicial"); ?>
		
		<div class="vacio"></div>
		<label for="periodofinal" class="grid-2-12">Periodo Finalización: <span class="mandatory">(*)</span></label>
		<input type="text" minlength="5" class="required number" name="periodofinal" id="periodofinal" title="Periodo Final" tabindex="1" maxlength="5" autocomplete="off" /><span style="font-style:italic">(Ejm: 20132)</span>
		<?php //$utils->getSemestresSelect($db,"periodofinal"); ?>
		
		
		
	 
	<label><input type="submit" value="Grabar" id="guarda" class="first small"/><button type="button"   class="first small" id="regresa" >Regresar</button></label>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv' class=""></div>
	</fieldset>
	<fieldset id="historico">
		<legend>Historico Estudiante Internacionalización</legend>
		<?
		include("tabla_historico.php");
		?>
	</fieldset>
		
</form>
<script type="text/javascript">
	$("#guarda").click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_procesa");
		if(valido){
			sendForm();
		}
	});
	
	$("#regresa").click(function(event) {
		event.preventDefault();		
		window.location.href='menu_internacionalizacion.php';
	});
		
	function eliminar_dato(idestudiantesituacionmovilidad){
	
	  $.ajax({
		url:"carreras.php",
		type: "POST",
		data:"idestudiantesituacionmovilidad="+idestudiantesituacionmovilidad,
		success: function(opciones){
		  //$("#tiposituaestudiante").html(opciones);
		   
		  traer_datos_historicos();
		}
	      })
	
	}
	
	function modificar_dato(idestudiantesituacionmovilidad){	
	  
	  window.location.href='modificar_historico.php?idestudiantesituacionmovilidad='+idestudiantesituacionmovilidad;
	
	}
		
	function traer_datos_historicos(){
	
	  $.ajax({
		      url:"tabla_historico.php",
		      type: "POST",
		      data:"codigoestudiante="+$("#codigoestudiante").val(),
		      success: function(imprime_tabla){
		      $("#historico").html('<legend>Historico Estudiante Internacionalización</legend>'+imprime_tabla);  
		    }
		  })	
	
	}
	
	
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'POST',
				url: 'carreras.php',
				async: false,
				data: $('#form_procesa').serialize(),    
				dataType: 'json',
				success:function(data){
				    $('#tableDiv').attr('class','');
				    $('#tableDiv').css("display","block");
                                    $("#loading").css("display","none");//msg-success	
                                    $('#tableDiv').addClass(data.class);
			            $('#tableDiv').html(data.mensaje);
			            $('#tableDiv').delay(5500).fadeOut(800);
			            if(data.class=='msg-success'){
				      traer_datos_historicos();
			            }
			            
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	$(document).ready(function(){
	  $("#tipoestudiante").change(function(){
	      $.ajax({
		url:"carreras.php",
		type: "POST",
		data:"idsituacionmovilidad="+$("#tipoestudiante").val(),
		success: function(opciones){
		  $("#tiposituaestudiante").html(opciones);
		}
	      })
	  });
	});
	
	$(document).ready(function(){
	  $("#tiposituaestudiante").change(function(){
	      $.ajax({
		url:"carreras.php",
		type: "POST",
		data:"idsituacionmovilidad2="+$("#tiposituaestudiante").val(),
		success: function(opciones){		  
		  $('#dibuja_otro').html(opciones);
		}
	      })
	  });
	});
	
</script>


