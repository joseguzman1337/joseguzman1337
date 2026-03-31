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
$formulario->agregar_tablas('usuario','idusuario');

if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
if(isset($_GET['idusuario']) and $_GET['idusuario']!="")
{
	$formulario->cargar_distintivo('usuario','idusuario',$_GET['idusuario']);
	//$formulario->limites_flechas_tabla_padre_hijo('carrera','jornadacarrera','codigocarrera','idjornadacarrera',$_GET['codigocarrera']);
	/*$maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
	if($maximo > 0)
	{
		$formulario->iterar_flechas_tabla_padre_hijo('idjornadacarrera',null);
		$carga=$formulario->cargar_distintivo('jornadacarrera','idjornadacarrera',$_SESSION['contador_flechas'],'','');
		$formulario->cambiar_estado('carrera','fechavencimientocarrera','0000-00-00',"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
		$formulario->resetear_objeto_para_asignar_nuevo_flechas('jornadacarrera',$carga);
	}*/

}
?>
<form name="form1" method="POST" action="">
<p>MANTENIMIENTO - TITULOS</p>
<input type="hidden" name="AnularOK" value="">
<strong>Datos Usuario</strong><br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_campotexto('usuario','Usuario','usuario',20,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('numerodocumento','Documento','usuario',20,'numero');?>
<?php $formulario->celda_horizontal_campotexto('tipodocumento','Tipo documento','usuario',5,'numero');?>
<?php $formulario->celda_horizontal_campotexto('apellidos','Apellidos','usuario',20,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('nombres','nombres','usuario',40,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('apellidos','Apellidos','usuario',40,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('codigousuario','Codigousuario','usuario',20,'requerido');?>
<?php $formulario->celda_horizontal_campotexto('semestre','Semestre','usuario',5,'');?>
<?php $formulario->celda_horizontal_campotexto('codigorol','Codigorol','usuario',5,'numero');?>
<?php $formulario->celda_horizontal_calendario('fechainiciousuario','Fecha inicio','usuario','requerido');?>
<?php $formulario->celda_horizontal_calendario('fechavencimientousuario','Fecha vencimiento','usuario','requerido');?>
<?php $formulario->celda_horizontal_combo('codigotipousuario','Tipo usuario','tipousuario','usuario','codigotipousuario','nombretipousuario','requerido','','','nombretipousuario');?>
<?php $formulario->celda_horizontal_campotexto('idusuariopadre','Idusuariopadre','usuario',5,'numero');?>
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
	
	$formulario->agregar_datos_formulario('usuario','fecharegistrousuario',$fechahoy);
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>","<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>");
}
if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
?>
