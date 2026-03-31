<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">FORMACI&Oacute;N ACAD&Eacute;MICA<br><br>FORMACI&Oacute;N GENERAL<br><br>MANEJO DE TECNOLOG&Iacute;AS DE LA INFORMACI&Oacute;N Y COMUNICACIONES<br><br>(Seleccione de la lista las que considere que maneja)</legend>
<?php
		$res=$db->exec("select codigotipotecnologiainformacion from tecnologiainformaciondocente where iddocente='".$_SESSION["sissic_iddocente"]."' and codigoestado like '1%'");
		while($row=mysql_fetch_array($res))
			$arrSeleccionados[]=$row["codigotipotecnologiainformacion"];

		$res=$db->exec("select codigotipotecnologiainformacion,nombretipotecnologiainformacion from tipotecnologiainformacion where codigoestado like '1%'");
		while($row=mysql_fetch_array($res)) {
			$checked=(in_array($row["codigotipotecnologiainformacion"],$arrSeleccionados))?"checked":"";	
?>
			<p>
				<?=$obj->checkBox($row["nombretipotecnologiainformacion"],"seleccion[]",$row["codigotipotecnologiainformacion"],0,$checked)?>
			</p>
<?php
		}		
?>
	<p>
		<?=$obj->hiddenBox("opc",$_REQUEST["opc"])?> 
		<div id="submit">
			<button type="submit">Enviar</button>
		</div>
	</p>
</fieldset>
<div id="resultado"></div>
