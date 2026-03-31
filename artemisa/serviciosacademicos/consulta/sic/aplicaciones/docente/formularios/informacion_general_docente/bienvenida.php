<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">BIENVENIDO</legend>
		<div id="bienvenida">
		<p align="justify">Respetado profesor, solicitamos su valiosa colaboraci&oacute;n para actualizar la informaci&oacute;n docente que hace parte del proceso de calidad institucional. Esta informaci&oacute;n se solicitar&aacute; una vez cada semestre; para ello debe ingresar a cada opci&oacute;n y actualizar, eliminar o ingresar dicha informaci&oacute;n seg&uacute;n sea el caso.</P>
		<P align="justify">Gracias por su colaboración.</p>
		</div>
</fieldset>
