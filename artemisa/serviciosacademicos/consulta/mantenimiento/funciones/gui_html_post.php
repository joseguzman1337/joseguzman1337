<?php
function combo($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	//DB_DataObject::debugLevel(5);
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->whereADD($where);
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');

?>

 <select name="<?php echo $nombrevar?>" id="<?php echo $nombrevar?>" <?php echo $accion?>>
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $$nombreobjeto->$dato;?>"<?php 
              if(isset($_POST[$nombrevar]))
              {
              	if($_POST[$nombrevar] == $$nombreobjeto->$dato)
              	{
              		echo "selected";
              	}
              }
			  ?>><?php echo $$nombreobjeto->$etiqueta_dato;?></option>
              <?php
              } while ($$nombreobjeto->fetch());

?>
</select>
<?php 
//$valido['mensaje'] = "OK";
$valido['valido'] = 1;

if($validasino=='si'){
	//if(isset($_POST[$nombrevar])){
		if($_POST[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';  */
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
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		//print_r($valido);
	//}
}
return $valido;
} ?>



<?php 
function campotexto($nombrevar,$validacion,$mensaje){ ?>
<input name="<?php echo $nombrevar;?>" id="<?php echo $nombrevar;?>" type="text" value="<?php echo $_POST[$nombrevar];?>">
<?php 

$valido['valido'] = 1;

if(isset($_POST[$nombrevar])){
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
}
return $valido;
}
?>

<?php 
function areatexto($nombrevar,$validacion,$mensaje,$cols,$rows){ ?>
<textarea name="<?php echo $nombrevar;?>" cols="<?php echo $cols;?>" rows="<?php echo $rows;?>" wrap="VIRTUAL"><?php echo $_POST[$nombrevar];?></textarea>
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



<?php
function radios($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->whereADD($where);
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');
?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <?php do{ ?>
  <tr>
    <td><div align="center" class="Estilo1"><?php echo $$nombreobjeto->$etiqueta_dato;?></div></td>
    <td><input name="<?php echo $nombrevar;?>" <?php echo $accion?> type="radio" value="<?php echo $$nombreobjeto->$dato;?>" <?php if($_POST[$nombrevar]==$$nombreobjeto->$dato){echo "checked";}?>></td>
  </tr>
  <?php }  while ($$nombreobjeto->fetch());?>
</table>
<?php
$valido['valido'] = 1;
if($validasino=='si'){
	
		if($_POST[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';  */
			echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
		<div align = 'center'>
		<span class='Estilo99'>*</span>
		</div>
		";
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		//print_r($valido);
	
}
return $valido;
} ?>

<?php
function radios_horizontales($nombrevar,$nombreobjeto,$dato,$etiqueta_dato,$accion,$where,$validasino,$mensaje)
{
	$$nombreobjeto = DB_DataObject::factory($nombreobjeto);
	$$nombreobjeto->whereADD($where);
	$$nombreobjeto->orderBy($etiqueta_dato);
	$$nombreobjeto->get('','*');
?>

<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <?php do{ ?>
  
    <td><div align="center" class="Estilo1"><?php echo $$nombreobjeto->$etiqueta_dato;?></div></td>
    <td><input name="<?php echo $nombrevar;?>" <?php echo $accion?> type="radio" value="<?php echo $$nombreobjeto->$dato;?>" <?php if($_POST[$nombrevar]==$$nombreobjeto->$dato){echo "checked";}?>></td>
   <?php }  while ($$nombreobjeto->fetch());?>
   </tr>
</table>
<?php
$valido['valido'] = 1;
if($validasino=='si'){
	
		if($_POST[$nombrevar] == '')
		{
			/* echo '<script language="JavaScript">alert("'.$mensaje.'")</script>';  */
			echo "
		<style type='text/css'>
		<!--
			.Estilo99 {
			font-size: 18px;
			color: #FF0000;
					}
		-->
		</style>
		<div align = 'center'>
		<span class='Estilo99'>*</span>
		</div>
		";
			$valido['mensaje']=$mensaje;
			$valido['valido'] = 0;
		}
		//print_r($valido);
	
}
return $valido;
} ?>
