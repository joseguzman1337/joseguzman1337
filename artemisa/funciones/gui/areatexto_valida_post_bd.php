<?php 
function areatexto_valida_post_bd($nombrevar,$validacion,$mensaje,$cols,$rows,$tablaexistente,$indicetablaexistente,$valorindicetablaexistente,$datotablaexistente){
$$tablaexistente = DB_DataObject::factory($tablaexistente);
$$tablaexistente->get($indicetablaexistente,$valorindicetablaexistente);
 ?>
<textarea name="<?php echo $nombrevar;?>" cols="<?php echo $cols;?>" rows="<?php echo $rows;?>" wrap="VIRTUAL"><?php echo $$tablaexistente->$datotablaexistente;?></textarea>
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
			if(!ereg("^[0-9]{0,20}$",$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "letras":
			if(!ereg("^[a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]*$",$_POST[$nombrevar]))
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
			if(!ereg($patron,$_POST[$nombrevar]))
			{
				$valido['mensaje']=$mensaje;
				$valido['valido'] = 0;
			}
			break;
		case "nombre":
			if(!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST[$nombrevar]))
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
		if($_POST[$nombrevar] < $fechamenos60)
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
			if(!ereg("^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$", $_POST[$nombrevar], $regs))
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
	}
//}
return $valido;
}
?>
