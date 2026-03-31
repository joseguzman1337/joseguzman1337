<?php

if($_GET['modalidad']) {

require_once("../../../templates/template.php");
$db = getBD();
//$utils = new Utils_datos();

require_once('../../../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
//$codigoperiodo = $_GET['semestre'];

/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
//$start1 = microtime(true);
$query_periodo="select * from periodo where codigoestadoperiodo=1";
$periodo= $db->Execute($query_periodo);
$totalRows_periodo = $periodo->RecordCount();
$row_periodo = $periodo->FetchRow();
$codigoperiodo = $row_periodo['codigoperiodo'];
$fechainicioperiodo=$row_periodo['fechainicioperiodo'];
$fechavenceperiodo=$row_periodo['fechavenciomientoperiodo'];

if($_GET['modalidad']!='todos'){
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic ='".$_GET['modalidad']."'";
}
else{
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
}
$modalidad= $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);	


$query_idioma="select * from idioma";
$idioma= $db->Execute($query_idioma);
$totalRows_idioma = $idioma->RecordCount();

	
?>
<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
        <thead>            
             <tr class="dataColumns">
                 
                    <th class="column" rowspan="2" style="width:34%;"><span>PROGRAMAS ACADÉMICOS</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$anioperiodo=substr($codigoperiodo,-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($codigoperiodo, 0, -1);			
			?>
			<th class="column" colspan="22" style="width:66%;text-align:center;">IDIOMAS QUE MANEJAN LOS ESTUDIANTES</span></th>
             </tr>
	     <tr class="dataColumns">		
		<th class="column" style="width:22%;"><span>NÚMERO DE ESTUDIANTES DEL PROGRAMA</span></th>
		<?php
		while($row_idioma = $idioma->FetchRow()){
		 $array_idioma[]= $row_idioma;
		?>
		<th class="column" style="width:22%;"><span><?php echo $row_idioma['nombreidioma']; ?></span></th>
		<th class="column" style="width:22%;"><span>Porcentaje</span></th>
		<?php
		}		
		?>
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){
                      
           /*Inicio ciclo que pinta los bloques de modalidad*/
	 ?>
	 <tr class="contentColumns row dataColumns">
              <td class="column category" colspan="22" style="width:100%;"><b><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."' order by nombrecarrera";
	$carreras= $db->Execute($query_carreras);
	//$totalRows_carreras = $carreras->RecordCount();
	while($row_carreras = $carreras->FetchRow()){
	$matriculados=$datos_estadistica->obtener_total_matriculados($row_carreras["codigocarrera"],'conteo');
			
	$total_matri=$matriculados+$total_matri;
	
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/       	    
	                          
	?>
	<tr class="contentColumns" class="row">
              <td class="column" style="width:34%;"><?php echo $row_carreras['nombrecarrera']; ?></td>
	      <td class="column" style="text-align:center;width:22%;"><?php echo $matriculados; ?></td>
	      <?php 
	      foreach($array_idioma as $nameidioma=>$valoridioma)
	      {	      
		$query_conteoest="select count(eg.idestudiantegeneral) total from estudiantegeneral eg
		  join estudiante e on e.idestudiantegeneral=eg.idestudiantegeneral
		  join estudianteestadistica ee on ee.codigoestudiante=e.codigoestudiante
		  join estudianteidioma ei on ei.idestudiantegeneral=eg.idestudiantegeneral and ei.codigoestado=100
		  join idioma i on i.ididioma=ei.ididioma
		  where e.codigocarrera = '".$row_carreras['codigocarrera']."'
		  and eg. fechaactualizaciondatosestudiantegeneral between '$fechainicioperiodo' and '$fechavenceperiodo'
		  and i.ididioma='".$valoridioma['ididioma']."'
		  and ee.codigoperiodo='$codigoperiodo'
		  and ee.codigoprocesovidaestudiante in(400,401)
		  and ee.codigoestado like '1%'";
		$conteoest= $db->Execute($query_conteoest);
		$row_conteoest = $conteoest->FetchRow();
		$valor1=$valoridioma['ididioma'];
		$calculoporcentaje=$row_conteoest['total']/$matriculados*100;
		$total_conteoestudiantes[$valor1]['conteoestudiante']=$row_conteoest['total']+$total_conteoestudiantes[$valor1]['conteoestudiante'];
		
		?>
		<td class="column" style="text-align:center;width:22%;"><?php echo $row_conteoest['total']; ?></td>              
              <td class="column" style="text-align:center;width:22%;"><?php echo round($calculoporcentaje,2)."%"; ?></td>    
		<?php
		}
		?>
	      
	</tr>
<?php //}//fin if
/*fin del ciclo de carrera*/
           }           
           
	?>
             <tr class="dataColumns category">
              <th class="column total title" style="width:34%;"><b>Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></b></th>			
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo $total_matri; ?></b></th>
              <?php
	      foreach($array_idioma as $nameidioma=>$valoridioma)
	      {
		/*Ciclo para pintar el total de cada modalidad academica*/		
           	       	$valor1=$valoridioma['ididioma'];
           	       	$totalindice=$total_conteoestudiantes[$valor1]['conteoestudiante']/$total_matri*100;
           	       	$total_totalesconteoestudiantes[$valor1]['conteoestudiante']=$total_conteoestudiantes[$valor1]['conteoestudiante']+$total_totalesconteoestudiantes[$valor1]['conteoestudiante'];
	   ?>
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo $total_conteoestudiantes[$valor1]['conteoestudiante']; ?></b></th>              
              <th class="column total title" style="text-align:center;width:22%;"><b><?php echo number_format($totalindice,2)."%"; ?></b></th>              
	  <?php
		}
		/*Acumuladores del total de todas las modalidades*/
		    $totaltotalesmat=$total_matri+$totaltotalesmat;
	         
 
	   unset($total_conteoestudiantes);
	   unset($total_matri);
	  ?>
            </tr>
	<?php
	/*Fin del ciclo de modalidades*/ 
	 }	 
	 ?>
        </tbody>        
	<tfoot>
             <tr class="totalColumns">
                <td class="column total title" style="width:34%;"><b>Total</b></td>                
                <?php 
	
		/*Ciclo total de totales*/                
                $indicetotaltotalesdos=$array_totaltotales['nuevos']/$array_totaltotales['admitidos'];                
           	?> 
                    <td style="text-align:center;width:22%;"><b><?php echo $totaltotalesmat; ?></b></td>
                    <?php
                    foreach($array_idioma as $nameidioma=>$valoridioma)
	      {
		/*Ciclo para pintar el total de cada modalidad academica*/		
           	       	$valor1=$valoridioma['ididioma'];
           	       	$indicedos=$total_totalesconteoestudiantes[$valor1]['conteoestudiante']/$totaltotalesmat*100;
           	       	?>
                    <td style="text-align:center;width:22%;"><b><?php echo  $total_totalesconteoestudiantes[$valor1]['conteoestudiante'];?></b></td>                    
                    <td style="text-align:center;width:22%;"><b><?php echo number_format($indicedos,2)."%"; ?></b></td>                    

                    <?php
                    
                    }
                    ?>
            </tr>
        </tfoot>
    </table>
<?php
/*$end1 = microtime(true);
$time = $end1 - $start1;
echo "<br/><br/>";echo('totales tardo '. $time . ' seconds to execute.');*/
exit();

}
?>

<form action="" method="post" id="segundoidioma" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		
		<!--<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
		<?php /*$utils->getSemestresSelect($db,"semestre"); */?>
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>-->		
		
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
		var valido= validateForm("#segundoidioma");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reportes/academicos/viewReporteEstudiantesSegundoIdioma.php',
				async: false,
				data: $('#segundoidioma').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
