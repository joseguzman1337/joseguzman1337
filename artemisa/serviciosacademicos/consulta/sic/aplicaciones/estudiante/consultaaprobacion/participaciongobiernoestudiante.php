<?php
function participaciongobierno($objetobase,$formulario){
//echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=36;
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
					

	$condicion=" and d.codigoestado like '1%'
			and d.codigotipoparticipaciongobiernoestudiante=tp.codigotipoparticipaciongobiernoestudiante";

	$resultado=$objetobase->recuperar_resultado_tabla("participaciongobiernoestudiante d,tipoparticipaciongobiernoestudiante tp ","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		//$fila["Codigo"]="";
		$fila["Tipo de Participación"]="";
		$fila["Fecha de inicio Participación"]="";
		//$fila["Fecha terminaci&oacute;n en escalafon"]="";

		

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"","");
		unset($fila);
	while($row=$resultado->fetchRow()){
		unset($fila);
		/*$enlacedetalle="<a href='participaciongobiernoestudiante.php?idparticipaciongobiernoestudiante=".$row["idparticipaciongobiernoestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idparticipaciongobiernoestudiante"]."</a>";
		$fila[]=$enlacedetalle;*/
		$fila[]=$row["nombretipoparticipaciongobiernoestudiante"];				$fila[]=$row["fechainicioparticipaciongobiernoestudiante"];
		//$fila[]=$row["fechafinalizacionescalafondocente"];

		$formulario->dibujar_fila_texto($fila,'','',"","");
		
	}	

	echo "</table></td><tr>";	
	//echo "</table>";
}
?>