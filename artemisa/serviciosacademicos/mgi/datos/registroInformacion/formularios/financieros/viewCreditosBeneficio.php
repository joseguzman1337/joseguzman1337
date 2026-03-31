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




$query_categoria="select codigocarrera, nombrecarrera from carrera where codigomodalidadacademica = '".$_GET['modalidad']."' and codigocarrera not in (1,2)
    and now() between fechainiciocarrera and fechavencimientocarrera order by nombrecarrera";
$categoria= $db->Execute($query_categoria);
$totalRows_categoria= $categoria->RecordCount();

?>
<table align="center" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:80%">
        <thead>            
             <tr class="dataColumns">                 
                    
                    <th class="column" colspan="7" >Estudiantes que se han Beneficiado por Créditos</span></th>                    
             </tr>
             <tr class="dataColumns">
		    <th class="column">Programa</span></th>                    
                    <th class="column">Entidad Financiera</span></th>
                    <th class="column">Valor Entidad Financiera</span></th>
                    <th class="column">ICETEX</span></th>
                    <th class="column">Valor ICETEX</span></th>
                    <th class="column">Crédito de la Universidad</span></th>
                    <th class="column">Valor Crédito de la Universidad</span></th>
             </tr>	    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_ecreditobeneficio="select EntidadFinaciera,valorEntidad,icetex,valorIcetex,CreUniversidad,valorUniversidad from beneficiocredito 
	  where modalidadsic_id='".$_GET['modalidad']."'
	  and carrera_id='".$row_categoria['codigocarrera']."' 
	  and periodo='".$_GET['semestre']."'  
	  and codigoestado like '1%'";
	  $ecreditobeneficio= $db->Execute($query_ecreditobeneficio);
	  $row_ecreditobeneficio= $ecreditobeneficio->FetchRow();  
	  
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" ><?php echo $row_categoria['nombrecarrera']; ?></td>
	      <td class="column" ><?php echo $row_ecreditobeneficio['EntidadFinaciera']; ?></td>	      
	      <td class="column" ><?php echo $row_ecreditobeneficio['valorEntidad']; ?></td>	      
	      <td class="column" ><?php echo $row_ecreditobeneficio['icetex']; ?></td>
	      <td class="column" ><?php echo $row_ecreditobeneficio['valorIcetex']; ?></td>
	      <td class="column" ><?php echo $row_ecreditobeneficio['CreUniversidad']; ?></td>
	      <td class="column" ><?php echo $row_ecreditobeneficio['valorUniversidad']; ?></td>
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

<form action="" method="post" id="creditobeneficio" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre");?>
		
		
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademica, codigomodalidadacademica from modalidadacademica where codigomodalidadacademica in(200,300)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em' class="required">
		<option value=""></option>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
		<option value="<?php echo $row_tipomodalidad['codigomodalidadacademica']?>">
		<?php echo $row_tipomodalidad['nombremodalidadacademica']; ?>
		</option>
		<?php
		}
		?>
		</select>		
		
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='resCred' align="center"></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#creditobeneficio");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#resCred').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewCreditosBeneficio.php',
				async: false,
				data: $('#creditobeneficio').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#resCred').html(data);					
					
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
