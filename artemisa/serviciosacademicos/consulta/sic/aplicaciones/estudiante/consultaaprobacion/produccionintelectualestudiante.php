<?php
function publicaciones($objetobase,$formulario){
//echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=34;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formularioestudiante fd on f.idformulario=fd.idformulario and fd.idestudiantegeneral='".$_SESSION["sissic_idestudiantegeneral"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			if(validapertenenciaformulario($objetobase,$idformulario)){
				if($datosformulario["codigoestadodiligenciamiento"]=="200"){
					$checked="checked=true";
				}
				$titulo="<input type='checkbox' onclick='selapruebadocente(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			}
			else{			
				$titulo=strtoupper($datosformulario["nombreformulario"]);
			}		$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"4","align='left'");
					

			/*Iteracion detalle materias docencia*/

	$condicion=" and d.codigoestado like '1%'
			and d.codigotipoproduccionintelectual=t.codigotipoproduccionintelectual
			order by fechapublicacionproduccionintelectualestudiante desc";

	$resultado=$objetobase->recuperar_resultado_tabla("produccionintelectualestudiante d,tipoproduccionintelectual t","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		//$fila["Codigo"]="";
		$fila["Titulo del producto"]="";
		$fila["Tipo de producci&oacute;n"]="";
		$fila["Identificador producto"]="";
		$fila["Fecha de publicación"]="";




		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	while($row=$resultado->fetchRow()){
		unset($fila);
/*		$enlacedetalle="<a href='produccionintelectualestudiante.php?idproduccionintelectualestudiante=".$row["idproduccionintelectualestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idproduccionintelectualestudiante"]."</a>";
		$fila[]=$enlacedetalle;*/
		$fila[]=$row["nombreproduccionintelectualestudiante"];
		$fila[]=$row["nombretipoproduccionintelectual"];
		$fila[]=$row["numeroproduccionintelectualestudiante"];
		$fila[]=$row["fechapublicacionproduccionintelectualestudiante"];

		$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");

	}

	echo "</table></td><tr>";	
	//echo "</table>";
}
?>