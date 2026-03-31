<?php
	/*
	* Modificado Septiembre 11 del 2017
	* Cambio de la validacion del tipo de usuarop por tipo de rol
	*/
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	if($_SESSION['rol']<>'13')
	{
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
	<!--<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>-->
	<!--<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>-->
	<!--<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>-->
	<!--<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>-->
	<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php

	$fechahoy=date("Y-m-d H:i:s");
	$formulario=new formulario($sala,'form1','post','','true');
	$formulario->agregar_tablas('claveusuario','idclaveusuario');

	if($_REQUEST['depurar']=="si")
	{
		$formulario->depurar();
	}
	if(isset($_GET['idclaveusuario']) and $_GET['idclaveusuario']!="")
	{
		$formulario->cargar_distintivo('claveusuario','idclaveusuario',$_GET['idclaveusuario']);
	}
?>
	<form name="form1" method="POST" action="">
		<p>MANTENIMIENTO - REASIGNACION CLAVEUSUARIO</p>
		<input type="hidden" name="AnularOK" value="">
		<strong>Datos Usuario</strong><br>
		<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
			<?php $formulario->celda_horizontal_combo('idusuario','Usuario','usuario','claveusuario','idusuario','usuario','requerido','','','usuario');?>
			<?php $formulario->celda_horizontal_campotexto('claveusuario','Clave usuario','claveusuario',40,'requerido');?>
			<?php $formulario->celda_horizontal_combo('codigoestado','Estado','estado','claveusuario','codigoestado','nombreestado','requerido','','','nombreestado');?>
			<?php $formulario->celda_horizontal_combo('codigoindicadorclaveusuario','Indicador clave','indicadorclaveusuario','claveusuario','codigoindicadorclaveusuario','nombreindicadorclaveusuario','requerido','','','nombreindicadorclaveusuario');?>
			<?php $formulario->celda_horizontal_calendario('fechainicioclaveusuario','Fecha inicio','claveusuario','requerido','','','');?>
			<?php $formulario->celda_horizontal_calendario('fechavenceclaveusuario','Fecha inicio','claveusuario','requerido','','','');?>
			<?php $formulario->celda_horizontal_combo('codigotipoclaveusuario','Tipo clave','tipoclaveusuario','claveusuario','codigotipoclaveusuario','nombretipoclaveusuario','requerido','','','nombretipoclaveusuario','','');?>
		</table>
		<input type="submit" name="Enviar" value="Enviar">
		<?php 
		if($carga==true)
		{
			echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
		}
		?>
	</form>
<?php
	if(isset($_REQUEST['Enviar']))
	{
		if(!isset($_GET['idclaveusuario'])){
			$formulario->agregar_datos_formulario('claveusuario','fechaclaveusuario',$fechahoy);
		}

		if(($_POST['claveusuario']) <> $formulario->array_datos_cargados['claveusuario']->claveusuario){
			//$formulario->agregar_datos_formulario('claveusuario','claveusuario',md5($_POST['claveusuario']));
			$formulario->agregar_datos_formulario('claveusuario','claveusuario',hash('sha256', $_POST['claveusuario']));
		}
		$formulario->valida_formulario();
		$formulario->insertar("<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>","<script language='javascript'>alert('Datos actualizados correctamente');window.close();window.opener.recargar();</script>");
	}
	if($_REQUEST['depurar']=="si")
	{
		$formulario->depurar();
	}
?>