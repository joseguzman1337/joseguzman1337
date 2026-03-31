<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once('../../../funciones/clases/autenticacion/redirect.php');
if(!isset($_SESSION['MM_Username'])){
	echo "<h1>Variable de sesión perdida, no se puede continuar</h1>";
	exit();
}
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
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

$formulario = new formulario(&$sala,"form1","post","",true,"referenciafirmagrado.php",false);
$formulario->jsCalendario();
$formulario->agregar_tablas('referenciafirmagrado','idreferenciafirmagrado');
if(isset($_GET['idreferenciafirmagrado']) and !empty($_GET['idreferenciafirmagrado'])){
	$formulario->cargar('idreferenciafirmagrado',$_GET['idreferenciafirmagrado']);
}

?>
<strong>Edición de directivos que firman grado</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo_array('iddirectivo','Directivo',$arrayDirectivos,'referenciafirmagrado','iddirectivo','nombre','requerido','');?>
<?php $formulario->celda_horizontal_calendario('fechainicioreferenciafirmagrado','Fecha inicio caducidad firma','referenciafirmagrado','requerido');?>
<?php $formulario->celda_horizontal_calendario('fechafinalreferenciafirmagrado','Fecha final caducidad firma','referenciafirmagrado','requerido');?>
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