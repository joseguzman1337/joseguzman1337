<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" href="css/jquery.treeview.css" />
<script src="js/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});
		})
</script>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">EXPERIENCIA LABORAL</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=el&acc=new'"></caption>
					<tr>
						<td>Tipo de experiencia</td>
						<td>Nombre instituci&oacute;n</td>
						<td>Tipo contrato</td>
						<td>Fecha final</td>
						<td>Horas dedicaci&oacute;n</td>
						<td>Profesi&oacute;n</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 idexperiencialaboraldocente
								,d.codigotipoexperiencialaboraldocente
								,nombretipoexperiencialaboraldocente
								,nombreinstitucionexperiencialaboraldocente
								,tipocontratoexperiencialaboraldocente
								,fechafinalexperiencialaboraldocente
								,horadedicacionexperiencialaboraldocente
								,nombreprofesion
							from experiencialaboraldocente d
							,tipoexperiencialaboraldocente te
							,profesion p
							where d.iddocente='".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and d.codigotipoexperiencialaboraldocente=te.codigotipoexperiencialaboraldocente
								and p.idprofesion=d.idprofesion");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?php echo $row["nombretipoexperiencialaboraldocente"]?></td>
							<td><?php echo $row["nombreinstitucionexperiencialaboraldocente"]?></td>
							<td><?php echo $row["tipocontratoexperiencialaboraldocente"]?></td>
							<td align="center"><?php echo $row["fechafinalexperiencialaboraldocente"]?></td>
							<td align="center"><?php echo $row["horadedicacionexperiencialaboraldocente"]?></td>
							<td><?php echo $row["nombreprofesion"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=el&acc=edit&idtipo=<?php echo $row["codigotipoexperiencialaboraldocente"]?>&id=<?php echo $row["idexperiencialaboraldocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=el&acc=del&id=<?php echo $row["idexperiencialaboraldocente"]?>'}">
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
								\$('#div_general').css('display','block');
								\$('#div_docencia').css('display','block');
								\$('#div_otro').css('display','none');
							} else if(id==200) {
								\$('#div_general').css('display','block');
								\$('#div_docencia').css('display','none');
								\$('#div_otro').css('display','block');
							} else {
								\$('#div_general').css('display','none');
								\$('#div_docencia').css('display','none');
								\$('#div_otro').css('display','none');
							}
						}";
			function arbol($id,$nombre,$db,$obj,$idprof=0) {
				$res2=$db->exec("select * from profesion where idpadreprofesion=".$id." and codigoestado like '1%'");
				if(mysql_num_rows($res2)>0) {
					if($id>0) {
?>
						<li class="expandable"><strong><?php echo $nombre?></strong>
							<ul style="display: none;">
<?php
					}
					while($row2=mysql_fetch_array($res2))
						arbol($row2["idprofesion"],$row2["nombreprofesion"],$db,$obj,$idprof);
					if($id>0) {
?>
							</ul>
						</li>
<?php
					}
				} else {
					$check=($id==$idprof)?"checked":"";
?>
					
					<li><?=$obj->radioButton($nombre,"actividadlaboral",$id,1,$check)?></li>
<?php
				}
			}
			$res=$db->exec("select * from experiencialaboraldocente join detallenucleobasicoareaconocimiento using(iddetallenucleobasicoareaconocimiento) where idexperiencialaboraldocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?php echo $obj->select("Tipo de experiencia","tipoexperiencia",$row["codigotipoexperiencialaboraldocente"],1,"select * from tipoexperiencialaboraldocente where codigoestado like '1%'","","hideViewDivs(this.value)",$funcionHideViewDivs)?> </p>
			<div id="div_general" style="display:none">
				<p> <?php echo $obj->textBox("Nombre instituci&oacute;n","nombreinstitucionexperiencialaboraldocente",$row["nombreinstitucionexperiencialaboraldocente"],1,"30")?> </p>
				<p> <?php echo $obj->dateBox("Fecha inicial","fechainicioexperiencialaboraldocente",$row["fechainicioexperiencialaboraldocente"],1)?> </p>
				<p> <?php echo $obj->dateBox("Fecha final","fechafinalexperiencialaboraldocente",$row["fechafinalexperiencialaboraldocente"],1)?> </p>
				<p> <?php echo $obj->numberBox("Horas de dedicaci&oacute;n por semana","horadedicacionexperiencialaboraldocente",$row["horadedicacionexperiencialaboraldocente"],1,"4","right")?> </p>
			</div>
			<div id="div_docencia" style="display:none">
				<p> <?php echo $obj->select("Tipo area de conocimiento","tipoareaconocimiento",$row["idnucleobasicoareaconocimiento"],1," select idnucleobasicoareaconocimiento, nombrenucleobasicoareaconocimiento from nucleobasicoareaconocimiento g order by nombrenucleobasicoareaconocimiento","","cargaAreasConocimiento(this.value)","function cargaAreasConocimiento(id) { $.ajax({ url: 'cargaCombos.php', data: 'id='+id+'&opc=ac', success: function(resp){ $('#areaconocimiento').html(resp) } });}")?> </p>
				<p> <?php echo $obj->select("Area de conocimiento","areaconocimiento",$row["iddetallenucleobasicoareaconocimiento"],1,"select iddetallenucleobasicoareaconocimiento,nombredetallenucleobasicoareaconocimiento from detallenucleobasicoareaconocimiento where idnucleobasicoareaconocimiento=".$row["idnucleobasicoareaconocimiento"]." and codigoestado like '1%'")?> </p>
			</div>
			<div id="div_otro" style="display:none">
				<p> <?php echo $obj->textBox("Cargo","cargoexperiencialaboraldocente",$row["cargoexperiencialaboraldocente"],1,"30")?> </p>
				<p> <?php echo $obj->textBox("Tipo contrato","tipocontratoexperiencialaboraldocente",$row["tipocontratoexperiencialaboraldocente"],1,"30")?> </p>
				<p>
					<label><span class='asterisco'>*</span> Actividad laboral</label>
					<ul id="tree" class="treeview">
						<?php arbol(0,"",$db,$obj,$row["idprofesion"]) ?>
					</ul>
				</p>
			</div>
			<p>
				<?php echo $obj->hiddenBox("opc",$_REQUEST["opc"])?>
				<?php echo $obj->hiddenBox("acc",$_REQUEST["acc"])?>
				<?php echo $obj->hiddenBox("id",$_REQUEST["id"])?>
				<div id="submit">
					<button type="button" Onclick="history.back()">Volver</button>
					<button type="submit">Guardar</button>
				</div>
			</p>
<?php
			if($_REQUEST["acc"]=="edit") {
?>
				<script> $(forma).ready(hideViewDivs(<?php echo $_REQUEST['idtipo']?>)); </script>
<?php
			}
		}
		if($_REQUEST["acc"]=="del") {
			$res=$db->exec("delete from experiencialaboraldocente where idexperiencialaboraldocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
