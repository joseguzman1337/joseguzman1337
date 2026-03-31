<?php 
function campotexto_valida_get($nombrevar,$validacion,$mensaje,$tamano){ ?>
<input name="<?php echo $nombrevar;?>" type="text" id="<?php echo $nombrevar;?>" value="<?php echo $_GET[$nombrevar];?>" size="<?php echo $tamano;?>">
<?php 

$valido['valido'] = 1;

//if(isset($_GET[$nombrevar])){
	switch ($validacion)
	{
		case "requerido":
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "hora":
			if(!ereg("^([1]{1}[0-9]{1}|[2]{1}[0-3]{1}|[0]{0,1}[0-9]{1}):[0-5]{1}[0-9]{1}$",$_GET[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "numero":
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^[0-9]{0,20}$",$_GET[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
			
		case "porcentaje":
			if(!ereg("^[0-9]{0,20}$",$_GET[$nombrevar]) or $_GET[$nombrevar]== '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif($_GET[$nombrevar] < 0 ||  $_GET[$nombrevar] > 100)
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		break;
		case "letras":
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$_GET[$nombrevar]))
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
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg($patron,$_GET[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "nombre":
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_GET[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "combo":
			if($_GET[$nombrevar] == "0")
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "fecha":
			// Para fechas >= a 2000
			//$regs = array();
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^(2[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $_GET[$nombrevar], $regs))
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
		//echo $_GET[$nombrevar],$fechamenos60,fecha60;
		if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
		elseif($_GET[$nombrevar] < $fechamenos60)
		{
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		if ($_GET[$nombrevar] > $fecha60)
		{
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		break;


		case "fechaant":
			// Para fechas < a 2000
			//$regs = array();
			if($_GET[$nombrevar] == '')
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			elseif(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $_GET[$nombrevar], $regs))
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