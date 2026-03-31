<?php
function validaciongenerica($cadena, $tipo, $mensaje)
{
	echo "
		<style type='text/css'>
		<!--
			.Estilo99 
			{
			font-size: 18px;
			color: #FF0000;
			}
		-->
		</style>";
		
	$valido['valido'] = 1;
	switch ($tipo)
	{
		case "requerido":
			if($cadena == '')
			{
				$valido['valido'] = 0;
			}
			break;
		case "hora":
			if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$cadena))
			{
				$valido['valido'] = 0;
			}
			break;
		case "numero":
			if(!ereg("^[0-9]{0,20}$",$cadena))
			{
				$valido['valido'] = 0;
			}
			break;
			
		case "porcentaje":
			if(!ereg("^[0-9]{0,20}$",$cadena) or $cadena=='')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif($cadena < 0 || $cadena > 100)
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		break;
		case "letras":
			if(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$cadena))
			{
				$valido['valido'] = 0;
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
				$valido['valido'] = 0;
			}
			break;
			
		case "nombre":
			if(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$cadena))
			{
				$valido['valido'] = 0;
			}
			break;
			
		case "combo":
			if($cadena == "0")
			{
				$valido['valido'] = 0;
			}
			break;
			
		case "fecha":
			// Para fechas >= a 2000
			//$regs = array();
			if(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs))
			{
				$valido['valido'] = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido['valido'] = 0;
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
			$valido['valido'] = 0;
		}
		if ($cadena > $fecha60)
		{
			$valido['valido'] = 0;
		}
		break;


		case "fechaant":
			// Para fechas < a 2000
			//$regs = array();
			if(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $cadena, $regs))
			{
				$valido['valido'] = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido['valido'] = 0;
			}
			break;
	}
	
	if(!$valido['valido'])
	{
		echo "<span class='Estilo99'>*</span>";
		$valido['mensaje']=$mensaje;
	}
	return $valido;
}
?>