<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function estimulo($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=7;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==''){
				if($datosformulario["codigoestadodiligenciamiento"]=="200"){
					$checked="checked=true";
				}

				$titulo="<input type='checkbox' onclick='selapruebadocente(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			}
			else{			
				$titulo=strtoupper($datosformulario["nombreformulario"]);
			}			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");
					

			/*MUESTRA INFORMACION DE DEDICACION EXTERNA*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

			$fila["Titulo_Estimulo"]="";
			$fila["Institucion"]="";
			$fila["Tipo_De_Estimulo"]="";
			$fila["Tipo_De_Participacion"]="";
			$fila["Fecha_Finalizacion"]="";	
			$fila["Ciudad"]="";

			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$condicion=" and d.codigoestado like '1%'
					and tp.codigotipoestimulodocente=d.codigotipoestimulodocente
					and d.codigotipoparticipacionestimulodocente=te.codigotipoparticipacionestimulodocente
					and c.idciudad=d.idciudadestimulodocente";

			$resultado=$objetobase->recuperar_resultado_tabla("estimulodocente d,tipoestimulodocente tp,tipoparticipacionestimulodocente te,ciudad c","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
			echo "<tr>";		
			echo "<td valign='top'>";
			
			while($row=$resultado->fetchRow()){
				unset($fila);	
				$fila[]=$row["tituloestimulodocente"];
				$fila[]=$row["entidadestimulodocente"];
				$fila[]=$row["nombretipoestimulodocente"];
				$fila[]=$row["nombretipoparticipacionestimulodocente"];
				$fila[]=$row["fechaestimulodocente"];
				$fila[]=$row["nombreciudad"];
				$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
			}


			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>
