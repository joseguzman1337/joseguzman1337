<?php
function participacionacademica($objetobase,$formulario){
//echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=35;
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
		and te.codigotipoparticipacionacademicaestudiante=d.codigotipoparticipacionacademicaestudiante
		and te.codigoestado like '1%'
		and d.codigoestado like '1%'
		order by fechaparticipacionacademicaestudiante desc";

	$resultado=$objetobase->recuperar_resultado_tabla("participacionacademicaestudiante  d,tipoparticipacionacademicaestudiante te","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		//$fila["Codigo"]="";
		$fila["Participación"]="";
		$fila["Institución"]="";
		$fila["Tipo_Participación"]="";
		$fila["Fecha_De_Actividad"]="";
		


		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"","");

	while($row=$resultado->fetchRow()){
		unset($fila);
		//$enlacedetalle=$row["idparticipacionacademicaestudiante"];
		//$fila[]=$enlacedetalle;
		$fila[]=$row["tituloparticipacionacademicaestudiante"];
		$fila[]=$row["entidadparticipacionacademicaestudiante"];
		$fila[]=$row["nombretipoparticipacionacademicaestudiante"];
		$fila[]=$row["fechaparticipacionacademicaestudiante"];

		$formulario->dibujar_fila_texto($fila,'','',"","");

	}

	echo "</table></td><tr>";	
	//echo "</table>";
}
?>