<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" href="jquery.treeview.css" />
<script src="lib/jquery.treeview.js" type="text/javascript"></script>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">GRUPOS ACAD&Eacute;MICOS</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=ga&acc=new'"></caption>
					<tr>
						<td>Asociaci&oacute;n</td>
						<td>Tipo de asociaci&oacute;n</td>
						<td>Fecha inicio en asociaci&oacute;n</td>
						<td>Fecha terminaci&oacute;n en asociaci&oacute;n</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 idasociaciondocente
								,nombreasociaciondocente
								,nombretipoasociaciondocente
								,fechaingresoasociaciondocente
								,fechaterminacionasociaciondocente
							from asociaciondocente d
							, tipoasociaciondocente ts
							where d.iddocente= '".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and ts.codigotipoasociaciondocente=d.codigotipoasociaciondocente");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombreasociaciondocente"]?></td>
							<td><?=$row["nombretipoasociaciondocente"]?></td>
							<td align='center'><?=$row["fechaingresoasociaciondocente"]?></td>
							<td align='center'><?=$row["fechaterminacionasociaciondocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=ga&acc=edit&id=<?=$row["idasociaciondocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=ga&acc=del&id=<?=$row["idasociaciondocente"]?>'}">
							</td>
						</tr>
<?php
					}
?>
				</table>
			</div>
<?php
		}
		if($_REQUEST["acc"]=="new" || $_REQUEST["acc"]=="edit") {
			$res=$db->exec("select * from asociaciondocente where idasociaciondocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->textBox("Nombre de asociaci&oacute;n","nombreasociaciondocente",$row["nombreasociaciondocente"],1,"30")?> </p>
			<p> <?=$obj->select("Tipo de asociaci&oacute;n","codigotipoasociaciondocente",$row["codigotipoasociaciondocente"],1,"select codigotipoasociaciondocente,nombretipoasociaciondocente from tipoasociaciondocente where codigoestado like '1%'")?> </p>
			<p> <?=$obj->dateBox("Fecha de ingreso","fechaingresoasociaciondocente",$row["fechaingresoasociaciondocente"],1)?> </p>
			<p> <?=$obj->dateBox("Fecha de terminaci&oacute;n","fechaterminacionasociaciondocente",$row["fechaterminacionasociaciondocente"],1)?> </p>
			<p>
				<?=$obj->hiddenBox("opc",$_REQUEST["opc"])?>
				<?=$obj->hiddenBox("acc",$_REQUEST["acc"])?>
				<?=$obj->hiddenBox("id",$_REQUEST["id"])?>
				<div id="submit">
					<button type="button" Onclick="history.back()">Volver</button>
					<button type="submit">Guardar</button>
				</div>
			</p>
<?php
		}
		if($_REQUEST["acc"]=="del") {
			$res=$db->exec("delete from asociaciondocente where idasociaciondocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
