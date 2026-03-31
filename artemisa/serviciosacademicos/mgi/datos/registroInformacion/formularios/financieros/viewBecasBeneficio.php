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
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">                 
                    
                    <th class="column" colspan="5" >Estudiantes que se han Beneficiado del Programa de Becas</span></th>                    
             </tr>
             <tr class="dataColumns">
		<?php if($_GET['modalidad']==200){ ?>
		    <th class="column">PROGRAMA</span></th>                    
                    <th class="column">EXCELENCIA ACADEMICA</span></th>
                    <th class="column">BECA MEJORES SABER 11</span></th>
                    <th class="column">BECA POBLACION VULNERABLE</span></th>
                    <th class="column">BECA MEJOR PROMEDIO COLEGIO BILINGÜE</span></th>
                 <?php 
                 }
                 elseif($_GET['modalidad']==300){
                 ?>
                 <th class="column">PROGRAMA</span></th>                    
                    <th class="column">BECA EGRESADOS</span></th>
                    <th class="column">BECA GRADO DE HONOR</span></th>
                    <th class="column">BECA GRADUADOS</span></th>
                    <th class="column">BECA POBLACION VULNERABLE</span></th>
                 <?php 
                 }
                 ?>
             </tr>	    
        </thead>
        <tbody>
        
	<?php
	
	while($row_categoria = $categoria->FetchRow()){
	
	  $query_ebecasbeneficio="select academica,poblaciones,grado,graduandos from becasbeneficio 
	  where modalidadsic_id='".$_GET['modalidad']."'
	  and carrera_id='".$row_categoria['codigocarrera']."' 
	  and periodo='".$_GET['semestre']."'  
	  and codigoestado like '1%'";
	  $ebecasbeneficio= $db->Execute($query_ebecasbeneficio);
	  $row_ebecasbeneficio= $ebecasbeneficio->FetchRow();  
	  
	  
	?>
	<tr class="contentColumns" class="row">
              <td class="column" ><?php echo $row_categoria['nombrecarrera']; ?></td>
	      <td class="column" ><?php echo $row_ebecasbeneficio['academica']; ?></td>	      
	      <td class="column" ><?php echo $row_ebecasbeneficio['poblaciones']; ?></td>	      
	      <td class="column" ><?php echo $row_ebecasbeneficio['grado']; ?></td>
	      <td class="column" ><?php echo $row_ebecasbeneficio['graduandos']; ?></td>
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

<form action="" method="post" id="becasbeneficio" class="report">
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
		<div id='resCNA'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#becasbeneficio");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#resCNA').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewBecasBeneficio.php',
				async: false,
				data: $('#becasbeneficio').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#resCNA').html(data);					
					
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
