<?php
/* USO:
 Primer parámetro: es la cadena que se quiere validar;
 Segundo parámetro: es el tipo de validacion que se quiere hacer;
 Tercer parámetro: es el mensaje que se quiere imprimir en caso de error;
 Cuarto parámetro: Si se quiere imprimir el mensaje se envía true, si no false;
 
 La función devuelve 0 o 1, según si la cadena validada es incorrecta o no.
*/
function validar($cadena, $tipo, $mensaje="",$imprimir=true,$año="")
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
			if(!preg_match("/^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$/",$cadena))
			{
				$valido = 0;
			}
			break;
		case "numero":
			if(!preg_match("/^[0-9a-zA-Z]{0,20}$/",$cadena))
			{
				$valido = 0;
			}
			break;
		case "letras":
			if(!preg_match("/^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$/",$cadena))
			{
				$valido = 0;
			}
			break;
		case "email":
			$patron = "/^[A-z0-9\._-]+"
						."@"
						."[A-z0-9][A-z0-9-]*"
						."(\.[A-z0-9_-]+)*"
						."\.([A-z]{2,6})$/";
			if(!preg_match($patron,$cadena))
			{
				$valido = 0;
			}
			break;
		case "nombre":
			if(!preg_match("/^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$/",$cadena))
			{
				$valido = 0;
			}
			break;				
		case "ciudad":
			if(!preg_match("/^([()a-zA-ZáéíóúüñÁÉÍÓÚÑÜ\.]+([()A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]*|( [()A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]+)*))*$/",$cadena))
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
		case "fechamayor":
			// Valida que la fecha sea mayor a la fecha de hoy
			if($cadena < date("Y-m-d"))
			{
				$valido = 0;
			}
			break;				
		case "fecha":
			// Para fechas >= a 2000
			//$regs = array();
			if(!preg_match("/^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$/",
                $cadena, $regs))
			{
				$valido = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido = 0;
			}
			break;				
		case "fechaant":
			// Para todas las fechas
			//$regs = array();
			if($año==""){
				$año = substr($cadena, 0, 1);
			}
			
			if(!preg_match("/^(".$año."[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$/",
                $cadena, $regs))
			{
				$valido = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido = 0;
			}
			break;
		case "porcentaje":
			if($cadena < 0 || $cadena > 100)
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

// Esta función se hizo para regresar al formulario inicial donde se genero el error	
function atras_validar($mensaje, $direccion="")
{
	if($direccion != "")
	{
?>
	<script language="javascript">
		alert("<?php echo $mensaje?>");
		window.location.reload("<?php echo $direccion; ?>");	
	</script>
<?php
	}
	else
	{
?>
	<script language="javascript">
		alert("<?php echo $mensaje?> aca");
		history.go(-1);	
	</script>
<?php
	}
}
?>