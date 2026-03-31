<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function actividadlaboral($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=17;
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
					

			/*Iteracion detalle materias docencia*/

		$condicion=" and d.codigoestado like '1%'
							and ta.codigotipoactividadlaboral=d.codigotipoactividadlaboral
							and c.codigocarrera=d.codigocarrera
							and d.codigotipoactividadlaboral='100'
							".$codigofacultadcondicion."
							order by c.codigocarrera";
		$datosactividadlaboraldocente=$objetobase->recuperar_datos_tabla("actividadlaboraldocente  d,tipoactividadlaboral ta,carrera c","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
		
			$condicion=" and d.codigoestado like '1%'
					and m.codigomateria=d.codigomateria
					and al.idactividadlaboraldocente=d.idactividadlaboraldocente";
		
			$resultado=$objetobase->recuperar_resultado_tabla("materiaactividadlaboraldocente d,materia m,actividadlaboraldocente al","al.iddocente",$_SESSION['sissic_iddocente'],$condicion,",al.codigoperiodo codigoperiodoactividad",0);
				
			while($row=$resultado->fetchRow()){
				unset($filadetalle);
				$enlacedetalle=$row["idmateriaactividadlaboraldocente"];
				$filadetalle[]=$row["codigoperiodoactividad"];
				$filadetalle[]=$enlacedetalle;
				$filadetalle[]=$row["nombremateria"];
				$filadetalle[]=$row["numerohorasmateriaactividadlaboraldocente"];
				$numerohorasdocencia+=$row["numerohorasmateriaactividadlaboraldocente"];		
				$arrayfiladetalle[]=$filadetalle;
			}



			/*MUESTRA INFORMACION DE DEDICACION EXTERNA*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			$fila["Periodo"]="";
			$fila["Tipo_Actividad"]="";
			$fila["Horas_Dedicadas"]="";
			$fila["Registrado_Por"]="";

if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==''){
$codigofacultadcondicion="";
}
else{
$codigofacultadcondicion="and c.codigocarrera=".$_SESSION["codigofacultad"];
}

			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$condicion=" and d.codigoestado like '1%'
					and ta.codigotipoactividadlaboral=d.codigotipoactividadlaboral
					and c.codigocarrera=d.codigocarrera
					group by d.codigotipoactividadlaboral,d.codigoperiodo 
					order by c.codigocarrera,d.codigoperiodo";

			$resultado=$objetobase->recuperar_resultado_tabla("actividadlaboraldocente  d,tipoactividadlaboral ta,carrera c","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,",d.codigoperiodo codigoperiodoactividad",0);
			echo "<tr>";		
			echo "<td valign='top'>";
			
			while($row=$resultado->fetchRow()){
				unset($fila);	
				$fila[]=$row["codigoperiodoactividad"];
				$fila[]=$row["nombretipoactividadlaboral"];
				if($row["codigotipoactividadlaboral"]=='100'){
					$row["numerohorasactividadlaboraldocente"]=$numerohorasdocencia;
				}
				$fila[]=$row["numerohorasactividadlaboraldocente"];
				if($row["codigocarrera"]=="1"){
					$fila[]="Docente";
				}
				else{
					$fila[]="Facultad";
				}

				$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
			}


			echo "</table></td><tr>";	
			echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
$formulario->dibujar_fila_titulo("ACTIVIDAD LABORAL DOCENCIA",'labelresaltado',"12","align='left'");

unset($fila);
				$fila["Periodo"]="";
				$fila["Codigo"]="";
				$fila["Materia"]="";
				$fila["Numero_Horas"]="";
		
				
		
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	if(is_array($arrayfiladetalle))
	foreach($arrayfiladetalle as $llave=>$filadetallei)
	{
		$formulario->dibujar_fila_texto($filadetallei,'','',"colspan=4","colspan=4");
	}
	echo "</table></td><tr>";	
	echo "</table>";
}
?>
