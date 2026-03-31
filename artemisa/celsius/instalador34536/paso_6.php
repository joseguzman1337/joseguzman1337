<?php
require_once "common_instalador.php";
/**
 * paso 6: intenta actualizar el PIDU con el directorio
 */
set_time_limit(0);

$paso_numero = 6;
require "top_layout_install.php";
?>

<table class="table-form" width="95%">
	<tr>
		<td class="table-form-top">
			<?=PASO6_TITULO?>. 
		</td>
	</tr>
	<tr>
		<td>
			<span id="display_element"><?=PASO6_SUBTITULO?></span>
  		</td>
	</tr>
	
</table>
<br/>

<table class="table-form" width="95%">
	<tr>
		<td style="text-align: center; background-color:white">
			<input type="button" id="btnReintentar" onclick="location.href='paso_6.php';" value="<?=PASO6_BUTTON_REINTENTAR?>" style="visibility:hidden;position:absolute;'"/>
			<input type="button" id="btnNoReintentar" onclick="location.href='instalador_controller.php?paso_numero=6';" value="<?=PASO6_BUTTON_ACTUALIZAR?>" style="visibility:hidden;position:absolute;"/>
			<input type="button" id="btnSiguiente"  onclick="location.href='instalador_controller.php?paso_numero=6';"value="<?=COMMON_BUTTON_SIGUIENTE?>" style="visibility:hidden;position:absolute;"/>
		</td>
	</tr>
</table>

<?
require "base_layout_install.php";

/* *******************************************************************************/
flush();

require_once "../soap-directorio/ProxyDirectorio.php";
require_once "../common/ServicesFacade.php";
$servicesFacade = ServicesFacade::getInstance();
$proxy = ProxyDirectorio::getInstance($servicesFacade);

if (is_a($proxy,"Celsius_Exception")){
	$resActualizacion = $proxy;
}else{
	$resActualizacion = $proxy->updateDirectory();
	if (!is_a($resActualizacion,"Celsius_Exception")){
		$resActualizacion = $proxy->updateInformacionInstanciaLocal();
	}
}


?>
<script language="JavaScript" type="text/javascript">

	<?
	if ($resActualizacion === true){
		$mensaje = PASO6_MENSAJE_ACTUALIZACIONCORRECTA;
		$colorTD = "green";
		
		//crea un flag que sera chequeado por index.php
		//si existe este archivo, entonces significa que la sincronizacion con el directorio tuvo exito 
		$handler = fopen(dirname(__FILE__)."/sincronizado.flg","w");
		if ($handler === false){
			//TODO manejar bien el error
			var_dump($handler);
			
		}
		
		fwrite($handler, "sincronizado");
		fclose($handler);
		?>
		document.getElementById("btnSiguiente").style.visibility="visible";
		document.getElementById("btnSiguiente").style.position = "relative";
	<?}else{
		if (is_a($resActualizacion,"WS_Exception"))
			$mensaje = PASO6_MENSAJE_ERROR_ACTUALIZARDIRECTORIO.($resActualizacion->getSafeMessage());
		else if (is_a($resActualizacion,"DB_Exception")){
			$mensaje = COMMON_ERROR_BDD.": ".$resActualizacion->getSafeMessage();
			$mensaje.="\n".COMMON_MENSAJE_ERROR_MYSQL.": <br/>Numero de error: ".$resActualizacion->dbErrorNo."<br/>Mensaje de error: ".$resActualizacion->dbError;
		}else if (is_a($resActualizacion,"Celsius_Exception"))
			$mensaje = COMMON_ERROR_INESPERADO.": ".$resActualizacion->getSafeMessage();
		else
			$mensaje = COMMON_ERROR_INESPERADO.": ".$resActualizacion;
		$colorTD = "red";?>
		document.getElementById("btnReintentar").style.visibility="visible";
		document.getElementById("btnReintentar").style.position = "relative";
		
		document.getElementById("btnNoReintentar").style.visibility="visible";
		document.getElementById("btnNoReintentar").style.position = "relative";
	<?}?>
	var displayTag = document.getElementById("display_element");
	displayTag.style.backgroundColor="<?=$colorTD?>";
	displayTag.firstChild.nodeValue="<?=$mensaje?>";
	
</script>