<?php 
	function validafallas ($codigomateria,$idgrupo,$codigoestudiante,$sala)
	 {
       // Query que trae la cantidad de actividades digitadas por el docente.
	   
	   $query_actividades ="select sum(actividadesacademicasteoricanota) as teoria, sum(actividadesacademicaspracticanota) as practica
	   from nota n,grupo g
	   where n.idgrupo = g.idgrupo
	   and g.idgrupo = '$idgrupo'";		  
	  // echo $query_actividades;
	   $actividades = mysql_query($query_actividades, $sala) or die(mysql_error());
	   $row_actividades = mysql_fetch_assoc($actividades);
	   $totalRows_actividades = mysql_num_rows($actividades);
	   
	   // Query que trae las fallas totales del estudiante
	   
	   $query_fallas ="select sum(numerofallasteoria) as fallasteoria, sum(numerofallaspractica) as fallaspractica
	   from detallenota n
	   where idgrupo = '$idgrupo'
	   and codigoestudiante = '$codigoestudiante'";		  
	   $fallas = mysql_query($query_fallas, $sala) or die(mysql_error());
	   $row_fallas = mysql_fetch_assoc($fallas);
	   $totalRows_fallas = mysql_num_rows($fallas);
        
	   // Query que trae el los porcentajes de las fallas de la materia	
		
	   $query_porcent ="select porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria
	   from materia
	   where codigomateria = '$codigomateria'";		  
	   $porcent = mysql_query($query_porcent, $sala) or die(mysql_error());
	   $row_porcent = mysql_fetch_assoc($porcent);
	   $totalRows_porcent = mysql_num_rows($porcent);
	
	   $calculofallasteoria   = 0;
	   $calculofallaspractica = 0;
	  $calculofallasteoria   = ($row_porcent['porcentajefallasteoriamodalidadmateria']   * $row_actividades['teoria'])  / 100;
	    $calculofallaspractica = ($row_porcent['porcentajefallaspracticamodalidadmateria'] * $row_actividades['practica'])/ 100;
		//echo $calculofallaspractica." (".$row_porcent['porcentajefallaspracticamodalidadmateria']."  * ".$row_actividades['practica'].")  / 100;";
	//   $calculofallasteoria   = round($calculofallasteoria);
	//   $calculofallaspractica = round($calculofallaspractica); 
		   
		  //   if ($codigoestudiante == '23324' and $codigomateria == '1952')
			//{
			  //echo $query_actividades,"<br>";
			//  echo "'".$row_fallas['fallasteoria']."',> $calculofallasteoria  or  ,'".$row_fallas['fallaspractica']."' , >	 $calculofallaspractica  ";
			 // exit();
//			}  
	
	   unset($arreglo_perdieron);
	   if (($row_fallas['fallasteoria'] > $calculofallasteoria or $row_fallas['fallaspractica'] > $calculofallaspractica ))
	    {
		  $arreglo_perdieron = array($codigomateria,$codigoestudiante,$row_fallas['fallasteoria'],$row_fallas['fallaspractica'],$row_actividades['teoria'],$row_actividades['practica']);
		  return $arreglo_perdieron;
		} 
	   return false;
	 }	 
?>
