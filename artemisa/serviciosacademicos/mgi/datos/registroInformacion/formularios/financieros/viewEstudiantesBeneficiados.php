<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();



/*if($_GET['codigomodalidadacademicasic']){


    $query_selcarrera = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademica = '".$_GET['codigomodalidadacademicasic']."' and codigocarrera not in (1,2)
    and now() between fechainiciocarrera and fechavencimientocarrera order by nombrecarrera";
    $selcarrera = $db->Execute($query_selcarrera);
    $totalRows_selcarrera = $selcarrera->RecordCount();
    
    while($row_selcarrera = $selcarrera->FetchRow())
    {
    
       $opciones.='<option value="'.$row_selcarrera["codigocarrera"].'">'.$row_selcarrera["nombrecarrera"].'</option>';
    }
     echo $opciones;
     
exit();     

}*/


if($_GET['modalidad'] && $_GET['semestre']) {




$query_categoria="select codigocarrera, nombrecarrera from carrera where codigomodalidadacademicasic = '".$_GET['modalidad']."' and codigocarrera not in (1,2)
    and now() between fechainiciocarrera and fechavencimientocarrera order by nombrecarrera";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

?>
<table align="center" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:80%">
        <thead>            
             <tr class="dataColumns">                 
                    
                    <th class="column" colspan="5" >Número de Estudiantes que se han Beneficiado de estas Modalidades</span></th>                    
             </tr>
             <tr class="dataColumns">
		    <th class="column">Programa</span></th>                    
                    <th class="column">Apoyos Económicos</span></th>
                    <th class="column">Estímulo por Participación en Eventos</span></th>
                    <th class="column">Estímulos para Egresados</span></th>
                    <th class="column">Estímulos para Aspirantes</span></th>
                    
             </tr>	    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_eestudiantebeneficio="select apoyos,paricipacion,egresados,aspirantes from estudiantebeneficio 
	  where modalidadsic_id='".$_GET['modalidad']."'
	  and carrera_id='".$row_categoria['codigocarrera']."' 
	  and periodo='".$_GET['semestre']."'  
	  and codigoestado like '1%'";
	  $eestudiantebeneficio= $db->Execute($query_eestudiantebeneficio);
	  $row_eestudiantebeneficio= $eestudiantebeneficio->FetchRow();  
	  
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" ><?php echo $row_categoria['nombrecarrera']; ?></td>
	      <td class="column" ><?php echo $row_eestudiantebeneficio['apoyos']; ?></td>	      
	      <td class="column" ><?php echo $row_eestudiantebeneficio['paricipacion']; ?></td>	      
	      <td class="column" ><?php echo $row_eestudiantebeneficio['egresados']; ?></td>
	      <td class="column" ><?php echo $row_eestudiantebeneficio['aspirantes']; ?></td>	      
	</tr>             
	<?php
	/*Fin del ciclo de categorias*/ 
	 }	 	 
	 ?>
        </tbody>        	
    </table>
<?php
exit();

}
?>

<form action="" method="post" id="estudiantebeneficio" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");?>
		
		
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigoestado =100";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em' class="required">
		<option value=""></option>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
		<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
		<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
		</option>
		<?php
		}
		?>
		</select>		
		
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='resBen' align="center"></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#estudiantebeneficio");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#resBen').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewEstudiantesBeneficiados.php',
				async: false,
				data: $('#estudiantebeneficio').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#resBen').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	/*$(document).ready(function(){
	  $("#modalidad").change(function(){
	      $.ajax({
		url:"./formularios/financieros/viewBecasBeneficio.php",
		type: "GET",
		data:"codigomodalidadacademicasic="+$("#modalidad").val(),
		success: function(opciones){
		  $("#carrera").html(opciones);
		}
	      })
	  });
	});*/
	
</script>
