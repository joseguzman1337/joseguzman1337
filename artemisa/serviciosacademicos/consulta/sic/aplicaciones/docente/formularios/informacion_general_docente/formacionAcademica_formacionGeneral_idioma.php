<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">FORMACI&Oacute;N ACAD&Eacute;MICA<br><br>FORMACI&Oacute;N GENERAL<br><br>IDIOMA</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator">
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=fafgi&acc=new'"></caption>
					<tr>
						<td>Idioma</td>
<?php
						$arrTipoManejoIdioma=array();
						$res=$db->exec("select idtipomanejoidioma,nombrecortotipomanejoidioma from tipomanejoidioma where codigoestado like '1%' order by idtipomanejoidioma");
						while ($row=mysql_fetch_array($res)) {
							$arrTipoManejoIdioma[]=$row["idtipomanejoidioma"];
?>
							<td><?=$row["nombrecortotipomanejoidioma"]?></td>
<?php
						}
?>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select * from idiomadocente join idioma using(ididioma) where iddocente='".$_SESSION["sissic_iddocente"]."'");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombreidioma"]?></td>

<?php
							$arrTipoManejoIdiomaDocentesId=array();
							$arrTipoManejoIdiomaDocentesIndicador=array();
							$res2=$db->exec("select idtipomanejoidioma,nombreindicadornivelidioma from detalleidiomadocente join indicadornivelidioma using(idindicadornivelidioma) where ididiomadocente=".$row["ididiomadocente"]." order by idtipomanejoidioma");
							while ($row2=mysql_fetch_array($res2))  {
								$arrTipoManejoIdiomaDocentesId[$row2["idtipomanejoidioma"]]=$row2["idtipomanejoidioma"];
								$arrTipoManejoIdiomaDocentesIndicador[$row2["idtipomanejoidioma"]]=$row2["nombreindicadornivelidioma"];
							}
							foreach ($arrTipoManejoIdioma as &$valor) {
								if(in_array($valor,$arrTipoManejoIdiomaDocentesId))
									echo "<td>".$arrTipoManejoIdiomaDocentesIndicador[$valor]."</td>";
								else
									echo "<td>&nbsp;</td>";
							}
?>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=fafgi&acc=edit&ididioma=<?=$row["ididioma"]?>&id=<?=$row["ididiomadocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=fafgi&acc=del&id=<?=$row["ididiomadocente"]?>'}">
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
			$arrTipoManejoIdiomaDocentesId=array();
			$arrTipoManejoIdiomaDocentesIndicador=array();
			$res2=$db->exec("select idtipomanejoidioma,idindicadornivelidioma from detalleidiomadocente where ididiomadocente=".$_REQUEST["id"]." order by idtipomanejoidioma");
			while ($row2=mysql_fetch_array($res2))  {
				$arrTipoManejoIdiomaDocentesId[$row2["idtipomanejoidioma"]]=$row2["idtipomanejoidioma"];
				$arrTipoManejoIdiomaDocentesIndicador[$row2["idtipomanejoidioma"]]=$row2["idindicadornivelidioma"];
			}
			$condicion=($_REQUEST["acc"]=="edit")?" and ididioma<>".$_REQUEST["ididioma"]:"";
?>
			<p> <?=$obj->select("Idioma","ididioma",$_REQUEST["ididioma"],1,"select ididioma,nombreidioma from idioma where ididioma not in (select ididioma from idiomadocente where iddocente=".$_SESSION["sissic_iddocente"]." ".$condicion.")")?> </p>
<?php
			$res=$db->exec("select idtipomanejoidioma,nombretipomanejoidioma from tipomanejoidioma where codigoestado like '1%' order by idtipomanejoidioma");
			while ($row=mysql_fetch_array($res)) {
				$valueDef=(in_array($row["idtipomanejoidioma"],$arrTipoManejoIdiomaDocentesId))?$arrTipoManejoIdiomaDocentesIndicador[$row["idtipomanejoidioma"]]:"";
?>
				<p> <?=$obj->select($row["nombretipomanejoidioma"],"idindicadornivelidioma[".$row["idtipomanejoidioma"]."]",$valueDef,1,"select idindicadornivelidioma,nombreindicadornivelidioma from indicadornivelidioma where codigoestado like '1%'")?> </p>
<?php
			}
?>
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
			$db->exec("delete from detalleidiomadocente where ididiomadocente=".$_REQUEST["id"]);
			$db->exec("delete from idiomadocente where ididiomadocente=".$_REQUEST["id"]);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
