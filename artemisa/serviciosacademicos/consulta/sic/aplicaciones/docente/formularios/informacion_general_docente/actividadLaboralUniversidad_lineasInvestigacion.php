<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">ACTIVIDAD LABORAL EN LA UNIVERSIDAD PARA EL PERIODO <?=$_SESSION["codigoperiodosesion"]?><br><br> LINEAS DE INVESTIGACI&Oacute;N </legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=aluli&acc=new'"></caption>
					<tr>
						<td>Facultad</td>
						<td>Grupo investigaci&oacute;n</td>
						<td>Linea investigaci&oacute;n</td>
						<td>Nombre proyecto</td>
						<td>Fecha inicio</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select idlineainvestigaciondocente
								,nombrefacultad
								,nombregrupoinvestigacion
								,nombrelineainvestigacion
								,nombre_proyecto
								,fechaingresolineainvestigacion
							from lineainvestigaciondocente d
							,lineainvestigacion l
							,grupoinvestigacion g
							,facultad f 
							where d.iddocente='".$_SESSION["sissic_iddocente"]."'
								and d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
								and d.codigoestado like '1%'
								and g.codigoestado like '1%'
								and l.codigoestado like '1%'
								and l.idlineainvestigacion=d.idlineainvestigacion
								and l.idgrupoinvestigacion=g.idgrupoinvestigacion
								and g.codigofacultad=f.codigofacultad");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombrefacultad"]?></td>
							<td><?=$row["nombregrupoinvestigacion"]?></td>
							<td><?=$row["nombrelineainvestigacion"]?></td>
							<td><?=$row["nombre_proyecto"]?></td>
							<td align='center'><?=$row["fechaingresolineainvestigacion"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=aluli&acc=edit&id=<?=$row["idlineainvestigaciondocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=aluli&acc=del&id=<?=$row["idlineainvestigaciondocente"]?>'}">
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
			$res=$db->exec("select * from lineainvestigaciondocente join lineainvestigacion using(idlineainvestigacion) join grupoinvestigacion using(idgrupoinvestigacion) where idlineainvestigaciondocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->select("Facultad","codigofacultad",$row["codigofacultad"],1,"select codigofacultad,nombrefacultad from facultad order by nombrefacultad","","cargaGruposInvestigacion(this.value)"," function cargaGruposInvestigacion(id) { $.ajax({ url: 'cargaCombos.php' , data: 'id='+id+'&opc=gi' , success: function(resp){ $('#idgrupoinvestigacion').html(resp) } }); $.ajax({ url: 'cargaCombos.php' , data: 'opc=empty' , success: function(resp){ $('#idlineainvestigacion').html(resp) } }); } ")?> </p>
			<p> <?=$obj->select("Grupo investigaci&oacute;n","idgrupoinvestigacion",$row["idgrupoinvestigacion"],1,"select idgrupoinvestigacion,nombregrupoinvestigacion from grupoinvestigacion where codigofacultad=".$row['codigofacultad']." order by nombregrupoinvestigacion","","cargaLineasInvestigacion(this.value)","function cargaLineasInvestigacion(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=li', success: function(resp){ $('#idlineainvestigacion').html(resp) } });}")?> </p>
			<p> <?=$obj->select("Linea investigaci&oacute;n","idlineainvestigacion",$row["idlineainvestigacion"],1,"select idlineainvestigacion,nombrelineainvestigacion from lineainvestigacion where codigoestado like '1%' and idgrupoinvestigacion=".$row['idgrupoinvestigacion']." order by nombrelineainvestigacion")?> </p>
			<p> <?=$obj->numberBox("N&uacute;mero horas de investigaci&oacute;n","numerohoraslineainvestigaciondocente",$row["numerohoraslineainvestigaciondocente"],1,"10","right")?> </p>
			<p> <?=$obj->dateBox("Fecha ingreso","fechaingresolineainvestigacion",$row["fechaingresolineainvestigacion"],1)?> </p>
			<p> <?=$obj->textBox("Nombre proyecto","nombre_proyecto",$row["nombre_proyecto"],1,"50")?> </p>
			<p> <?=$obj->textArea("Actividad a desarrollar","actividad_desarrollada",$row["actividad_desarrollada"],1,15,60)?> </p>
			<p>	
				<label>Tipo de Proyecto</label>
<?php
				$check1=($row["tipo_proyecto"]=="Investigaci?n formal")?"checked":"";
				$check2=($row["tipo_proyecto"]=="Investigaci?n formativa")?"checked":"";
				$check3=($row["tipo_proyecto"]=="Semilleros")?"checked":"";
?>
				<?=$obj->radioButton("Investigaci&oacute;n formal","tipo_proyecto","Investigaci?n formal",0,$check1)?> 
				<?=$obj->radioButton("Investigaci&oacute;n formativa","tipo_proyecto","Investigaci?n formativa",0,$check2)?> 
				<?=$obj->radioButton("Semilleros","tipo_proyecto","Semilleros",0,$check3)?> 
			</p>
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
			$res=$db->exec("delete from lineainvestigaciondocente where idlineainvestigaciondocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
