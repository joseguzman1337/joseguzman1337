<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function lineainvestigacion($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=14;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			$titulo="LINEAS DE INVESTIGACION";
			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");
					

			/*MUESTRA INFORMACION DE DEDICACION EXTERNA*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			$fila["Periodo"]="";
			$fila["Linea_De_Investigacion"]="";
			$fila["Grupo_De_Investigacion"]="";		
			$fila["Facultad"]="";	
			$fila["Fecha_De_Ingreso"]="";
			$fila["Fecha_De_Termino"]="";

			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$condicion=" and d.codigoestado like '1%'
					and g.codigoestado like '1%'
					and l.codigoestado like '1%'
					and l.idlineainvestigacion=d.idlineainvestigacion
					and l.idgrupoinvestigacion=g.idgrupoinvestigacion
					and g.codigofacultad=f.codigofacultad";

			$resultado=$objetobase->recuperar_resultado_tabla("lineainvestigaciondocente d, lineainvestigacion l,grupoinvestigacion g,facultad f ","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
			echo "<tr>";		
			echo "<td valign='top'>";
			
			while($row=$resultado->fetchRow()){
				unset($fila);	
				$fila[]=$row["codigoperiodo"];
				$fila[]=$row["nombrelineainvestigacion"];
				$fila[]=$row["nombregrupoinvestigacion"];
				$fila[]=$row["nombrefacultad"];
				$fila[]=$row["fechaingresolineainvestigacion"];
				$fila[]=$row["fechaterminacionlineainvestigacion"];

				$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
			}


			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>
