<?
if($db==null){

require_once("../templates/template.php");
$db = writeHeader("Internacionalizacion",TRUE);
$utils = new Utils_datos();

}
?>         

<form action="" method="post" id="form_procesa" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>
		<legend>Modificar Estudiante Internacionalización</legend>
		
		<?php
		$query_datosreg = "select 
		  es.idestudiantesituacionmovilidad,
		  eg.nombresestudiantegeneral, 
		  eg.apellidosestudiantegeneral,
		  es.idsituacionmovilidad,
		  es.periodoinicial,
		  es.periodofinal,
		  e.codigoestudiante,
		  s.idpadresituacionmovilidad
		  from estudiantesituacionmovilidad es, situacionmovilidad s,estudiante e, estudiantegeneral eg
		  where es.idsituacionmovilidad=s.idsituacionmovilidad
		  and idestudiantesituacionmovilidad='".$_REQUEST['idestudiantesituacionmovilidad']."'
		  and e.codigoestudiante=es.codigoestudiante
		  and eg.idestudiantegeneral=e.idestudiantegeneral
		  and es.codigoestado =100";
		$datosreg = $db->Execute($query_datosreg);
		$totalRows_datosreg= $datosreg->RecordCount();
		$row_datosreg= $datosreg->FetchRow();
		
		if($row_datosreg['idpadresituacionmovilidad']!=1 && $row_datosreg['idpadresituacionmovilidad']!=2){		
		
		$query_elpapa = "select idpadresituacionmovilidad, nombre from situacionmovilidad where idsituacionmovilidad ='".$row_datosreg['idpadresituacionmovilidad']."' and codigoestado=100";
		$elpapa = $db->Execute($query_elpapa);
		$totalRows_elpapa= $elpapa->RecordCount();
		$row_elpapa= $elpapa->FetchRow();		
		$papa=$row_elpapa['idpadresituacionmovilidad'];
		$hijo_papa=$row_datosreg['idpadresituacionmovilidad'];
		$nieto=$row_datosreg['idsituacionmovilidad'];
		
		}
		else{
		$papa=$row_datosreg['idpadresituacionmovilidad'];
		$hijo_papa=$row_datosreg['idsituacionmovilidad'];
		}
		
		?>		
		
		<input type="hidden" name="codigoestudiante" id="codigoestudiante" value="<?=$row_datosreg['codigoestudiante']?>"/>
		
		<input type="hidden" name="idsitua" id="idsitua" value="<?=$_REQUEST['idestudiantesituacionmovilidad']?>"/>
		<label class="grid-2-12"><span style="font-size:20px"><?=$row_datosreg['nombresestudiantegeneral']." ".$row_datosreg['apellidosestudiantegeneral']."<br>"?><br></span></label><br>				
		
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
		    <option value="<?php echo $row_tipoest1['idsituacionmovilidad']?>"
		    <?
		    if($papa==$row_tipoest1['idsituacionmovilidad']){
		      echo "Selected";
		    }	
		    ?>>
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
		<input type="text" minlength="5" class="required number" name="periodoinicial" id="periodoinicial" title="Periodo Inicial" tabindex="1" maxlength="5" autocomplete="off"  value="<?=$row_datosreg['periodoinicial']?>"/><span style="font-style:italic">(Ejm: 20112)</span>
		<?php //$utils->getSemestresSelect($db,"periodoinicial"); ?>
		
		<div class="vacio"></div>
		<label for="periodofinal" class="grid-2-12">Periodo Finalización: <span class="mandatory">(*)</span></label>
		<input type="text" minlength="5" class="required number" name="periodofinal" id="periodofinal" title="Periodo Final" tabindex="1" maxlength="5" autocomplete="off" value="<?=$row_datosreg['periodofinal']?>"/><span style="font-style:italic">(Ejm: 20132)</span>
		<?php //$utils->getSemestresSelect($db,"periodofinal"); ?>
		
				
	 
	<label><input type="submit" value="Modificar" id="modificar" class="first small"/><button type="button"   class="first small" id="regresa" >Regresar</button></label>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv' class=""></div>
	</fieldset>	
		
</form>

<script type="text/javascript">

	/*function regresa_info(codigoestudiante,nombres,apellidos){	
	  
	  window.location.href='ingresa_info.php?codigoestudiante='+codigoestudiante+'&nombres='+nombres+'&apellidos='+apellidos;
	
	}*/
	
	$("#regresa").click(function(event) {
		event.preventDefault();		
		window.location.href='ingresa_info.php?codigoestudiante=<?php echo $row_datosreg['codigoestudiante'];?>&nombres=<?php echo $row_datosreg['nombresestudiantegeneral'];?>&apellidos=<?php echo $row_datosreg['apellidosestudiantegeneral'];?>';
	});


	$("#modificar").click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_procesa");
		if(valido){
			sendForm();
		}
	});
	
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
			            
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	
	
	$(document).ready(function(){
	
	  $.ajax({
		url:"carreras.php",
		type: "POST",
		data:"idsituacionmovilidad="+$("#tipoestudiante").val(),
		success: function(opciones){
		  $("#tiposituaestudiante").html(opciones);
		  $("#tiposituaestudiante").val("<?=$hijo_papa?>");
		      $.ajax({
		      url:"carreras.php",
		      type: "POST",
		      data:"idsituacionmovilidad2="+$("#tiposituaestudiante").val(),
		      success: function(opciones){		  
			$('#dibuja_otro').html(opciones);
			$("#tipodetallesituaestudiante").val("<?=$nieto?>");			
		      }
		    })
		}
	      })
	      
	   
	
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



