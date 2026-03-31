<?php

   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
if(!isset($_SESSION['MM_Username'])){
	echo "<h1>Variable de sesión perdida, no se puede continuar</h1>";
	exit();
}
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulariov2/clase_formulario.php');
$fechahoy=date("Y-m-d H:i:s");

$queryDirectivos="SELECT d.iddirectivo, CONCAT(d.apellidosdirectivo,' ',d.nombresdirectivo) as nombre FROM directivo d ORDER BY nombre";
$directivos=$sala->query($queryDirectivos);
$rowDirectivos=$directivos->fetchRow();
do{
	$arrayDirectivos[]=$rowDirectivos;
}
while($rowDirectivos=$directivos->fetchRow());

$formulario = new formulario(&$sala,"form1","post","",true,"directivocertificado.php",false);
$formulario->jsCalendario();
$formulario->agregar_tablas('directivocertificado','iddirectivocertificado');
if(isset($_GET['iddirectivocertificado']) and !empty($_GET['iddirectivocertificado'])){
	$formulario->cargar('iddirectivocertificado',$_GET['iddirectivocertificado']);
}

?>
<strong>Edición de directivos que firman certificados</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo_array('iddirectivo','Directivo',$arrayDirectivos,'directivocertificado','iddirectivo','nombre','requerido','');?>
<?php $formulario->celda_horizontal_combo('idcertificado','Certificado','certificado','directivocertificado','idcertificado','nombrecertificado','requerido','','','nombrecertificado');?>
<?php $formulario->celda_horizontal_calendario('fechainiciodirectivocertificado','Fecha inicio caducidad firma','directivocertificado','requerido');?>
<?php $formulario->celda_horizontal_calendario('fechavencimientodirectivocertificado','Fecha final caducidad firma','directivocertificado','requerido');?>
<?php $formulario->celda_horizontal_combo('codigoestado','Estado','estado','directivocertificado','codigoestado','nombreestado','requerido','','','nombreestado');?>
</table>

<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
</form>

<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$formulario->insertar("<script language='javascript'>window.close();window.opener.recargar();</script>","<script language='javascript'>window.close();window.opener.recargar();</script>");
	}
}
?>