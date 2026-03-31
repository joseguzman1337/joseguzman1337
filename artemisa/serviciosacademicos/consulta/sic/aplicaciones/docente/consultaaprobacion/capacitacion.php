<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION)
function capacitacion($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=15;
			$condicion=" and f.codigoestado like '1%'";
				$datosformulario=$objetobase->recuperar_datos_tabla("formulario f left join formulariodocente fd on f.idformulario=fd.idformulario and fd.iddocente='".$_SESSION["sissic_iddocente"]."'","f.idformulario",$idformulario,$condicion,"",0);
			
			$checked="";
			if($datosformulario["codigoestadodiligenciamiento"]=="300"){
				$checked="checked=true";
			}
			
			$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);
			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',"2","align='left'");
					

			/*MUESTRA INFORMACION DEL NIVEL ACADEMICO*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

			$fila["Titulo_Obtenido"]="";
			$fila["Area"]="";
			$fila["Nivel_Academico"]="";
			$fila["Fecha_Inicio"]="";
			$fila["Fecha_Finalizacion"]="";
			$fila["Pais"]="";
			$fila["En_curso"]="";

			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$condicion=" and d.codigoestado like '1%'
				and d.idnucleobasicoareaconocimiento=na.idnucleobasicoareaconocimiento
				and d.codigotiponivelacademico=t.codigotiponivelacademico
				and d.idpais=p.idpais	
				and d.codigotiponivelacademico  in ('09','10','11','12','13')";

			$resultado=$objetobase->recuperar_resultado_tabla("nivelacademicodocente d,tiponivelacademico t,nucleobasicoareaconocimiento na, pais p","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
			echo "<tr>";		
			echo "<td valign='top'>";
			
			while($row=$resultado->fetchRow()){
				unset($fila);	
				$fila[$row["titulonivelacademicodocente"]]="";
				$fila[$row["nombrenucleobasicoareaconocimiento"]]="";
				$fila[$row["nombretiponivelacademico"]]="";
				$fila[$row["fechainicionivelacademicodocente"]]="";
				$fila[$row["fechafinalnivelacademicodocente"]]="";
				$fila[$row["nombrepais"]]="";
				$encurso="No";
				if($row["encursonivelacademicodocente"]){
					$encurso="Si";
				}
				$fila[$encurso]="";
				$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");
			}

			echo "</table></td><tr>";	
			
	echo "</table>";
}
?>