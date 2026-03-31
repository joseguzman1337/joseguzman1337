<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
if($_SESSION['MM_Username']<>'admintecnologia'){
	echo "<h1>Usted no está autorizado para ver esta página";
	exit();
}

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>


<?php
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
$formulario->agregar_tablas('referenciaclaveusuario','idclaveusuario');

if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
if(isset($_GET['idusuario']) and $_GET['idusuario']!="")
{
	$formulario->cargar_distintivo('referenciaclaveusuario','idusuario',$_GET['idusuario']);
}
?>
<form name="form1" method="POST" action="">
<p>MANTENIMIENTO - REASIGNACION PREGUNTA SECRETA CLAVE USUARIO</p>
<input type="hidden" name="AnularOK" value="">
<strong>Datos Usuario</strong><br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_campotexto('preguntareferenciaclaveusuario','Pregunta secreta usuario','referenciaclaveusuario',40,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('repuestareferenciaclaveusuario','Respuesta secreta usuario','referenciaclaveusuario',40,'requerido');?>
</table>
<input type="submit" name="Enviar" value="Enviar">
<?php if($carga==true)
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>
<?php
if(isset($_REQUEST['Enviar']))
{
	//$formulario->agregar_datos_formulario('referenciaclaveusuario','repuestareferenciaclaveusuario',md5($_POST['repuestareferenciaclaveusuario']));
    $formulario->agregar_datos_formulario('referenciaclaveusuario','repuestareferenciaclaveusuario',hash('sha256', $_POST['repuestareferenciaclaveusuario']));
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>","<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>");
}
if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
?>
