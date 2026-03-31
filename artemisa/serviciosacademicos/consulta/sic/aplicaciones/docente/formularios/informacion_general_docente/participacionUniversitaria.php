<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">PARTICIPACI&Oacute;N UNIVERSITARIA PARA EL PERIODO <?=$_SESSION["codigoperiodosesion"]?></legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=pu&acc=new'"></caption>
					<tr>
						<td>Tipo de participaci&oacute;n</td>
						<td>Descripci&oacute;n</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->exec("select	 tp.codigotipoparticipacionuniversitaria
								,tp.nombretipoparticipacionuniversitaria
								,d.idparticipacionuniversitariadocente
								,d.nombreparticipacionuniversitariadocente
							from participacionuniversitariadocente d
							,tipoparticipacionuniversitaria tp
							where d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
								and d.iddocente='".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and tp.codigotipoparticipacionuniversitaria=d.codigotipoparticipacionuniversitaria
								and tp.codigotipoparticipacionuniversitaria <> '400'
								and d.nombreparticipacionuniversitariadocente<>''");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombretipoparticipacionuniversitaria"]?></td>
							<td><?=$row["nombreparticipacionuniversitariadocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=pu&acc=edit&idtipo=<?=$row["codigotipoparticipacionuniversitaria"]?>&id=<?=$row["idparticipacionuniversitariadocente"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=pu&acc=del&idtipo=<?=$row["codigotipoparticipacionuniversitaria"]?>&id=<?=$row["idparticipacionuniversitariadocente"]?>'}">
							</td>
						</tr>
<?php
					}
					$res=$db->exec("select	 tp.codigotipoparticipacionuniversitaria
								,tp.nombretipoparticipacionuniversitaria
								,group_concat(tc.nombretipoconsejouniversidad separator '<br>') as nombreparticipacionuniversitariadocente
							from participacionuniversitariadocente d
							,tipoconsejouniversidad tc
							,tipoparticipacionuniversitaria tp
							where d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
								and d.iddocente='".$_SESSION["sissic_iddocente"]."'
								and d.codigoestado like '1%'
								and tp.codigotipoparticipacionuniversitaria=d.codigotipoparticipacionuniversitaria
								and tc.codigotipoconsejouniversidad=d.codigotipoconsejouniversidad
								and tc.codigotipoconsejouniversidad <> '400'
							group by tp.codigotipoparticipacionuniversitaria
								,tp.nombretipoparticipacionuniversitaria");
					while ($row=mysql_fetch_array($res)) {
?>
						<tr>
							<td><?=$row["nombretipoparticipacionuniversitaria"]?></td>
							<td><?=$row["nombreparticipacionuniversitariadocente"]?></td>
							<td align="center">
								<img src="images/editar.png" onclick="location.href='?opc=pu&acc=edit&idtipo=<?=$row["codigotipoparticipacionuniversitaria"]?>'">
								<img src="images/eliminar.png" onclick="if(confirm('Esta seguro de eliminar el registro?')){location.href='?opc=pu&acc=del&idtipo=<?=$row["codigotipoparticipacionuniversitaria"]?>'}">
							</td>
						</tr>
<?php
					}
?>
				</table>
			</div>
<?php
		}
		if($_REQUEST["acc"]=="edit") {
?>
			<p> <?=$obj->select("Tipo de participaci&oacute;n","tipoparticipacion",$_REQUEST["idtipo"],1,"select codigotipoparticipacionuniversitaria,nombretipoparticipacionuniversitaria from tipoparticipacionuniversitaria where codigotipoparticipacionuniversitaria=".$_REQUEST["idtipo"])?> </p>
<?php
			if($_REQUEST["idtipo"]==400) {
				$res=$db->exec("select codigotipoconsejouniversidad
							,nombretipoconsejouniversidad
							,coalesce(ingresado,false) as ingresado
						from tipoconsejouniversidad 
						left join (	select	 d.codigotipoconsejouniversidad
									,true as ingresado 
								from participacionuniversitariadocente d
								,tipoconsejouniversidad tp
								where d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
									and d.iddocente= '".$_SESSION["sissic_iddocente"]."'
									and d.codigoestado like '1%'
									and tp.codigotipoconsejouniversidad=d.codigotipoconsejouniversidad
									and tp.codigotipoconsejouniversidad <> '400'
						) as sub using(codigotipoconsejouniversidad)
						where codigoestado=100");
				while($row=mysql_fetch_array($res)) {
					$check=($row["ingresado"])?"checked":"";
?>
					<p><?=$obj->checkBox($row["nombretipoconsejouniversidad"],"tipo[]",$row["codigotipoconsejouniversidad"],0,$check)?></p>
<?php
				}
			} else {
				$res=$db->exec("select nombreparticipacionuniversitariadocente from participacionuniversitariadocente where idparticipacionuniversitariadocente=".$_REQUEST["id"]);
				$row=mysql_fetch_array($res);
?>
				<p> <?=$obj->textArea("Descripci&oacute;n","descripcion",$row["nombreparticipacionuniversitariadocente"],1,15,60)?> </p>
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
		if($_REQUEST["acc"]=="new") {
?>
			<p> <?=$obj->select("Tipo de participaci&oacute;n","tipoparticipacion","",1,"select codigotipoparticipacionuniversitaria,nombretipoparticipacionuniversitaria from tipoparticipacionuniversitaria where codigotipoparticipacionuniversitaria not in (select distinct d.codigotipoparticipacionuniversitaria from participacionuniversitariadocente d where d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."' and d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and d.codigotipoparticipacionuniversitaria <> '400' and d.nombreparticipacionuniversitariadocente<>'' union select distinct d.codigotipoparticipacionuniversitaria from participacionuniversitariadocente d ,tipoconsejouniversidad tc where d.codigoperiodo='".$_SESSION["codigoperiodosesion"]."' and d.iddocente='".$_SESSION["sissic_iddocente"]."' and d.codigoestado like '1%' and tc.codigotipoconsejouniversidad=d.codigotipoconsejouniversidad and tc.codigotipoconsejouniversidad <> '400')","","hideViewDivs(this.value)","function hideViewDivs(id) { if(id==''){ \$('#algo').css('display','none'); \$('#algo2').css('display','none'); }else if(id==400){ \$('#algo').css('display','none'); \$('#algo2').css('display','block'); } else { \$('#algo').css('display','block'); \$('#algo2').css('display','none'); } }")?> </p>
			<div id="algo" style="display:none"><p> <?=$obj->textArea("Descripci&oacute;n","descripcion","",1,15,60)?> </p></div>
			<div id="algo2" style="display:none">
<?php
			$res=$db->exec("select codigotipoconsejouniversidad
						,nombretipoconsejouniversidad
					from tipoconsejouniversidad 
					where codigoestado=100");
			while($row=mysql_fetch_array($res)) {
?>
				<p><?=$obj->checkBox($row["nombretipoconsejouniversidad"],"tipo[]",$row["codigotipoconsejouniversidad"])?></p>
<?php
			}
?>
			</div>
			<p>
				<?=$obj->hiddenBox("opc",$_REQUEST["opc"])?>
				<?=$obj->hiddenBox("acc",$_REQUEST["acc"])?>
				<div id="submit">
					<button type="button" Onclick="history.back()">Volver</button>
					<button type="submit">Guardar</button>
				</div>
			</p>
<?php
		}
		if($_REQUEST["acc"]=="del") {
			if($_REQUEST["idtipo"]==400) 
				$cadena="delete from participacionuniversitariadocente where codigoperiodo='".$_SESSION["codigoperiodosesion"]."' and iddocente= '".$_SESSION["sissic_iddocente"]."' and codigoestado like '1%' and codigotipoconsejouniversidad <> '400'";
			else
				$cadena="delete from participacionuniversitariadocente where idparticipacionuniversitariadocente=".$_REQUEST["id"];
			$res=$db->exec($cadena);
			echo "<script>alert('¡¡ EL registro se ha eliminado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		}
?>
</fieldset>
<div id="resultado"></div>
