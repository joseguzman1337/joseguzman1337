<?php
function reconocimientos($objetobase,$formulario){
//echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=37;
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

	$condicion=" and r.codigoestado like '1%'
		and c.idciudad=r.idciudadreconocimientoestudiante
		and r.codigotiporeconocimientoestudiante=tp.codigotiporeconocimientoestudiante
		order by fechareconocimientoestudiante desc";
	//and tr.codigotiporeconocimientoestudiante=r.codigotiporeconocimientoestudiante
	$resultado=$objetobase->recuperar_resultado_tabla("reconocimientoestudiante  r,ciudad c,tiporeconocimientoestudiante tp","r.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		//$fila["Codigo"]="";
		$fila["Reconocimiento_Otorgado"]="";
		$fila["Tipo_Reconocimiento"]="";
		$fila["Ciudad"]="";
		$fila["Fecha_Reconocimiento"]="";


		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	while($row=$resultado->fetchRow()){
		unset($fila);
		/*$enlacedetalle="<a href='reconocimientoestudiante.php?idreconocimientoestudiante=".$row["idreconocimientoestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idreconocimientoestudiante"]."</a>";
		$fila[$enlacedetalle]="";*/
		$fila[$row["otorgareconocimientoestudiante"]]="";
		$fila[$row["nombretiporeconocimientoestudiante"]]="";
		$fila[$row["nombreciudad"]]="";
		$fila[$row["fechareconocimientoestudiante"]]="";

		$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");

	}

	echo "</table></td><tr>";	
	//echo "</table>";
}
?>