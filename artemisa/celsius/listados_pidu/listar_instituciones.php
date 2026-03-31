<?php
require_once "../common/ServicesFacade.php";
require_once "../common/includes.php";
require_once "../layouts/top_layout_admin.php";

?>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;" colspan="2"><b>Paises</b></td></tr>
	<? $paises = $servicesFacade->getPaises();
	foreach($paises as $pais){?>
	    <tr>
	    	<td style="border-top: 1px solid black;padding-left:20px">'<?= $pais["Nombre"] ?>' (<?= $pais["Id"] ?>)</td>
	    	<td style="border-top: 1px solid black;"><?= $pais["Abreviatura"] ?></td>
	    </tr>
	<?}?>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;"><b>Instituciones</b></td></tr>
	<? $instituciones = $servicesFacade->getInstituciones();
	foreach($instituciones as $institucion){?>
	    <tr>
			<td style="border-top: 1px solid black;padding-left:20px">'<?= $institucion["Nombre"] ?>' (<?= $institucion["Codigo"] ?>)</td>
			<td style="border-top: 1px solid black;"><?= $institucion["Abreviatura"] ?></td>
		</tr>
	<?}?>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;"><b>Dependencias</b></td></tr>
	<? $dependencias = $servicesFacade->getDependencias();
	foreach($dependencias as $dependencia){?>
	    <tr><td style="border-top: 1px solid black;padding-left:20px">'<?= $dependencia["Nombre"] ?>' (<?= $dependencia["Id"] ?>)</td></tr>
	<?}?>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;"><b>Unidades</b></td></tr>
	<? $unidades= $servicesFacade->getUnidades();
	foreach($unidades as $unidad){?>
	    <tr><td style="border-top: 1px solid black; padding-left:20px">'<?= $unidad["Nombre"] ?>'  (<?= $unidad["Id"] ?>)</td></tr>
	<?}?>
</table>

<?require_once "../layouts/base_layout_admin.php";?>