<?php
require_once("../../../templates/template.php");
$db = getBD();
$utils=new Utils_Datos();



if($_GET['codigomodalidadacademicasic']){


    $query_selcarrera = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademicasic = '".$_GET['codigomodalidadacademicasic']."' and codigocarrera not in (1,2)
    and now() between fechainiciocarrera and fechavencimientocarrera order by nombrecarrera";
    $selcarrera = $db->Execute($query_selcarrera);
    $totalRows_selcarrera = $selcarrera->RecordCount();
    
    while($row_selcarrera = $selcarrera->FetchRow())
    {
    
       $opciones.='<option value="'.$row_selcarrera["codigocarrera"].'">'.$row_selcarrera["nombrecarrera"].'</option>';
    }
     echo $opciones;
     
exit();     

}


if($_GET['modalidad'] && $_GET['carrera']) {

$query_ebeneficioP="select numespeciales,numbajos from poblacionespcialbajos 
	  where modalidad_id='".$_GET['modalidad']."'
	  and carrera_id='".$_GET['carrera']."' 
	  and periodo='".$_GET['semestre']."'  
	  and codigoestado like '1%'";
	  $ebeneficioP= $db->Execute($query_ebeneficioP);
	  $row_ebeneficioP= $ebeneficioP->FetchRow();  

?>

<table align="center" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:80%">
        <thead>            
             <tr class="dataColumns">                 
                    
                    <th class="column" colspan="2" >Estudiantes Admitidos por Programas y Convenios de Poblaciones Especiales y Estratos Bajos</span></th>                    
             </tr>
             <tr class="dataColumns">
		    <th class="column">N° de estudiantes admitidos por convenio de poblaciones especiales</span></th>                    
                    <th class="column">N° de estudiantes admitidos por convenio de estratos bajos</span></th>                    
                    
             </tr>	    
        </thead>
        <tbody>       
	
	<tr class="contentColumns" class="row">
              <td class="column" align="center"><b><?php echo $row_ebeneficioP['numespeciales']; ?></b></td>
	      <td class="column" align="center"><b><?php echo $row_ebeneficioP['numbajos']; ?></b></td>	      	      	      
	</tr>             	
        </tbody>        	
    </table>
<?php
exit();

}
?>

<form action="" method="post" id="beneficioP" class="report">
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
		
		<label for="carrera" class="grid-2-12">Programa Academico: <span class="mandatory">(*)</span></label>		
		<select id="carrera" name="carrera" style='font-size:0.8em'>
		<option value="todasc"></option>
		</select>
		
		
	
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='ResPob' align="center"></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#beneficioP");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#ResPob').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './formularios/financieros/viewPoblacion.php',
				async: false,
				data: $('#beneficioP').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#ResPob').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	$(document).ready(function(){
	  $("#modalidad").change(function(){
	      $.ajax({
		url:"./formularios/financieros/viewPoblacion.php",
		type: "GET",
		data:"codigomodalidadacademicasic="+$("#modalidad").val(),
		success: function(opciones){
		  $("#carrera").html(opciones);
		}
	      })
	  });
	});
	
</script>
