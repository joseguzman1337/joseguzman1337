<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function experiencialaboral($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=16;
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
					

			/*MUESTRA INFORMACION DE EXPERIENCIA LABORAL*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

			$condicion=" and d.codigoestado like '1%'
			and d.codigotipoexperiencialaboraldocente=te.codigotipoexperiencialaboraldocente
			and p.idprofesion=d.idprofesion";

			$resultado=$objetobase->recuperar_resultado_tabla("experiencialaboraldocente d,tipoexperiencialaboraldocente te,profesion p","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				$fila["Codigo"]="";
				$fila["Tipo_Experiencia"]="";
				$fila["Nombre_Institucion"]="";
				$fila["Tipo_Contrato"]="";
				$fila["Fecha_Final"]="";
				$fila["Horas_Dedicaci&oacute;n"]="";		
				$fila["Profesi&oacute;n"]="";		
				
		
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
				
			while($row=$resultado->fetchRow()){
				unset($fila);
				$enlacedetalle=$row["idexperiencialaboraldocente"];
				$fila[]=$enlacedetalle;
				$fila[]=$row["nombretipoexperiencialaboraldocente"];
				$fila[]=$row["nombreinstitucionexperiencialaboraldocente"];
				$fila[]=$row["tipocontratoexperiencialaboraldocente"];
				$fila[]=$row["fechafinalexperiencialaboraldocente"];
				$fila[]=$row["horasdedicacionexperiencialaboraldocente"] + 0;
				$fila[]=$row["nombreprofesion"];
				$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
				
			}	


			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>
