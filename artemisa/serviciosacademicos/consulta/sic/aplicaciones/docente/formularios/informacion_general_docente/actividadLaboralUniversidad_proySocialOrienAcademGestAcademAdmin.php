<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">ACTIVIDAD LABORAL EN LA UNIVERSIDAD PARA EL PERIODO <?=$_SESSION["codigoperiodosesion"]?><br><br>PROYECCI&Oacute;N SOCIAL / ORIENTACI&Oacute;N ACAD&Eacute;MICA / GESTI&Oacute;N ACAD&Eacute;MICA ADMINISTRATIVA</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=alupsoagaa&acc=new'"></caption>
					<tr>
						<td>Tipo actividad</td>
						<td>Nombre del proyecto</td>
						<td>Actividad a desarrollar</td>
						<td>N&uacute;mero de horas x semana</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 nombretipoactividadlaboral
								,sub.*
							from tipoactividadlaboral
							join (	select	 idproyeccionsocialdocente as id
									,nombre_proyecto as proyecto
									,actividad_a_desarrollar as actividad
									,numero_horas_semana as horas
									,300 as codigotipoactividadlaboral
								from proyeccionsocialdocente
								where iddocente='".$_SESSION["sissic_iddocente"]."'
									and codigoestado like '1%'
										union
								select idgestionacademincadocente as id
									,null as proyecto
									,actividad_desarrollada as actividad
									,numero_horas_semana as horas
									,500 as codigotipoactividadlaboral
								from gestionacademincadocente
								where iddocente='".$_SESSION["sissic_iddocente"]."'
									and codigoestado like '1%'
										union
								select idorientacionacademicadocente as id
									,null as proyecto
									,actividad_desarrollada as actividad
									,numero_horas_semana as horas
									,400 as codigotipoactividadlaboral
								from orientacionacademicadocente
								where iddocente='".$_SESSION["sissic_iddocente"]."'
									and codigoestado like '1%'
							) sub using(codigotipoactividadlaboral)");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombretipoactividadlaboral"]?></td>
							<td><?=$row["proyecto"]?></td>
							<td><?=$row["actividad"]?></td>
							<td align='center'><?=$row["horas"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=alupsoagaa&acc=edit&idtipo=<?=$row["codigotipoactividadlaboral"]?>&id=<?=$row["id"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=alupsoagaa&acc=del&idtipo=<?=$row["codigotipoactividadlaboral"]?>&id=<?=$row["id"]?>'}">
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
							if(id==300) {
								\$('#div_general').css('display','block');
								\$('#div_nombreproyecto').css('display','block');
							} else if(id==400 || id==500) {
								\$('#div_general').css('display','block');
								\$('#div_nombreproyecto').css('display','none');
							} else {
								\$('#div_general').css('display','none');
								\$('#div_nombreproyecto').css('display','none');
							}
						}";
			if($_REQUEST["idtipo"]==300) {
				$query="select	 nombre_proyecto as proyecto
						,actividad_a_desarrollar as actividad
						,numero_horas_semana as horas
					from proyeccionsocialdocente
					where idproyeccionsocialdocente=".$_REQUEST["id"];
			}
			if($_REQUEST["idtipo"]==400) {
				$query="select	 null as proyecto
						,actividad_desarrollada as actividad
						,numero_horas_semana as horas
					from orientacionacademicadocente
					where idorientacionacademicadocente=".$_REQUEST["id"];
			}
			if($_REQUEST["idtipo"]==500) {
				$query="select	 null as proyecto
						,actividad_desarrollada as actividad
						,numero_horas_semana as horas
					from gestionacademincadocente
					where idgestionacademincadocente=".$_REQUEST["id"];
			}
			$res=$db->exec($query);
			$row=mysql_fetch_array($res);
			$condicion=($_REQUEST["acc"]=="edit")?" and codigotipoactividadlaboral=".$_REQUEST["idtipo"]:"";
?>
			<p> <?=$obj->select("Tipo actividad","codigotipoactividadlaboral",$_REQUEST["idtipo"],1,"select codigotipoactividadlaboral,nombretipoactividadlaboral from tipoactividadlaboral where codigotipoactividadlaboral in (300,400,500) ".$condicion,"","hideViewDivs(this.value)",$funcionHideViewDivs)?> </p>
			<div id="div_general" style="display:none">
				<p> <?=$obj->textArea("Actividad a desarrollar","actividad",$row["actividad"],1,15,60)?> </p>
				<p> <?=$obj->numberBox("N&uacute;mero de horas x semana","horas",$row["horas"],1,"4","right")?> </p>
			</div>
			<div id="div_nombreproyecto" style="display:none">
				<p> <?=$obj->textBox("Nombre del proyecto","proyecto",$row["proyecto"],1,"30")?> </p>
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
			if($_REQUEST["idtipo"]==300)
				$cadena="delete from proyeccionsocialdocente where idproyeccionsocialdocente=".$_REQUEST["id"];
			if($_REQUEST["idtipo"]==400 || $_REQUEST["idtipo"]==500) {
				$tabla=($_REQUEST["idtipo"]==400)?"orientacionacademicadocente":"gestionacademincadocente";
				$campo=($_REQUEST["idtipo"]==400)?"idorientacionacademicadocente":"idgestionacademincadocente";
				$cadena="delete from ".$tabla." where ".$campo."=".$_REQUEST["id"];
			}
			$res=$db->exec($cadena);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
