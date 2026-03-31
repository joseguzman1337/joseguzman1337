<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function idioma($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=8;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			$titulo="IDIOMAS";
			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");
					

			/*MUESTRA INFORMACION DE DEDICACION EXTERNA*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


			$fila["Idioma"]="";
			$resultadotipomanejo=$objetobase->recuperar_resultado_tabla("tipomanejoidioma","codigoestado","100"," order by idtipomanejoidioma","",0);
			while($rowmanejo=$resultadotipomanejo->fetchRow()){
				$fila[$rowmanejo["nombrecortotipomanejoidioma"]]="";
			}
	
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$condicion=" and d.codigoestado like '1%'
				and i.ididioma=d.ididioma";	
			$resultado=$objetobase->recuperar_resultado_tabla("idiomadocente d,idioma i","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				
			while($row=$resultado->fetchRow()){
				unset($fila);
		
				$fila[]=$row["nombreidioma"];
					$condicion=" left join detalleidiomadocente dt on tm.idtipomanejoidioma=dt.idtipomanejoidioma
					and dt.codigoestado like '1%'
					and dt.ididiomadocente=	".$row['ididiomadocente']."
					left join  indicadornivelidioma i				
					on i.idindicadornivelidioma=dt.idindicadornivelidioma
					";	
					$resultadodeatalle=$objetobase->recuperar_resultado_tabla("tipomanejoidioma tm    ".$condicion,"1","1"," order by tm.idtipomanejoidioma","",0);
					while($rowdetalle=$resultadodeatalle->fetchRow()){			
						$fila[]=$rowdetalle["nombreindicadornivelidioma"];
					}
					
		
				$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
				
			}	



			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>
