<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function contrato($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=3;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			/*if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==''){
				$titulo="<input type='checkbox' onclick='selapruebadocente(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			}
			else{			
			
			}*/
			$titulo=strtoupper($datosformulario["nombreformulario"]);			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");
					

			/*MUESTRA INFORMACION DE DEDICACION EXTERNA*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

			$condicion=" and cd.idcontratodocente=dc.idcontratodocente and
			dc.codigocarrera=c.codigocarrera and
			tc.codigotipocontrato=cd.codigotipocontrato and 
			cb.codigocentrobeneficio=dc.codigocentrobeneficio and 
			tc.codigoestado like '1%' and
			cd.codigoestado like '1%' and 
			e.codigoescalafon=cd.codigoescalafon";

			$resultado=$objetobase->recuperar_resultado_tabla("contratodocente cd,tipocontrato tc,detallecontratodocente dc,carrera c,centrobeneficio cb,escalafon e","cd.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				$fila["Numero"]="";
				$fila["Horas_Por_Semana"]="";
				$fila["Tipo_Contrato"]="";
				$fila["Centro_Beneficio"]="";
				$fila["Carrera"]="";
				$fila["Fecha_Inicio"]="";
				$fila["Fecha_Final"]="";
				$fila["Escalafon"]="";
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
				$concontratos=0;
			while($row=$resultado->fetchRow()){
				$concontratos++;
				unset($fila);
				$enlacedetalle="<a href='contratodocente.php?iddetallecontratodocente=".$row["iddetallecontratodocente"]."&idcontratodocente=".$row["idcontratodocente"]."'>".$concontratos."</a>";
				//$fila[$enlacedetalle]="";
				$fila[$concontratos]="";
				$fila[$row["horasxsemanadetallecontratodocente"]]="";
				$fila[$row["nombretipocontrato"]]="";
				$fila[$row["nombrecentrobeneficio"]]="";
				$fila[$row["nombrecarrera"]]="";
				$fila[$row["fechainiciocontratodocente"]]="";
				$fila[$row["fechafinalcontratodocente"]]="";
				$fila[$row["nombreescalafon"]]="";
		
				$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");
				
			}	


			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>
