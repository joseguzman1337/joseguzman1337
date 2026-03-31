<?php
require_once "../common/ServicesFacade.php";
require_once "../common/includes.php";
require_once "../layouts/top_layout_admin.php";

?>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;" colspan="2"><b>Paises</b></td></tr>
	<? $paises= $servicesFacade->ejecutarSQL('SELECT * FROM paises Where Nombre = "" OR Abreviatura=""');
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
	<tr>
		<td><b>Nombre (id)</b></td>
		<td><b>Abreviatura</b></td>
		<td><b>Nombre_Pais (id)</b></td>
	</tr>
	<? $instituciones = $servicesFacade->ejecutarSQL('SELECT I.*, P.Nombre as Nombre_Pais FROM instituciones as I LEFT JOIN paises as P ON I.Codigo_Pais = P.Id Where I.Codigo_Pais = 0 OR isNull(P.Id) OR I.Nombre = "" OR I.Abreviatura=""');
	foreach($instituciones as $institucion){?>
	    <tr>
			<td style="border-top: 1px solid black;padding-left:20px">'<?= $institucion["Nombre"] ?>' (<?= $institucion["Codigo"] ?>)</td>
			<td style="border-top: 1px solid black;"><?= $institucion["Abreviatura"] ?></td>
			<td style="border-top: 1px solid black;"><?= $institucion["Nombre_Pais"] ?> (<?= $institucion["Codigo_Pais"] ?>)</td>
		</tr>
	<?}?>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;"><b>Dependencias</b></td></tr>
	<tr>
		<td><b>Nombre (id)</b></td>
		<td><b>Nombre_Institucion (id)</b></td>
	</tr>
	<? $dependencias = $servicesFacade->ejecutarSQL('SELECT D.*, I.Nombre as Nombre_Institucion FROM dependencias as D LEFT JOIN instituciones as I ON D.Codigo_Institucion = I.Codigo WHERE D.Codigo_Institucion = 0 OR isNull(I.Codigo) OR D.Nombre = ""');
	foreach($dependencias as $dependencia){?>
	    <tr>
	    	<td style="border-top: 1px solid black;padding-left:20px">'<?= $dependencia["Nombre"] ?>' (<?= $dependencia["Id"] ?>)</td>
	    	<td style="border-top: 1px solid black;">'<?= $dependencia["Nombre_Institucion"] ?>' (<?= $dependencia["Codigo_Institucion"] ?>)</td>
	    </tr>
	<?}?>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="font-family:verdana; font-color:black;font-size:10px;">
	<tr><td style="font-size:14px;"><b>Unidades</b></td></tr>
	<tr>
		<td><b>Nombre (id)</b></td>
		<td><b>Nombre_Dependencia (id)</b></td>
		<td><b>Nombre_Institucion (id)</b></td>
	</tr>
	<? $unidades= $servicesFacade->ejecutarSQL('SELECT U.*, D.Nombre as Nombre_Dependencia, I.Nombre as Nombre_Institucion FROM unidades as U LEFT JOIN dependencias as D ON D.Id=U.Codigo_Dependencia LEFT JOIN instituciones as I ON U.Codigo_Institucion = I.Codigo WHERE U.Codigo_Institucion = 0 OR U.Codigo_Dependencia = 0 OR isNull(D.Id) OR isNull(I.Codigo) OR U.Nombre = "" OR D.Codigo_Institucion <> I.Codigo');
	foreach($unidades as $unidad){?>
	    <tr>
	    	<td style="border-top: 1px solid black; padding-left:20px">'<?= $unidad["Nombre"] ?>'  (<?= $unidad["Id"] ?>)</td>
	    	<td style="border-top: 1px solid black;">'<?= $unidad["Nombre_Dependencia"] ?>'  (<?= $unidad["Codigo_Dependencia"] ?>)</td>
	    	<td style="border-top: 1px solid black;">'<?= $unidad["Nombre_Institucion"] ?>'  (<?= $unidad["Codigo_Institucion"] ?>)</td>
	    </tr>
	<?}?>
</table>

<?require_once "../layouts/base_layout_admin.php";?>