<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">PRODUCCI&Oacute;N ACAD&Eacute;MICA</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=pa&acc=new'"></caption>
					<tr>
						<td>Tipo de producci&oacute;n</td>
						<td>T&iacute;tulo del producto</td>
						<td>Identificador del producto</td>
						<td>Fecha de publicaci&oacute;n</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select * from produccionintelectualdocente d, tipoproduccionintelectual tp where d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tp.codigotipoproduccionintelectual=d.codigotipoproduccionintelectual order by tp.nombretipoproduccionintelectual");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombretipoproduccionintelectual"]?></td>
							<td><?=$row["nombreproduccionintelectualdocente"]?></td>
							<td align='right'><?=$row["numeroproduccionintelectualdocente"]?></td>
							<td align='center'><?=$row["fechapublicacionproduccionintelectualdocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=pa&acc=edit&idtipo=<?=$row["codigotipoproduccionintelectual"]?>&id=<?=$row["idproduccionintelectualdocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=pa&acc=del&id=<?=$row["idproduccionintelectualdocente"]?>'}">
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
							if(id==100 || id==101) {
								\$('#div_revistas').css('display','block');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','none');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==200 || id==201) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','block');
								if(id==200)
									\$('#div_capitulo').css('display','none');
								else
									\$('#div_capitulo').css('display','block');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','none');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==300) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','block');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','none');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==400) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','block');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','block');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==401) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','block');
								\$('#div_titulo_especifico').css('display','block');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==402) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','block');
								\$('#div_resena').css('display','block');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							} else if(id==500) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','block');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','block');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','block');
								\$('#div_material').css('display','none');
							} else if(id==600) {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','none');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','none');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','block');
							} else {
								\$('#div_revistas').css('display','none');
								\$('#div_fechapublicacion').css('display','none');
								\$('#div_libros').css('display','none');
								\$('#div_capitulo').css('display','none');
								\$('#div_ponencia').css('display','none');
								\$('#div_producto_artistico').css('display','none');
								\$('#div_producto_artistico_musical').css('display','none');
								\$('#div_titulo_especifico').css('display','none');
								\$('#div_resena').css('display','none');
								\$('#div_proyectos').css('display','none');
								\$('#div_material').css('display','none');
							}
						}";
			$res=$db->exec("select * from produccionintelectualdocente d where idproduccionintelectualdocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->select("Tipo de producci&oacute;n","tipoproduccion",$row["codigotipoproduccionintelectual"],1,"select * from tipoproduccionintelectual where codigoestado like '1%'","","hideViewDivs(this.value)",$funcionHideViewDivs)?> </p>
			<div id="div_revistas" style="display:none">
				<p> <?=$obj->textBox("Nombre de la revista","nombrerevista",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->textBox("T&iacute;tulo del articulo","tituloarticulo",$row["tituloproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->select("Revista indexada","revistaindexada",$row["esindexadaproduccionintelectualdocente"],1,"select * from siq_existe")?> </p>
				<p> <?=$obj->textBox("ISSN","issn",$row["numeroproduccionintelectualdocente"],1,"15")?> </p>
			</div>
			<div id="div_libros" style="display:none">
				<p> <?=$obj->textBox("Nombre del libro","nombrelibro",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->textBox("ISBN","isbn",$row["numeroproduccionintelectualdocente"],1,"15")?> </p>
			</div>
			<div id="div_capitulo" style="display:none">
				<p> <?=$obj->textBox("Nombre del cap&iacute;tulo","nombrecapitulo",$row["tituloproduccionintelectualdocente"],1,"30")?> </p>
			</div>
			<div id="div_ponencia" style="display:none">
				<p> <?=$obj->textBox("Nombre de la ponencia","nombreponencia",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->textBox("Medio de publicaci&oacute;n","mediopublicacion",$row["tituloproduccionintelectualdocente"],1,"30")?> </p>
			</div>
			<div id="div_producto_artistico" style="display:none">
				<p> <?=$obj->textBox("Nombre del producto art&iacute;stico","nombreproductoartistico",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->numberBox("N&uacute;mero de identificaci&oacute;n del producto art&iacute;stico","numeroidentificacionproductoartistico",$row["numeroproduccionintelectualdocente"],1,"15","right")?> </p>
			</div>
			<div id="div_producto_artistico_musical" style="display:none">
				<p> <?=$obj->textBox("Nombre del producto art&iacute;stico musical","nombreproductoartisticomusical",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->numberBox("N&uacute;mero de identificaci&oacute;n del producto art&iacute;stico musical","numeroidentificacionproductoartisticomusical",$row["numeroproduccionintelectualdocente"],1,"15","right")?> </p>
			</div>
			<div id="div_resena" style="display:none">
				<p> <?=$obj->textBox("Nombre de la reseña","nombreresena",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->numberBox("N&uacute;mero de identificaci&oacute;n de la reseña","numeroidentificacionresena",$row["numeroproduccionintelectualdocente"],1,"15","right")?> </p>
			</div>
			<div id="div_proyectos" style="display:none">
				<p> <?=$obj->textBox("Nombre del proyecto","nombreproyecto",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
				<p> <?=$obj->numberBox("N&uacute;mero de identificaci&oacute;n del proyecto","numeroidentificacionproyecto",$row["numeroproduccionintelectualdocente"],1,"15","right")?> </p>
			</div>
			<div id="div_material" style="display:none">
				<p> <?=$obj->textBox("Nombre del material","nombrematerial",$row["nombreproduccionintelectualdocente"],1,"30")?> </p>
			</div>
			<div id="div_titulo_especifico" style="display:none">
				<p> <?=$obj->textBox("T&iacute;tulo espec&iacute;fico","tituloespecifico",$row["tituloproduccionintelectualdocente"],1,"30")?> </p>
			</div>
			<div id="div_fechapublicacion" style="display:none">
				<p> <?=$obj->dateBox("Fecha de publicaci&oacute;n","fechapublicacion",$row["fechapublicacionproduccionintelectualdocente"],1)?> </p>
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
			$res=$db->exec("delete from produccionintelectualdocente where idproduccionintelectualdocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
