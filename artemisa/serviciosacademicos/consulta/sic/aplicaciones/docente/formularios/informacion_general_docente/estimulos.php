<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">EST&Iacute;MULOS</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=e&acc=new'"></caption>
					<tr>
						<td>T&iacute;tulo estimulo</td>
						<td>Instituci&oacute;n o entidad organizadora</td>
						<td>Tipo estimulo</td>
						<td>Tipo participaci&oacute;n</td>
						<td>Fecha de actividad</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 d.tituloestimulodocente
								,d.entidadestimulodocente
								,tp.nombretipoestimulodocente
								,te.nombretipoparticipacionestimulodocente
								,d.fechaestimulodocente
								,d.codigotipoestimulodocente
								,d.idestimulodocente
							from estimulodocente d
							,tipoestimulodocente tp
							,tipoparticipacionestimulodocente te
							,ciudad c
							where d.iddocente= '".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and tp.codigotipoestimulodocente=d.codigotipoestimulodocente
								and d.codigotipoparticipacionestimulodocente=te.codigotipoparticipacionestimulodocente
								and c.idciudad=d.idciudadestimulodocente");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["tituloestimulodocente"]?></td>
							<td><?=$row["entidadestimulodocente"]?></td>
							<td><?=$row["nombretipoestimulodocente"]?></td>
							<td><?=$row["nombretipoparticipacionestimulodocente"]?></td>
							<td align='center'><?=$row["fechaestimulodocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=e&acc=edit&idtipo=<?=$row["codigotipoestimulodocente"]?>&id=<?=$row["idestimulodocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=e&acc=del&id=<?=$row["idestimulodocente"]?>'}">
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
			$funcionHideViewDivs = "function hideViewDivs(id) {
							if(id==100) {
								\$('#div_nombreprograma').css('display','block');
								\$('#div_tituloestimulo').css('display','none');
								\$('#div_nombreevento').css('display','none');
								\$('#div_institucionentidad').css('display','block');
								\$('#div_otros').css('display','none');
								\$('#div_fechaparticipacion').css('display','block');
							} else if(id==201 || id==202 || id==203) {
								\$('#div_nombreprograma').css('display','none');
								\$('#div_tituloestimulo').css('display','none');
								\$('#div_nombreevento').css('display','block');
								\$('#div_institucionentidad').css('display','block');
								\$('#div_otros').css('display','block');
								\$('#div_fechaparticipacion').css('display','block');
							} else if(id==300) {
								\$('#div_nombreprograma').css('display','none');
								\$('#div_tituloestimulo').css('display','block');
								\$('#div_nombreevento').css('display','none');
								\$('#div_institucionentidad').css('display','block');
								\$('#div_otros').css('display','block');
								\$('#div_fechaparticipacion').css('display','block');
							} else {
								\$('#div_nombreprograma').css('display','none');
								\$('#div_tituloestimulo').css('display','none');
								\$('#div_nombreevento').css('display','none');
								\$('#div_institucionentidad').css('display','none');
								\$('#div_otros').css('display','none');
								\$('#div_fechaparticipacion').css('display','none');
							}
						}";
			$res=$db->exec("select * from estimulodocente where idestimulodocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->select("Tipo de estimulo","tipoestimulo",$row["codigotipoestimulodocente"],1,"select codigotipoestimulodocente,nombretipoestimulodocente from tipoestimulodocente where codigoestado like '1%'","","hideViewDivs(this.value)",$funcionHideViewDivs)?> </p>
			<div id="div_nombreprograma" style="display:none">
				<p> <?=$obj->textBox("Nombre del programa","nombreprograma",$row["tituloestimulodocente"],1,"30")?> </p>
			</div>
			<div id="div_tituloestimulo" style="display:none">
				<p> <?=$obj->textBox("T&iacute;tulo estimulo","tituloestimulo",$row["tituloestimulodocente"],1,"30")?> </p>
			</div>
			<div id="div_nombreevento" style="display:none">
				<p> <?=$obj->textBox("Nombre del evento","nombreevento",$row["tituloestimulodocente"],1,"30")?> </p>
			</div>
			<div id="div_institucionentidad" style="display:none">
				<p> <?=$obj->textBox("Instituci&oacute;n o entidad organizadora","institucionentidad",$row["entidadestimulodocente"],1,"30")?> </p>
			</div>
			<div id="div_fechaparticipacion" style="display:none">
				<p> <?=$obj->dateBox("Fecha de participaci&oacute;n","fechaparticipacion",$row["fechaestimulodocente"],1)?> </p>
			</div>
			<div id="div_otros" style="display:none">
				<p> <?=$obj->select("Tipo de participaci&oacute;n","tipoparticipacion",$row["codigotipoparticipacionestimulodocente"],1,"select codigotipoparticipacionestimulodocente,nombretipoparticipacionestimulodocente from tipoparticipacionestimulodocente where codigoestado like '1%'")?> </p>
				<p> <?=$obj->select("Pais","idpaisestimulodocente",$row["idpaisestimulodocente"],1,"select idpais,nombrepais from pais where codigoestado='100' order by nombrepais","","cargaDepartamentos(this.value)","function cargaDepartamentos(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=dep', success: function(resp){ $('#iddepartamentoestimulodocente').html(resp) } });}")?> </p>
				<p> <?=$obj->select("Departamento","iddepartamentoestimulodocente",$row["iddepartamentoestimulodocente"],1,"select iddepartamento,nombredepartamento from departamento where idpais=".$row["idpaisestimulodocente"]." and codigoestado='100' order by nombredepartamento","","cargaCiudades(this.value)","function cargaCiudades(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=ciu', success: function(resp){ $('#idciudadestimulodocente').html(resp) } });}")?> </p>
				<p> <?=$obj->select("Ciudad","idciudadestimulodocente",$row["idciudadestimulodocente"],1,"select idciudad,nombreciudad from ciudad where iddepartamento=".$row["iddepartamentoestimulodocente"]." and codigoestado='100' order by nombreciudad")?> </p>
			</div>
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
			if($_REQUEST["acc"]=="edit") {
?>
				<script> $(forma).ready(hideViewDivs(<?=$_REQUEST['idtipo']?>)); </script>
<?php
			}
		}
		if($_REQUEST["acc"]=="del") {
			$res=$db->exec("delete from estimulodocente where idestimulodocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
