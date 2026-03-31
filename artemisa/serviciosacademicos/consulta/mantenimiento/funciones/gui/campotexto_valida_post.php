<?php 
function campotexto_valida_post($nombrevar,$validacion,$mensaje,$tamano)
{ ?>
<input name="<?php echo $nombrevar;?>" type="text" id="<?php echo $nombrevar;?>" value="<?php echo $_POST[$nombrevar];?>" size="<?php echo $tamano;?>">
<?php 

$valido['valido'] = 1;

//if(isset($_POST[$nombrevar])){
	switch ($validacion)
	{
		case "requerido":
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "hora":
			if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "numero":
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^[0-9]{0,20}$",$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "porcentaje":
			if(!ereg("^[0-9]{0,20}$",$_POST[$nombrevar]) or $_POST[$nombrevar]== '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif($_POST[$nombrevar] < 0 || $_POST[$nombrevar] > 100)
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		break;
		
		case "porcentaje_negativo":
			if(!is_numeric($_POST[$nombrevar]) or $_POST[$nombrevar]== '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif($_POST[$nombrevar] > 100)
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		break;

		case "letras":
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "email":
			$patron = "^[A-z0-9\._-]+"
			."@"
			."[A-z0-9][A-z0-9-]*"
			."(\.[A-z0-9_-]+)*"
			."\.([A-z]{2,6})$";
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg($patron,$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "nombre":
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "combo":
			if($_POST[$nombrevar] == "0")
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
			
		case "fecha":
			// Para fechas >= a 2000
			//$regs = array();
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			if(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $_POST[$nombrevar], $regs))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			if(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;

		case "fecha60": //fechas no mayores a 60 dias
		$fechahoy=date("Y-n-j");
		$fechasinformato=strtotime("+60 day",strtotime($fechahoy));
		$fecha60=date("Y-n-j",$fechasinformato);
		$fechasinformato2=strtotime("-60 day",strtotime($fechahoy));
		$fechamenos60=date("Y-n-j",$fechasinformato2);
		//echo $_POST[$nombrevar],$fechamenos60,fecha60;
		if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		elseif($_POST[$nombrevar] < $fechamenos60)
		{
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		if ($_POST[$nombrevar] > $fecha60)
		{
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		break;


		case "fechaant":
			// Para fechas < a 2000
			//$regs = array();
			if($_POST[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $_POST[$nombrevar], $regs))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!checkdate($regs[2],$regs[3],$regs[1]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
	}
	if($valido['valido']==0)
	{
		echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
		<span class='Estilo99'>*</span>";
//	}
}
return $valido;
}
?>