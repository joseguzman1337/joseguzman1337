<?php
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();


 $meses = array();
  $meses[1] = "Enero";
  $meses[2] = "Febrero";
  $meses[3] = "Marzo";
  $meses[4] = "Abril";
  $meses[5] = "Mayo";
  $meses[6] = "Junio";
  $meses[7] = "Julio";
  $meses[8] = "Agosto";
  $meses[9] = "Septiembre";
  $meses[10] = "Octubre";
  $meses[11] = "Noviembre";
  $meses[12] = "Diciembre";

if($_GET['mes'] && $_GET['anio']) {
	$query="select	clasificacionesinfhuerfana
			,numeropublicaciones
		from siq_medioscomofdesarrollo
		join siq_clasificacionesinfhuerfana using(idclasificacionesinfhuerfana)
		where anio=".$_GET['anio']." and mes=".$_GET['mes'];
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
		<div id="msg-success" class="msg-success msg-error" ><p>No existe información para el mes de <?=$meses[$_REQUEST['mes']]?> en el año <?=$_REQUEST['anio']?></p></div>
<?
	} else {
?>

<table align="center" id="estructuraReporte" class="previewReport formData last" width="92%">
        <thead>            
             <tr class="dataColumns">                 
                    <th class="column" colspan="5"><span>Medios de comunicación corporativa</span></th> 
             </tr>
	     <tr class="dataColumns category">
		<th class="column" ><span>Tipo de Medio</span></th>
		<th class="column" ><span>Número de publicaciones </span></th>		
	    </tr>	    
        </thead>
	<tbody>
	 <?php 
	  while($row_conv1= $exec->FetchRow()){   
	  ?>
	 <tr id="contentColumns" class="row">
              <td class="column" ><?php echo $row_conv1['clasificacionesinfhuerfana']; ?></td>
	      <td class="column center" ><?php echo $row_conv1['numeropublicaciones']; ?></td>	      
	 </tr>
	<?php 
	}
	?>	
	</tbody>	
</table>
<?
	}
	exit;


}

?>


<form action="" method="post" id="form4">

	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Medios de Comunicación Corporativa</legend>		
		<label for="mes" class="grid-2-12">Mes: <span class="mandatory">(*)</span></label>
		<select name="mes" id="mes" style='font-size:0.8em'>
		<?php 
		for($mes=1; $mes<=12; $mes++){
		  if (date("m") == $mes){ ?>	
		    <option value="<?php echo $mes; ?>" selected><?php echo $meses[$mes]; ?></option>
		<?php 
		  }
		  else{ ?>
		    <option value="<?php echo $mes; ?>"><?php echo $meses[$mes]; ?></option>
		<?php 
		  }
		} ?>
		</select>
		<label for="anio" class="grid-2-12">Año: <span class="mandatory">(*)</span></label>
		<?php $utils->getYearsSelect("anio");  ?>
	<input type="submit" value="Consultar" class="first small"/>
		<div id='respuesta_form4'></div>
	</fieldset>
	
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form4");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: './formularios/docentes/viewOficinaDesarrolloMedios.php',
				async: false,
				data: $('#form4').serialize(),                
				success:function(data){					
					$('#respuesta_form4').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>