<?php
session_start();
require_once('../../../Connections/sala2.php');
$rutaVistas = "./vistas";
require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php");
mysql_select_db($database_sala, $sala);
//print_r($_SESSION);

if(isset($_POST['Enviar']))
{
	//foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	//if($validaciongeneral==true)
	//{
		if(isset($_GET['codigoestudiante']))
		{
			echo '<script language="javascript">window.location.href="log_auditoria.php?fechainicio='.$_POST['fechainicio'].'&fechafinal='.$_POST['fechafinal'].'&codigoestudiante='.$_GET['codigoestudiante'].'"</script>';
		}
		else
		{
			echo '<script language="javascript">window.location.href="log_auditoria.php?fechainicio='.$_POST['fechainicio'].'&fechafinal='.$_POST['fechafinal'].'&codigocarrera='.$_POST['codigocarrera'].'"</script>';
		}
		
	/*}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}*/
}

require_once('../../../../funciones/gui/campotexto_valida_post.php');
$validaciongeneral=true;
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n';	

$queryDoF = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademica in (200,300) and fechavencimientocarrera>NOW() ";
$queryDoF = $queryDoF." order by nombrecarrera ASC";
	$regs = mysql_query($queryDoF,$sala);
	$programas = array();
	while ($row = mysql_fetch_assoc($regs)) {
		$selected=($_REQUEST["codigocarrera"]==$row["codigocarrera"])?"selected":"";
		$row["selected"]=$selected;
		$programas[]=$row;
	}

$template = $mustache->loadTemplate('menu_log_auditoria');

echo $template->render(array('title' => 'Log de Auditoría', 
						'programas' => $programas
						)
					);
?>
