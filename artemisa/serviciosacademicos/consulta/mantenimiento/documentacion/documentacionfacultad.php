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
$formulario = new formulario($sala,"form1","post","",true,"documentacion.php",false);
$formulario->jsCalendario();
$formulario->agregar_tablas('documentacionfacultad','iddocumentacionfacultad');
if(isset($_GET['iddocumentacionfacultad']) and !empty($_GET['iddocumentacionfacultad'])){
	$formulario->cargar('iddocumentacionfacultad',$_GET['iddocumentacionfacultad']);
}
?>
<strong>Edición de documentación requerida por las facultades</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo('codigocarrera','Facultad','carrera','documentacionfacultad','codigocarrera','nombrecarrera','requerido','',"'$fechahoy' BETWEEN fechainiciocarrera AND fechavencimientocarrera",'nombrecarrera');?>
<?php $formulario->celda_horizontal_combo('iddocumentacion','Documento','documentacion','documentacionfacultad','iddocumentacion','nombredocumentacion','requerido','','','nombredocumentacion');?>
<?php $formulario->celda_horizontal_calendario('fechainiciodocumentacionfacultad','Fecha inicio','documentacionfacultad','requerido');?>
<?php $formulario->celda_horizontal_calendario('fechavencimientodocumentacionfacultad','Fecha vencimiento','documentacionfacultad','requerido');?>
<?php $formulario->celda_horizontal_combo('codigotipodocumentacionfacultad','Tipo documento','tipodocumentacionfacultad','documentacionfacultad','codigotipodocumentacionfacultad','nombretipodocumentacionfacultad','requerido','','','nombretipodocumentacionfacultad')?>
<?php $formulario->celda_horizontal_combo('codigogenerodocumento','Genero documento','generodocumento','documentacionfacultad','codigogenerodocumento','nombregenerodocumento','requerido','','','nombregenerodocumento');?>
<?php $formulario->celda_horizontal_combo('codigotipoobligatoridaddocumentacionfacultad','Obligatoriedad de documento','tipoobligatoridaddocumentacionfacultad','documentacionfacultad','codigotipoobligatoridaddocumentacionfacultad','nombretipoobligatoridaddocumentacionfacultad','requerido','','','nombretipoobligatoridaddocumentacionfacultad');?>
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