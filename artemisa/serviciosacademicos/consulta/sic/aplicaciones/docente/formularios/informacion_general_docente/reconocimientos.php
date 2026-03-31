<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">RECONOCIMIENTOS</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=r&acc=new'"></caption>
					<tr>
						<td>Reconocimiento otorgado por</td>
						<td>Tipo reconocimiento</td>
						<td>Fecha reconocimiento</td>
						<td>Ciudad</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 idreconocimientodocente
								,tiporeconocimientodocente
								,otorgareconocimientodocente
								,fechareconocimientodocente
								,nombreciudad
							from reconocimientodocente d
							, ciudad c 
							where d.iddocente= '".$_SESSION["sissic_iddocente"]."' 
								and d.codigoestado like '1%' 
								and c.idciudad=d.idciudadreconocimientodocente");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["otorgareconocimientodocente"]?></td>
							<td><?=$row["tiporeconocimientodocente"]?></td>
							<td align='center'><?=$row["fechareconocimientodocente"]?></td>
							<td><?=$row["nombreciudad"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=r&acc=edit&id=<?=$row["idreconocimientodocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=r&acc=del&id=<?=$row["idreconocimientodocente"]?>'}">
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
			$res=$db->exec("select * from reconocimientodocente where idreconocimientodocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->textBox("Reconocimiento otorgado por","otorgareconocimientodocente",$row["otorgareconocimientodocente"],1,"30")?> </p>
			<p> <?=$obj->textArea("Tipo reconocimiento","tiporeconocimientodocente",$row["tiporeconocimientodocente"],1,15,60)?> </p>
			<p> <?=$obj->dateBox("Fecha de reconocimiento","fechareconocimientodocente",$row["fechareconocimientodocente"],1)?> </p>
			<p> <?=$obj->select("Pais","idpaisreconocimientodocente",$row["idpaisreconocimientodocente"],1,"select idpais,nombrepais from pais where codigoestado='100' order by nombrepais","","cargaDepartamentos(this.value)","function cargaDepartamentos(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=dep', success: function(resp){ $('#iddepartamentoreconocimientodocente').html(resp) } });}")?> </p>
			<p> <?=$obj->select("Departamento","iddepartamentoreconocimientodocente",$row["iddepartamentoreconocimientodocente"],1,"select iddepartamento,nombredepartamento from departamento where idpais=".$row["idpaisreconocimientodocente"]." and codigoestado='100' order by nombredepartamento","","cargaCiudades(this.value)","function cargaCiudades(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=ciu', success: function(resp){ $('#idciudadreconocimientodocente').html(resp) } });}")?> </p>
			<p> <?=$obj->select("Ciudad","idciudadreconocimientodocente",$row["idciudadreconocimientodocente"],1,"select idciudad,nombreciudad from ciudad where iddepartamento=".$row["iddepartamentoreconocimientodocente"]." and codigoestado='100' order by nombreciudad")?> </p>
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
			$res=$db->exec("delete from reconocimientodocente where idreconocimientodocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
