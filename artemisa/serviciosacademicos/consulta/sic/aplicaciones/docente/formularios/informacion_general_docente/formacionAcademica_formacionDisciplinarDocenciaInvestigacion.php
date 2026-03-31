<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">
		FORMACI&Oacute;N ACAD&Eacute;MICA<br><br>
<?php
			if($_REQUEST["tf"]==100)
				echo "FORMACI&Oacute;N DISCIPLINAR";
			else if($_REQUEST["tf"]==200)
				echo "FORMACI&Oacute;N EN LA DOCENCIA";
			else
				echo "FORMACI&Oacute;N PARA LA INVESTIGACI&Oacute;N";
?>
	</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=fafddi&acc=new&tf=<?=$_REQUEST["tf"]?>'"></caption>
					<tr>
						<td>Nombre del programa</td>
						<td>Nombre de la instituci&oacute;n</td>
						<td>Tipo de educaci&oacute;n</td>
						<td>Fecha final</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select idnivelacademicodocente
								,d.codigotiponivelacademico
								,titulonivelacademicodocente
								,institucionnivelacademicodocente
								,nombretiponivelacademico
								,fechafinalnivelacademicodocente
							from nivelacademicodocente d
							,tiponivelacademico t
							,nucleobasicoareaconocimiento na
							,pais p
							,tipoformacion tf
							where d.iddocente='".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and d.idnucleobasicoareaconocimiento=na.idnucleobasicoareaconocimiento
								and d.codigotiponivelacademico=t.codigotiponivelacademico
								and d.idpais=p.idpais and d.codigotiponivelacademico not in ('09','10','11','12','13')
								and d.codigotipoformacion=tf.codigotipoformacion
								and d.codigotipoformacion = '".$_REQUEST["tf"]."'");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["titulonivelacademicodocente"]?></td>
							<td><?=$row["institucionnivelacademicodocente"]?></td>
							<td><?=$row["nombretiponivelacademico"]?></td>
							<td align='center'><?=$row["fechafinalnivelacademicodocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=fafddi&acc=edit&tf=<?=$_REQUEST["tf"]?>&idtipo=<?=$row["codigotiponivelacademico"]?>&id=<?=$row["idnivelacademicodocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=fafddi&acc=del&tf=<?=$_REQUEST["tf"]?>&id=<?=$row["idnivelacademicodocente"]?>'}">
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
							if(id==101 || id==102 || id==103 || id==104 || id==105 || id==106 || id==107 || id==108) {
								\$('#div_restante').css('display','block');
								\$('#div_actividadacademica').css('display','block');
							} else if(id==201 || id==202 || id==203 || id==204 || id==205) {
								\$('#div_restante').css('display','block');
								\$('#div_actividadacademica').css('display','none');
							} else {
								\$('#div_restante').css('display','none');
								\$('#div_actividadacademica').css('display','none');
							}
						}";
			$res=$db->exec("select * from nivelacademicodocente where idnivelacademicodocente=".$_REQUEST['id']);
			$row=mysql_fetch_array($res);
?>
			<p> <?=$obj->select("Tipo de educaci&oacute;n","codigotiponivelacademico",$row["codigotiponivelacademico"],1,"select codigotiponivelacademico,nombretiponivelacademico from tiponivelacademico where codigoestado like '1%'","","hideViewDivs(this.value)",$funcionHideViewDivs)?> </p>
			<div id="div_restante" style="display:none">
				<p> <?=$obj->select("Nucleo b&aacute;sico (Area conocimiento)","idnucleobasicoareaconocimiento",$row["idnucleobasicoareaconocimiento"],1,"select idnucleobasicoareaconocimiento,nombrenucleobasicoareaconocimiento from nucleobasicoareaconocimiento where codigoestado like '1%' order by nombrenucleobasicoareaconocimiento")?> </p>
				<p> <?=$obj->dateBox("Fecha final","fechafinalnivelacademicodocente",$row["fechafinalnivelacademicodocente"],1)?> </p>
				<p> <?=$obj->select("Pais","idpais",$row["idpais"],1,"select idpais,nombrepais from pais where codigoestado='100' order by nombrepais")?> </p>
				<p> <?=$obj->textBox("T&iacute;tulo","titulonivelacademicodocente",$row["titulonivelacademicodocente"],1,"50")?> </p>
				<p> <?=$obj->select("Tipo financiaci&oacute;n","codigotipofinanciacion",$row["codigotipofinanciacion"],1,"select codigotipofinanciacion,nombretipofinanciacion from tipofinanciacion where codigoestado like '1%'")?> </p>
				<p> <?=$obj->select("Tipo capacitaci&oacute;n","codigotipocapacitacion",$row["codigotipocapacitacion"],1,"select codigotipocapacitacion,nombretipocapacitacion from tipocapacitacion where codigoestado like '1%'")?> </p>
				<p> <?=$obj->textBox("Nombre instituci&oacute;n","institucionnivelacademicodocente",$row["institucionnivelacademicodocente"],1,"30")?> </p>
			</div>
			<div id="div_actividadacademica" style="display:none">
				<p> <?=$obj->select("Se encuentra en curso la actividad acad&eacute;mica?","encursonivelacademicodocente",$row["encursonivelacademicodocente"],1,"select idsiq_existe,existe from siq_existe")?> </p>
			</div>
			<p>
				<?=$obj->hiddenBox("opc",$_REQUEST["opc"])?>
				<?=$obj->hiddenBox("acc",$_REQUEST["acc"])?>
				<?=$obj->hiddenBox("tf",$_REQUEST["tf"])?>
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
			$res=$db->exec("delete from nivelacademicodocente where idnivelacademicodocente=".$_REQUEST['id']);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list&tf=".$_REQUEST["tf"]."';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
