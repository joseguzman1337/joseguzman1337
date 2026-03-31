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
$fechahoy=date("Y-m-d H:i:s");
$formulario = new formulario(&$sala,"form1","post","",true,"documentacion.php",false);
$formulario->jsCalendario();
$formulario->agregar_tablas('documentacion','iddocumentacion');
if(isset($_GET['iddocumentacion']) and !empty($_GET['iddocumentacion'])){
	$formulario->cargar('iddocumentacion',$_GET['iddocumentacion']);
}
?>
<strong>Edición de documentación</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_campotexto('nombredocumentacion','Nombre del documento','documentacion',40,'requerido');?>
</table>

<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
</form>

<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$formulario->insertar("<script language='javascript'>window.close();window.opener.recargar();</script>","<script language='javascript'>window.close();window.opener.recargar();</script>");	}
}
?>