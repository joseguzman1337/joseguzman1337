<?php

session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulariov2/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
$fechahoy=date("Y-m-d H:i:s");
$formulario = new formulario($sala,"form1","post","",'true');

$codigoestudiante=$_GET['codigoestudiante'];

$querySituacionActual="SELECT concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,sce.nombresituacioncarreraestudiante FROM estudiante e
INNER JOIN situacioncarreraestudiante sce ON e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante
INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
WHERE
e.codigoestudiante='$codigoestudiante'
";
$situacionActual=$sala->query($querySituacionActual);
$rowSituacionActual=$situacionActual->fetchRow();
?>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
	<td id="tdtitulogris">Estudiante:</td><td><?php echo $rowSituacionActual['nombre']?></td>
</tr>
<tr>
	<td id="tdtitulogris">Situación actual:</td><td><?php echo $rowSituacionActual['nombresituacioncarreraestudiante']?></td>
</tr>
</table>
<br>

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo('codigosituacioncarreraestudiante','Cambiar a:','situacioncarreraestudiante','','codigosituacioncarreraestudiante','nombresituacioncarreraestudiante','requerido','','','nombresituacioncarreraestudiante');?>
</table>
<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
<input type="button" name="Atras" value="Atras" onclick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php'">
</form>
<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$queryActualiza="UPDATE estudiante SET codigosituacioncarreraestudiante='".$_POST['codigosituacioncarreraestudiante']."' WHERE codigoestudiante='$codigoestudiante'";
		$act=$sala->query($queryActualiza);
		if($act){
			echo '<script language="javascript">alert("Situación estudiante actualizada correctamente");window.location.href="situacioncarreraestudiante.php?codigoestudiante='.$codigoestudiante.'"</script>';
		}
	}
}
?>

