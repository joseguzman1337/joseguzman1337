<?php
/** Esta pagina muestra la descripcion de una excepcion.
 * @param Celsius_Exception excepcion La Excepcion que tuvo lugar
 * @param bool continuar_ejecucion_normal = false. Indica si luego de mostrar el error en pantalla se continua con la ejecucion del script que lo invoca o no
 * @param string mensaje_error. El mensaje que sera mostrado al usuario 
 *
 */
$pageName = "error.pantalla";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
 
if (!empty($excepcion)){
	echo "<br>";
	if (is_a($excepcion, "DB_Exception"))
		echo $Mensajes["error.BBDD"].": <br>";
	elseif (is_a($excepcion, "Application_Exception"))
		echo $Mensajes["error.Aplicacion"].": <br>". $excepcion->getMessage();
	elseif (is_a($excepcion, "File_Exception"))
		echo $Mensajes["error.Archivos"].": <br>";
	elseif (is_a($excepcion, "WS_Exception"))
		echo $Mensajes["error.Webservices"].": <br>";
	elseif (is_a($excepcion, "Celsius_Exception"))
		echo $Mensajes["error.Desconocido"].": <br>". $excepcion->getMessage();
	else{
		echo $Mensajes["error.Desconocido"].": <br>";
		var_export($excepcion);
	}
	if (!empty($mensaje_error))
		echo "<br>".$mensaje_error;
	
	?>
	<br/>
	<p>
		<?=$Mensajes["texto.parte1"];?>
	</p>
	<ul>
		<li>1) <?=$Mensajes["lista.item1"];?></li>
		<li>2) <?=$Mensajes["lista.item2"];?></li>
		<li>3) <?=$Mensajes["lista.item3"];?></li>
	</ul> 
	<?
	if (empty($continuar_ejecucion_normal))
		exit;
}?>