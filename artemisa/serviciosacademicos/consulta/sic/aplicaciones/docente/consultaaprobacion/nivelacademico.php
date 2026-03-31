<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function nivelacademico($objetobase,$formulario){

	echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/
			$idformulario=6;
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
					

			/*MUESTRA INFORMACION DEL NIVEL ACADEMICO*/
			echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
		
			$condicion=" and d.codigoestado like '1%'
				and d.idnucleobasicoareaconocimiento=na.idnucleobasicoareaconocimiento
				and d.codigotiponivelacademico=t.codigotiponivelacademico
				and d.idpais=p.idpais	
				and d.codigotiponivelacademico not in ('09','10','11','12','13')
				and d.codigotipoformacion=tf.codigotipoformacion
				and d.codigotipoformacion <> '400'";
			$resultado=$objetobase->recuperar_resultado_tabla("nivelacademicodocente d,tiponivelacademico t,nucleobasicoareaconocimiento na, pais p, tipoformacion tf","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
				$fila["Codigo"]="";
				$fila["Tipo_Formacion"]="";
				$fila["Nombre_Del_Programa"]="";
				$fila["Nombre_De_La_Instituci&oacute;n"]="";
				$fila["Tipo_De_Educacion"]="";
				$fila["Fecha_Final"]="";
				
		
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
				
			while($row=$resultado->fetchRow()){
				unset($fila);
				$enlacedetalle=$row["idnivelacademicodocente"];
				$fila[$enlacedetalle]="";
				$fila[$row["nombretipoformacion"]]="";
				$fila[$row["titulonivelacademicodocente"]]="";
				$fila[$row["institucionnivelacademicodocente"]]="";
				$fila[$row["nombretiponivelacademico"]]="";
				$fila[$row["fechafinalnivelacademicodocente"]]="";
		
				$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");
				
			}	
echo "</table>";
	echo "<form name=\"formtecnologiainformacion\" id=\"formtecnologiainformacion\" action=\"\" method=\"post\"  >
	<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">";


	$condicion=" and codigoestado like '1%'";
		$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",8,$condicion,"",0);

	$formulario->dibujar_fila_titulo("MANEJO DE TECNOLOGIAS DE LA INFORMACI&Oacute;N Y COMUNICACIONES",'labelresaltado',"2","align='left'");



		$tabla="tipotecnologiainformacion tt left join tecnologiainformaciondocente td on tt.codigotipotecnologiainformacion=td.codigotipotecnologiainformacion and td.codigoestado like '1%'
			and td.iddocente=".$_SESSION['sissic_iddocente']."  ";
		$condicion="";
		$resulttipoparticipa=$objetobase->recuperar_resultado_tabla($tabla,"tt.codigoestado","100",$condicion,",tt.codigotipotecnologiainformacion tipotecnologiainformacion",0);
		$i=0;
		$archivo="asignatipotecnologiainformacion.php";
		while($rowparticipa=$resulttipoparticipa->fetchRow()){

			$arrayparametroscajax[$i]["enunciado"]=$rowparticipa["nombretipotecnologiainformacion"];
			$arrayparametroscajax[$i]["nombre"]=$rowparticipa["tipotecnologiainformacion"];
			$arrayparametroscajax[$i]["valorsi"]="100";
			$arrayparametroscajax[$i]["valorno"]="200";
			if(isset($rowparticipa["idtecnologiainformaciondocente"])&&trim($rowparticipa["idtecnologiainformaciondocente"])!='')
			{
				$arrayparametroscajax[$i]["check"]="checked disabled";
			}
			else
			{
				$arrayparametroscajax[$i]["check"]="disabled";
			}
			$i++;

		}
		$formulario->dibujar_cajax_chequeos($arrayparametroscajax,$archivo,$tipoestilo='labelresaltado');


		echo "</table>";
	echo "</form></td><tr>";	
			
	echo "</table>";
}
?>
