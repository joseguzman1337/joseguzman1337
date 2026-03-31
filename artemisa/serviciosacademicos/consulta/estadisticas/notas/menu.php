<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Menú principal listado promedio cortes de notas</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<?php
$depurar=false;
if(isset($_REQUEST['depurar']) and $_REQUEST['depurar']=='si')
{
	$depurar=true;
}
$formulario = new formulario($sala,"form1","post","",true,"menu.php",$depurar);
$formulario->jsVarios();
?>
<body>
Listado notas por corte
<form name="form1" method="POST" action="">
<?php
$array[]=array("accion"=>"Redimensionable","valor"=>"redimensionable");
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<?php $formulario->celda_horizontal_campotexto("semestre","Semestre","",5,"numero","");?>
	<?php $formulario->celda_horizontal_combo_array("redimensionable","Redimensionable",$array,"","valor","accion","","");?>
</table>
<?php
$formulario->Boton("Enviar","Enviar");
?>
</form>
</body>
</html>
<?php
if(isset($_POST['Enviar']))
{
	$valido=$formulario->valida_formulario();
	if($valido)
	{
		echo '<script language="javascript">reCarga("listado_notas_cortes.php?semestre='.$_POST['semestre'].'&link_origen=menu.php&'.$_POST['redimensionable'].'");</script>';
	}
}
//destruir objeto estadisticas si existe
if(isset($_SESSION['estadisticas']))
{
	unset($_SESSION['estadisticas']);
}
?>