<?php

if($_GET['semestre']) {

require_once("../../../templates/template.php");
$db = getBD();
//$utils = new Utils_datos();

require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
$codigoperiodo = $_GET['semestre'];

$datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);	
/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
if($_GET['modalidad']!='todos'){
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic ='".$_GET['modalidad']."'";
}
else{
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
}
$modalidad= $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
//$start1 = microtime(true);

$query_cupos="SELECT codigocarrera, meta from obs_metas_matriculados where codigoperiodo='$codigoperiodo' and codigoestado=100";
//echo $query_cupos;
$array = $db->GetAll($query_cupos);
$cupos = array();
foreach ($array as $value) {
    $cupos[$value["codigocarrera"]] = $value["meta"];
}
//echo "<br/><pre>";print_r($cupos);
?>
<style type="text/css">
	/* Clase que tendra el tooltip */  
	.cssToolTip {
		position: relative; /* Esta clase tiene que tener posicion relativa */
	}
	/* El tooltip */
	.cssToolTip p {
                background: rgb(20,20,20);
		background: rgba(20,20,20,0.9); /*Decent browsers*/
                /* works for IE 5+. */
                filter:alpha(opacity=90); 
                /* works for IE 8. */
                -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
		border: 2px solid #fff;
		border-radius: 5px;
		box-shadow: 5px 5px 5px #333;
		color: #fff;
		display: none; /* El tooltip por defecto estara oculto */
		font-size: 0.8em;
		padding: 5px 5px 5px 5px;
		max-width: 100%;
                min-width: 150px;
		position: absolute; /* El tooltip se posiciona de forma absoluta para no modificar el aspecto del resto de la pagina */
		top: 40px; /* Posicion apartir de la parte superior del primer elemento padre con posicion relativa */
		left: 100px; /* Posicion apartir de la parte izquierda del primer elemento padre con posicion relativa */
		z-index: 100; /* Poner un z-index alto para que aparezca por encima del resto de elementos */
	}
 	/* El tooltip cuando se muestra */
	.cssToolTip:hover p {
		display: inline; /* Para mostrarlo simplemente usamos display block por ejemplo */
	}
</style>
<div class="tableDiv">
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:34%;"><span>PROGRAMA</span></th>
		     <?php
			$anioperiodo=substr($codigoperiodo,-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($codigoperiodo, 0, -1);			
			?>
			<th class="column" colspan="3" style="width:66%;text-align:center;"><?php echo $anio." - ".$anioperiodo; ?></span></th>
			
             </tr>
	     <tr class="dataColumns">	
		<th class="column" style="width:22%;"><span>NÚMERO DE MATRICULADOS NUEVOS</span></th>		
		<th class="column" style="width:22%;"><span><div class="cssToolTip">NÚMERO DE CUPOS<p>El n&uacute;mero de cupos hace referencia a la meta establecida para cada uno de los programas por la vicerrector&iacute;a acad&eacute;mica / administrativa.</p></div></span></th>
		<th class="column" style="width:22%;"><span>ÍNDICE DE VINCULACIÓN</span></th>
	    </tr>
        </thead>
        <tbody>
	<?php 
        while($row_modalidad = $modalidad->FetchRow()){
            $array_datostotales['sumanuevos']=0;	
            $array_datostotales['sumacupo']=0;
	/*Inicio ciclo que pinta los bloques de modalidad*/
            $matriculados=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos_modalidad_carrera('conteo',$row_modalidad["codigomodalidadacademicasic"]);	
           
         ?>
	 <tr class="contentColumns row dataColumns">
              <td class="column category" colspan="4" style="width:100%;"><b><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."' order by nombrecarrera";
	$carreras= $db->Execute($query_carreras);
	$totalRows_carreras = $carreras->RecordCount();
	
	while($row_carreras = $carreras->FetchRow()){
            
            /*ciclo para pintar los resultados de cadad carrera con respecto al item solicitado
	   En esta parte del codigo se utiliza la funcion de Obtener datos que es la misma que se utiliza en las estadisticas	*/
	  
	   //$total_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($row_carreras['codigocarrera'],'conteo');	   
	   //$query_cupos="SELECT cupo from siq_huerfana_cuposProgramaAcademico where codigocarrera='".$row_carreras['codigocarrera']."' and codigoperiodo='$codigoperiodo' and codigoestado=100";
           //$cupos= $db->Execute($query_cupos);
	   //$row_cupos = $cupos->FetchRow();
           
	   if(isset($cupos[$row_carreras['codigocarrera']])&&$cupos[$row_carreras['codigocarrera']]!=""){	
            $totalcupo=$cupos[$row_carreras['codigocarrera']];
	   }
	   else{
            $totalcupo=0;
	   }	
           
           if(isset($matriculados[$row_carreras['codigocarrera']])&&$matriculados[$row_carreras['codigocarrera']]!=""){	
            $total_matnuevo=$matriculados[$row_carreras['codigocarrera']];
	   }
	   else{
            $total_matnuevo=0;
	   }
	   //$total_matnuevo=count($array_matnuevo);
           if($total_matnuevo!=0 || $totalcupo!=0){ 
            $indicetres=$total_matnuevo/$totalcupo;
            //echo "<br/><br/><pre>";var_dump($datos_estadistica);
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/
	?>
	<tr class="contentColumns row">
              <td class="column" style="width:34%;"><?php echo $row_carreras['nombrecarrera']; ?></td>	      
	      <td class="column" style="text-align:center;width:22%;"><?php echo $total_matnuevo; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo $totalcupo; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo number_format($indicetres*100,2)."%"; ?></td>  	
	<?php 
	/*Acumuladores para los totales por modalidad academica	*/
	$array_datostotales['sumanuevos']=$total_matnuevo+$array_datostotales['sumanuevos'];	
	$array_datostotales['sumacupo']=$totalcupo+$array_datostotales['sumacupo'];
           
	?>
	</tr>
<?php
/*fin del ciclo de carrera*/
	}} if($array_datostotales['sumanuevos']!=0 || $array_datostotales['sumacupo']!=0){
	?>
             <tr class="dataColumns category">
                <th class="column total title" style="width:34%;"><b>Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></th>
		<?php
		/*Ciclo para pintar el total de cada modalidad academica*/		
           	$indicetotaltres=$array_datostotales['sumanuevos']/$array_datostotales['sumacupo'];
	   ?>              
              <th class="column total title" style="text-align:center;width:22%;" ><b><?php echo $array_datostotales['sumanuevos']; ?></b></th>             
              <th class="column total title" style="text-align:center;width:22%;" ><b><?php echo $array_datostotales['sumacupo']; ?></b></th>              
              <th class="column total title" style="text-align:center;width:22%;" ><b><?php echo number_format($indicetotaltres*100,2)."%"; ?></b></th>
	  <?php
		/*Acumuladores del total de todas las modalidades*/		    
	        $array_totaltotales['nuevos']=$array_datostotales['sumanuevos']+$array_totaltotales['nuevos'];	        
	        $array_totaltotales['cupo']=$array_datostotales['sumacupo']+$array_totaltotales['cupo'];
 
	   unset($array_datostotales)
	  ?>
            </tr>
	<?php
	/*Fin del ciclo de modalidades*/ 
        }}
	 ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
                <td class="column total title" style="width:34%;"><b>Total</b></td>                
                <?php 
		//for($l=1; $l<=$totalRows_nomcarrera; $l++){
		/*Ciclo total de totales*/                
                $indicetotaltotalestres=$array_totaltotales['nuevos']/$array_totaltotales['cupo'];
           	?>                     
                    <td style="text-align:center;width:22%;" ><b><?php echo $array_totaltotales['nuevos']; ?></b></td>                   
                    <td style="text-align:center;width:22%;"><b><?php echo $array_totaltotales['cupo']; ?></b></td>                    
                    <td style="text-align:center;width:22%;" ><b><?php echo number_format($indicetotaltotalestres*100,2)."%"; ?></b></td>
		<?php 
		//}
		?>
            </tr>
        </tfoot>
    </table>
<?php
//$end1 = microtime(true);
//$time = $end1 - $start1;
//echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');
exit();

}
?>   


<form action="" method="post" id="vinculacion" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php $utils->getSemestresSelect($db,"semestre"); ?>
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em'>
		<option value="todos">Todas</option>
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
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#vinculacion");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/estudiantes/viewReporteIndiceVinculacion.php',
				async: false,
				data: $('#vinculacion').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>    
    
    
