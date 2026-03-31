<?php
/* USO:
 Primer parámetro: es la cadena que se quiere validar;
 Segundo parámetro: es el tipo de validacion que se quiere hacer;
 Tercer parámetro: es el mensaje que se quiere imprimir en caso de error;
 Cuarto parámetro: Si se quiere imprimir el mensaje se envía true, si no false;
 
 La funcón devuelve 0 o 1, según si la cadena validada es incorrecta o no.
*/
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
		}
		if(!$valido && $imprimir)
		{
			echo $mensaje;
			$imprimir = false;
		}
		return $valido;
	}
?>