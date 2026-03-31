<?php
function participacioninvestigacion($objetobase,$formulario){
//echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=33;
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
			and d.idlineainvestigacion=l.idlineainvestigacion
			and l.idgrupoinvestigacion=g.idgrupoinvestigacion
			and g.codigofacultad=f.codigofacultad";

	$resultado=$objetobase->recuperar_resultado_tabla("lineainvestigacionestudiante d,lineainvestigacion l,grupoinvestigacion g, facultad f","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		//$fila["Codigo"]="";
		$fila["Linea Investigación"]="";
		$fila["Grupo Investigación"]="";
		$fila["Facultad"]="";
		$fila["Fecha De Inicio"]="";
		//$fila["Fecha De Finalizacion"]="";
		

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"","");
		
	while($row=$resultado->fetchRow()){
		unset($fila);
		/*$enlacedetalle="<a href='lineainvestigacionestudiante.php?idlineainvestigacionestudiante=".$row["idlineainvestigacionestudiante"]."&idformulario=".$_GET["idformulario"]."&Nuevo_Registro=1&codigotipoactividadlaboral=200'>".$row["idlineainvestigacionestudiante"]."</a>";
		$fila[]=$enlacedetalle;*/
		$fila[]=$row["nombrelineainvestigacion"];
		$fila[]=$row["nombregrupoinvestigacion"];
		$fila[]=$row["nombrefacultad"];
		$fila[]=$row["fechaingresolineainvestigacion"];
		//$fila[]=$row["fechaterminacionlineainvestigacion"];

		$formulario->dibujar_fila_texto($fila,'','',"","");
		
	}	

	echo "</table></td><tr>";	
	//echo "</table>";
}
?>