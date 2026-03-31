<?php
/* USO:
 Primer parámetro: es la cadena que se quiere validar;
 Segundo parámetro: es el tipo de validacion que se quiere hacer;
 Tercer parámetro: es el mensaje que se quiere imprimir en caso de error;
 Cuarto parámetro: Si se quiere imprimir el mensaje se envía true, si no false;
  La función devuelve 0 o 1, según si la cadena validada es incorrecta o no.
*/

function validarPublicacion($fechaPublica, $fechaVence, $numDias, $mensaje="",$imprimir=true){
	$valido = 1;
	//echo "FECHA PUBLICA  ",$fechaPublica,"<br>";
	//echo "FECHA VENCE  ",$fechaVence,"<br>";	
	$fechasinformato = strtotime("+".$numDias."day",strtotime($fechaPublica));
	//echo "NUMERO DIAS  ",$numDias,"<br>";
	//echo "FECHA SIN FORMATO  ",$fechasinformato,"<br>";
	$fechaDiasN = date("Y-m-d",$fechasinformato);
	//echo "FECHA DIAS N  ",$fechaDiasN,"<br>";
	if($fechaVence > $fechaDiasN){
		$valido = 0;
	} 
	if(!$valido && $imprimir){
		echo $mensaje;
		$imprimir = false;
	}
	return $valido;
}

function obtenerFechaVence($fechaPublica, $fechaVence, $numDias){
	$valido = 1;
	//echo "FECHA PUBLICA  ",$fechaPublica,"<br>";
	//echo "FECHA VENCE  ",$fechaVence,"<br>";	
	$fechasinformato = strtotime("+".$numDias."day",strtotime($fechaPublica));
	//echo "NUMERO DIAS  ",$numDias,"<br>";
	//echo "FECHA SIN FORMATO  ",$fechasinformato,"<br>";
	$fechaDiasN = date("Y-m-d",$fechasinformato);
	//echo "FECHA DIAS N  ",$fechaDiasN,"<br>";
	return $fechaDiasN;
}

function validadosfechas($fecha1, $fecha2, $tipo, $mensaje="",$imprimir){
	$valido = 1;
	$fechasinformato1=strtotime("+0 day",strtotime($fecha1));
	//echo "Fecha sin formato1  ",$fechasinformato1;
	$fechasinformato2=strtotime("+0 day",strtotime($fecha2));
	//echo "Fecha sin formato2  ",$fechasinformato2;
	$fecha1_convertida=date("Y-m-d",$fechasinformato1);
	//echo "Fecha1 convertida", $fecha1_convertida;
	$fecha2_convertida=date("Y-m-d",$fechasinformato2);
	//echo "Fecha2 convertida", $fecha2_convertida;
	if($fecha2_convertida < $fecha1_convertida){
		$valido = 0;
	}
	if(!$valido && $imprimir){
		echo $mensaje;
		$imprimir = false;
	}
	return $valido;
}

function validar($cadena, $tipo, $mensaje="",$imprimir=true){
	$valido = 1;
	switch ($tipo){
		case "requerido":
			if($cadena == ''){
				$valido = 0;
			}
			break;
		case "hora":
			if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$cadena)){
				$valido = 0;
			}
			break;
		case "numero":
			if(!ereg("^[0-9]{0,20}$",$cadena)){
				$valido = 0;
			}
			break;
		case "letras":
			if(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$cadena)){
				$valido = 0;
			}
			break;
		case "email":
			$patron = "^[A-z0-9\._-]+"
						."@"
						."[A-z0-9][A-z0-9-]*"
						."(\.[A-z0-9_-]+)*"
						."\.([A-z]{2,6})$";
			if(!ereg($patron,$cadena)){
				$valido = 0;
			}
			break;
		case "nombre":
			if(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$cadena)){
				$valido = 0;
			}
			break;				
		case "ciudad":
			if(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ\.]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]+)*))*$",$cadena)){
				$valido = 0;
			}
			break;				
		case "combo":
			if($cadena == "0"){
				$valido = 0;
			}
			break;
		case "fechamayor":
			// Valida que la fecha sea mayor a la fecha de hoy
			if($cadena < date("Y-m-d")){
				$valido = 0;
			}
			break;				
		case "fecha":
			// Para fechas >= a 2000
			//$regs = array();
			if(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs)){
				$valido = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1])){
				$valido = 0;
			}
			break;				
		case "fechaant":
			// Para fechas < a 2000
			//$regs = array();
			if(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs)){
				$valido = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1])){
				$valido = 0;
			}
			break;
		case "porcentaje":
			if($cadena <= 0 || $cadena > 100){
				$valido = 0;
			}
			break;									
	}
	if(!$valido && $imprimir){
		echo $mensaje;
		$imprimir = false;
	}
	return $valido;
}
?>