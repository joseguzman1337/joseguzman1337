<?php

function suma_fechas($fecha,$ndias)
            
 
{
            
 
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$año)=split("/", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
 
      return ($nuevafecha);  
            
 
}
 


	function validadosnumeros($numero1, $numero2, $tipo,$mensaje="",$imprimir=true)
	{
	$valido = 1;
	if($numero2 < $numero1)
	{
		$valido = 0;
	}
	if(!$valido && $imprimir)
	{
		echo $mensaje;
		$imprimir = false;
	}
	return $valido;
	}
	
function validafechaano($ano, $fecha1, $tipo, $mensaje="",$imprimir=true)
	{
	$valido = 1;
	$fechasinformato1=strtotime("+0 day",strtotime($fecha1));
	$fecha1_convertida=date("Y",$fechasinformato1);
	//echo "<h1>",$fecha1_convertida,"</h1><br>";
	//echo "<h1>",$ano,"</h1><br>";

	if($fecha1_convertida != $ano)
	{
		$valido = 0;
	}

	
	if(!$valido && $imprimir)
	{
		echo $mensaje;
		$imprimir = false;
	}
	//echo "<h1>",$valido,"</h1>";
	return $valido;
	}	
	

function validadosfechas($fecha1, $fecha2, $tipo, $mensaje="",$imprimir=true)
	{
	$valido = 1;
	$fechasinformato1=strtotime("+0 day",strtotime($fecha1));
	$fechasinformato2=strtotime("+0 day",strtotime($fecha2));
	$fecha1_convertida=date("Y-m-d",$fechasinformato1);
	$fecha2_convertida=date("Y-m-d",$fechasinformato2);
	//echo "<br>",$fecha1_convertida,"<br>",$fecha2_convertida,"<br>";
	if($fecha2_convertida < $fecha1_convertida)
	{
		$valido = 0;
	}
	if(!$valido && $imprimir)
	{
		echo $mensaje;
		$imprimir = false;
	}
	return $valido;
	}	
	
	function validar($cadena, $tipo, $mensaje="",$imprimir=true)
	{
		$valido = 1;
		switch ($tipo)
		{
			case "requerido":
				if($cadena == '')
				{
					$valido = 0;
				}
				break;
			case "hora":
				if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$cadena))
				{
					$valido = 0;
				}
				break;
			case "numero":
				if(!ereg("^[0-9]{0,20}$",$cadena))
				{
					$valido = 0;
				}
				break;
			case "letras":
				if(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$cadena))
				{
					$valido = 0;
				}
				break;
			case "email":
				$patron = "^[A-z0-9\._-]+"
							."@"
							."[A-z0-9][A-z0-9-]*"
							."(\.[A-z0-9_-]+)*"
							."\.([A-z]{2,6})$";
				if(!ereg($patron,$cadena))
				{
					$valido = 0;
				}
				break;
			case "nombre":
				if(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$cadena))
				{
					$valido = 0;
				}
				break;				
			case "combo":
				if($cadena == "0")
				{
					$valido = 0;
				}
				break;
			case "fecha":
				// Para fechas >= a 2000
				//$regs = array();
				if(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs))
				{
					$valido = 0;
				}
				if(!checkdate($regs[2],$regs[3],$regs[1]))
				{
					$valido = 0;
				}
				break;				
			case "fecha60": //fechas no mayores a 60 dias
				$fechahoy=date("Y-n-j");
				$fechasinformato=strtotime("+60 day",strtotime($fechahoy));
				$fecha60=date("Y-n-j",$fechasinformato);
				$fechasinformato2=strtotime("-60 day",strtotime($fechahoy));
				$fechamenos60=date("Y-n-j",$fechasinformato2);
				//echo $cadena,$fechamenos60,fecha60;
				if($cadena < $fechamenos60)
				{
					$valido = 0;
				} 
				if ($cadena > $fecha60)
				{
					$valido = 0;
				}
				break;
				
				
			case "fechaant":
				// Para fechas < a 2000
				//$regs = array();
				if(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs))
				{
					$valido = 0;
				}
				if(!checkdate($regs[2],$regs[3],$regs[1]))
				{
					$valido = 0;
				}
				break;
		}
		if(!$valido && $imprimir)
		{
			echo $mensaje;
			$imprimir = false;
		}
		return $valido;
	}
?>