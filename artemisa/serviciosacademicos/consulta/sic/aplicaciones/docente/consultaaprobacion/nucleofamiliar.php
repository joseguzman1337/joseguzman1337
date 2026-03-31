<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function nucleofamiliar($objetobase,$formulario){

		echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=4;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			
			$titulo="NUCLEO FAMILIAR";
			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");

			$condicion=" on  tn.codigotiponucleofamiliadocente=n.codigotiponucleofamiliadocente and n.iddocente='".$_SESSION['sissic_iddocente']."'";
			$resultdatosnucleo=$objetobase->recuperar_resultado_tabla(" tiponucleofamiliadocente tn left join nucleofamiliadocente n ".$condicion." ","tn.codigoestado","100","",",tn.codigotiponucleofamiliadocente tiponucleo",0);
				echo "<tr>";		
				echo "<td valign='top'>";
				/*MUESTRA INFORMACION NUCLEO FAMILIAR*/
				echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

			unset($fila);
			while($rowdatosnucleo=$resultdatosnucleo->fetchRow()){			
					/*Fila n*/	
				$fila[$rowdatosnucleo["nombretiponucleofamiliadocente"]]="";
				$arraydatosnucleo[]=$rowdatosnucleo;
			}
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
			unset($fila);
	
			
			$rutaimagenchulo="../../../imagenes/ssuccess.png";
			$rutaimagenx="../../../imagenes/serror.png";
			foreach($arraydatosnucleo as $llave => $datosnucleo )	{
				if(!($datosnucleo["cantidadnucleofamiliadocente"]>0)||!isset($datosnucleo["cantidadnucleofamiliadocente"])||trim($datosnucleo["cantidadnucleofamiliadocente"])=="")
				{
					$imagen="<img id='imgtipo".$datosnucleo["tiponucleo"]."' name='imgtipo".$datosnucleo["nombretiponucleofamiliadocente"]."' src='".$rutaimagenx."' width='10' height='10'/>";
					$fila[$imagen]="";
				}
				else if($datosnucleo["tiponucleo"]=="200")
				{	
					$fila[$datosnucleo["cantidadnucleofamiliadocente"]]="";	
				}
				else
				{
					$imagen="<img id='imgtipo".$datosnucleo["tiponucleo"]."' name='imgtipo".$datosnucleo["nombretiponucleofamiliadocente"]."' src='".$rutaimagenchulo."' width='10' height='10'/>";
					$fila[$imagen]="";	
				}
			}		
			$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");


			echo "</table></td><tr>";	
		echo "</table>";
}
?>
