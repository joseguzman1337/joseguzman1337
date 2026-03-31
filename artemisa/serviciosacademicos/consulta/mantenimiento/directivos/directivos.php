<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulariov2/clase_formulario.php');
$fechahoy=date("Y-m-d H:i:s");
$query="SELECT u.idusuario FROM usuario u WHERE u.usuario='".$_SESSION['MM_Username']."'";
$operacion=$sala->query($query);
$rowOperacion=$operacion->fetchRow();
$idusuario=$rowOperacion['idusuario'];
if(empty($idusuario)){
	echo "<h1>Error, no se puede continuar, sesión de usuario perdida</h1>";
	exit();
}
$formulario = new formulario(&$sala,"form1","post","",true,"directivos.php",false);
$formulario->jsCalendario();
$formulario->agregar_tablas('directivo','iddirectivo');
if(isset($_GET['iddirectivo']) and !empty($_GET['iddirectivo'])){
	$formulario->cargar('iddirectivo',$_GET['iddirectivo']);
}
?>
<strong>Edición de datos básicos de directivos</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo('codigocarrera','Carrera','carrera','directivo','codigocarrera','nombrecarrera','requerido','',"'$fechahoy' between fechainiciocarrera and fechavencimientocarrera",'nombrecarrera');?>
<?php $formulario->celda_horizontal_campotexto('nombrecortodirectivo','Nombre corto','directivo',20,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('numerodocumentodirectivo','Documento','directivo',20,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('apellidosdirectivo','Apellidos directivo','directivo',40,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('nombresdirectivo','Nombres directivo','directivo',40,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('cargodirectivo','Cargo directivo','directivo',40,'requerido');?>
<?php $formulario->celda_horizontal_calendario('fechainiciodirectivo','Fecha inicio','directivo','requerido');?>
<?php $formulario->celda_horizontal_calendario('fechavencimientodirectivo','Fecha vencimiento','directivo','requerido');?>
<?php $formulario->celda_horizontal_combo('codigotipodirectivo','Tipo de directivo','tipodirectivo','directivo','codigotipodirectivo','nombretipodirectivo','requerido','','','nombretipodirectivo');?>

</table>

<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
</form>

<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$formulario->agregar_datos_formulario('directivo','idusuario',$idusuario);
		$formulario->insertar("<script language='javascript'>window.close();window.opener.recargar();</script>","<script language='javascript'>window.close();window.opener.recargar();</script>");
	}
}
?>