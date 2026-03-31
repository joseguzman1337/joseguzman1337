<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/debug/SADebug.php');
//require_once('../../../Connections/sap_ado_pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
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
$formulario->agregar_tablas('titulo','codigotitulo');

if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
if(isset($_GET['codigotitulo']) and $_GET['codigotitulo']!="")
{
	$formulario->cargar_distintivo('titulo','codigotitulo',$_GET['codigotitulo']);
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
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td colspan="2"><div align="center"><p>Datos carrera</p></div></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombretitulo','Título','requerido')?></td>
		<td><?php $formulario->campotexto('nombretitulo','titulo',30)?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechainiciotitulo','Fecha inicio','requerido')?></td>
		<td><?php $formulario->calendario('fechainiciotitulo','titulo',8);?></td>
	</tr><tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechafintitulo','Fecha final','requerido')?></td>
		<td><?php $formulario->calendario('fechafintitulo','titulo',8);?></td>
	</tr>
</table>
<input type="submit" name="Enviar" value="Enviar">
<input type="submit" name="Regresar" value="Regresar">
<?php if($carga==true)
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>
<?php
if(isset($_REQUEST['Enviar']))
{
	$formulario->array_datos_formulario[]=array('tabla'=>'titulo','campo'=>'registrotitulo','valor'=>1);
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>","<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
}
if(isset($_REQUEST['Regresar']))
{
	echo "<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>";
}
if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
?>
