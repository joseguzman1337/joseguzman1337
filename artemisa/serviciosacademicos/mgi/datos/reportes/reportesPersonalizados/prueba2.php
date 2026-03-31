<?php
$dates["periodo_inicial"]=20111;
$dates["periodo_final"]=20131;

$codigoperiodoini=$dates["periodo_inicial"];
$codigoperiodofin=$dates["periodo_final"];


require_once('../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
/* Query rango de Periodo */
 $query_nomcarrera = "select codigoperiodo from periodo where codigoperiodo between '".$codigoperiodoini."' and '".$codigoperiodofin."'";
                $nomcarrera= $db->Execute($query_nomcarrera);
                $totalRows_nomcarrera = $nomcarrera->RecordCount();

/* Query Modalidad academica de la tabla modalidadacademicasic para sacar la asociacion como esta en el documento */
$query_modalidad="select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
$modalidad= $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
?>

<table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;">
        <thead>            
             <tr id="dataColumns">
                 
                    <th class="column" rowspan="2"><span>PROGRAMA</span></th>
		     <?php
			/*Recorrido de Consulta para imprimir los periodos*/
			$cue=1; 
			while($row_nomcarrera = $nomcarrera->FetchRow()){ 
			$array_periodo[$cue]=$row_nomcarrera['codigoperiodo'];
			$anioperiodo=substr($row_nomcarrera['codigoperiodo'],-1);			
			if($anioperiodo==1)
			$anioperiodo='I';
			else
			$anioperiodo='II';
			$anio=substr($row_nomcarrera['codigoperiodo'], 0, -1);			
			?>
			<th class="column" colspan="2"><?php echo $anioperiodo."  ".$anio; ?></span></th>
			 <?php
			$cue++;
			 } ?>
             </tr>
	     <tr id="dataColumns">
		<?php for($i=1; $i<= $totalRows_nomcarrera; $i++){
		/*ciclo para pintar los nombres de los items*/
		 ?>
		<th class="column"><span>Número de estudiantes admitidos por convenio de poblaciones especiales</span></th>
		<th class="column"><span>Número de estudiantes admitidos por convenio de estratos bajos</span></th>
		
		<?php	
		}
		 ?>
	    </tr>
        </thead>
        <tbody>
	<?php while($row_modalidad = $modalidad->FetchRow()){
	/*Inicio ciclo que pinta los bloques de modalidad*/
	 ?>
	 <tr id="contentColumns" class="row">
              <td class="column" colspan="50"><?php echo $row_modalidad['nombremodalidadacademicasic']; ?></td>       
         </tr>
	<?php 
	$query_carreras="select nombrecarrera, codigocarrera from carrera 
	where now() between fechainiciocarrera and fechavencimientocarrera
	and codigomodalidadacademicasic ='".$row_modalidad['codigomodalidadacademicasic']."'";
	$carreras= $db->Execute($query_carreras);
	$totalRows_carreras = $carreras->RecordCount();
	
	while($row_carreras = $carreras->FetchRow()){
	/*Inicio ciclo que pinta las carreras en la modalidad correspondiente*/
	?>
	<tr id="contentColumns" class="row">
              <td class="column"><?php echo $row_carreras['nombrecarrera']; ?></td>
         	
	<?php 	
	   for($j=1; $j<=$totalRows_nomcarrera; $j++){
		   $codigoperiodo=$array_periodo[$j];
	   /*ciclo para pintar los resultados de cadad carrera con respecto al item solicitado
	   En esta parte del codigo se utiliza la funcion de Obtener datos que es la misma que se utiliza en las estadisticas	
	  */
	  	    /*Query Estratos*/
	$query_estrato = "SELECT count(est.idestrato) as cantidad,e.codigocarrera
                FROM estudianteestadistica ee, carrera c, estudiante e, estudiantegeneral eg,
estratohistorico est, estrato es
                where e.idestudiantegeneral=eg.idestudiantegeneral
and est.idestudiantegeneral=eg.idestudiantegeneral and es.idestrato=est.idestrato
                and e.codigocarrera=c.codigocarrera
                and ee.codigoestudiante=e.codigoestudiante
                and ee.codigoperiodo =".$codigoperiodo."
                and e.codigocarrera=".$row_carreras['codigocarrera']."
                and ee.codigoprocesovidaestudiante= 400
                and ee.codigoestado like '1%'
and est.idestrato in(1,2)";
                $estrato= $db->Execute($query_estrato);
                $totalRows_estrato = $estrato->RecordCount();
                $row_estrato= $estrato->FetchRow();
               
               
               foreach ($row_estrato as $valor) { 
               echo"Imprime el array<pre>";
               print_r( $valor);
               echo"</pre>";
               
		   }
             
              /*Query Poblacion Especial*/
              $query_poblacion = "SELECT count(e.codigocarrera) as cantidad ,codigocarrera
                FROM estudiantepoblacionespecial ep, estudiante e 
where ep.codigoestudiante=e.codigoestudiante and ep.codigoperiodo=".$codigoperiodo." 
 and codigocarrera=".$row_carreras['codigocarrera'].";";
                $poblacion= $db->Execute($query_poblacion);
                $totalRows_poblacion = $poblacion->RecordCount();
                $row_poblacion= $poblacion->FetchRow() ;
	            //$total_poblacion=count($row_poblacion['cantidad']);
	             $totalRows_poblacion=0;
	            $totalestrato=0;
	            
	?>
	      <td class="column"><?php echo $row_poblacion['cantidad']; ?></td>
	      <td class="column"><?php echo $row_estrato['cantidad']; ?></td>
	      
	<?php
	
		}
			?>
	</tr>
<?php
/*fin del ciclo de carrera*/
	}
	?>
	<thead>
             <tr id="totalColumns">
                <td class="column total title">Total <?php echo $row_modalidad['nombremodalidadacademicasic']; ?></td>
		<?php
           for($k=1; $k<=$totalRows_nomcarrera; $k++){ 
			   
			   ?>	
              <td class="column total title" style="text-align:center"><?php echo $totalPoblacion[$j]['cantidad']; ?></td>
              <td class="column total title" style="text-align:center"><?php echo $totalEstratos[$j]['cantidad']; ?></td>
             
	  <?php
		
 
	   }
	  
	  ?>
            </tr>
        </thead>
	<?php
	/*Fin del ciclo de modalidades*/ 
	 }
	 ?>
        </tbody>        
	<tfoot>
             <tr id="totalColumns">
                <td class="column total title">Total</td>                
                <?php 
		for($l=1; $l<=$totalRows_nomcarrera; $l++){
		/*Ciclo total de totales*/
                
           	?> 
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['inscritos']; ?></td>
                    <td style="text-align:center"><?php echo $array_totaltotales[$l]['admitidos']; ?></td>
                    
		<?php 
		}
		?>
            </tr>
        </tfoot>
    </table>
