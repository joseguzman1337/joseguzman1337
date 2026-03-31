<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulariov2/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
$fechahoy=date("Y-m-d H:i:s");

$queryIDusuario="SELECT idusuario FROM usuario u WHERE u.usuario = '".$_SESSION['MM_Username']."'";
$opIdusuario=$sala->query($queryIDusuario);
$rowIdUsuario=$opIdusuario->fetchRow();
$idusuario=$rowIdUsuario['idusuario'];
$formulario = new formulario(&$sala,"form1","post","",true,"pazysalvoegresado.php",false);
$ip=$formulario->tomarip();
$formulario->jsCalendario();
$formulario->agregar_tablas('pazysalvoegresado','idpazysalvoegresado');
if(isset($_GET['idpazysalvoegresado']) and !empty($_GET['idpazysalvoegresado'])){
	$formulario->cargar('idpazysalvoegresado',$_GET['idpazysalvoegresado']);
}
?>
<strong>Edición de documentación</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo('codigocarrera','Carrera','carrera','pazysalvoegresado','codigocarrera','nombrecarrera','requerido','',"'$fechahoy BETWEEN fechainiciocarrera AND fechavencimientocarrera'",'nombrecarrera');?>
<?php $formulario->celda_horizontal_calendario('fechadesdepazysalvoegresado','Fecha inicio caducidad','pazysalvoegresado','requerido')?>
<?php $formulario->celda_horizontal_calendario('fechahastapazysalvoegresado','Fecha inicio caducidad','pazysalvoegresado','requerido')?>
<?php ?>
</table>

<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
</form>

<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$formulario->agregar_datos_formulario('pazysalvoegresado','fechapazysalvoegresado',$fechahoy);
		$formulario->agregar_datos_formulario('pazysalvoegresado','idusuario',$idusuario);
		$formulario->agregar_datos_formulario('pazysalvoegresado','ip',$ip);
		$formulario->insertar("<script language='javascript'>window.close();window.opener.recargar();</script>","<script language='javascript'>window.close();window.opener.recargar();</script>");	}
}
?>