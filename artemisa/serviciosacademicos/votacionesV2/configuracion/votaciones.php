<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">VOTACIONES</legend>
<?php
		if($_REQUEST["acc"]=="list") {
?>
			<div class="CSSTableGenerator" >
				<table>
					<caption><img src="images/nuevo.png" style="cursor:pointer" alt="Nuevo tipo de participaci&oacute;n" onclick="location.href='?opc=<?php echo $_REQUEST["opc"]?>&acc=new'">
					<a id="1" style="cursor:pointer"  onclick="location.href='?opc=<?php echo $_REQUEST["opc"]?>&acc=new'"><b>Nueva Votación</b></a></caption>
					</caption>
					<tr>
						<td>Nombre de la votaci&oacute;n</td>
						<td>Descripci&oacute;n de la votaci&oacute;n</td>
						<td>Fecha y hora de inicio de la votaci&oacute;n</td>
						<td>Fecha y hora de conclusi&oacute;n de la votaci&oacute;n</td>
						<td>Fecha inicial de vigencia de la votaci&oacute;n</td>
						<td>Fecha final de vigencia de la votaci&oacute;n</td>
						<td>Tipo candidato</td>
						<td>Estado</td>
						<td># Candidatos</td>
						<td>Acci&oacute;n</td>
					</tr>
<?php
					$res=$db->Execute("select * 
							from votacion v 
							join tipocandidatodetalleplantillavotacion tcdpv using(idtipocandidatodetalleplantillavotacion) 
							join estado e on v.codigoestado=e.codigoestado AND v.codigoestado<>300 
							order by idvotacion desc ");
							
					while ($row=$res->FetchRow()) {
							$candidatos = $db->Execute("SELECT COUNT(*) AS candidatos,t.nombretipoplantillavotacion
														FROM 
														(select p.nombreplantillavotacion,f.nombrefacultad,cv.idcandidatovotacion,
														cv.nombrescandidatovotacion,cv.apellidoscandidatovotacion,
														p.idtipoplantillavotacion  from plantillavotacion p 
														inner join detalleplantillavotacion dp on dp.idplantillavotacion=p.idplantillavotacion 
														inner join candidatovotacion cv on cv.idcandidatovotacion=dp.idcandidatovotacion 
														inner join carrera c on c.codigocarrera=p.codigocarrera
														inner join facultad f on f.codigofacultad=c.codigofacultad 
														where p.idvotacion=".$row["idvotacion"]." and dp.codigoestado=100 and dp.idcargo=2
														GROUP BY cv.idcandidatovotacion,f.codigofacultad,p.idtipoplantillavotacion) as x 
														inner join tipoplantillavotacion t on t.idtipoplantillavotacion=x.idtipoplantillavotacion 
														GROUP BY t.idtipoplantillavotacion 
														ORDER BY t.idtipoplantillavotacion ASC");
?>
						<tr>
							<td><?php echo $row["nombrevotacion"]?></td>
							<td><?php echo $row["descripcionvotacion"]?></td>
							<td align="center"><?php echo $row["fechainiciovotacion"]?></td>
							<td align="center"><?php echo $row["fechafinalvotacion"]?></td>
							<td align='center'><?php echo $row["fechainiciovigenciacargoaspiracionvotacion"]?></td>
							<td align='center'><?php echo $row["fechafinalvigenciacargoaspiracionvotacion"]?></td>
							<td><?php echo $row["nombretipocandidatodetalleplantillavotacion"]?></td>
							<td><?php echo $row["nombreestado"]?></td>
							<td><?php
							while ($conteo=$candidatos->FetchRow()) {
								echo "Candidatos ".$conteo["nombretipoplantillavotacion"].": ".$conteo["candidatos"]."<br/><br/>";
							}
							
							?></td>
							<td align="center">
								<img src="images/date_edit.png" title="Modificar votación" style="cursor:pointer;margin-bottom:5px" onclick="location.href='?opc=<?php echo $_REQUEST["opc"]?>&acc=edit&idvot=<?php echo $row["idvotacion"]?>'">
								<img src="images/search_file.png" title="Ver plantillas" style="cursor:pointer;" onclick="location.href='?opc=p&acc=list&idvot=<?php echo $row["idvotacion"]?>&idtip=<?php echo $row["idtipocandidatodetalleplantillavotacion"]?>'">
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
			if($_REQUEST["acc"]=="edit"){
				$res=$db->Execute("select * from votacion where idvotacion=".$_REQUEST['idvot']);
				$row=$res->FetchRow();
			}
?>
			<p> <?php echo $obj->textBox("Nombre de la votaci&oacute;n","nombrevotacion",$row["nombrevotacion"],1,"50")?> </p>
			<p> <?php echo $obj->textArea("Descripci&oacute;n","descripcionvotacion",$row["descripcionvotacion"],1,6,60)?> </p>
			<p> <?php echo $obj->dateTimeBox("Fecha y hora de inicio de la votaci&oacute;n","fechainiciovotacion",$row["fechainiciovotacion"],1)?> </p>
			<p> <?php echo $obj->dateTimeBox("Fecha y hora de conclusi&oacute;n de la votaci&oacute;n","fechafinalvotacion",$row["fechafinalvotacion"],1)?> </p>
			<p> <?php echo $obj->dateBox("Fecha inicial de vigencia de la votaci&oacute;n","fechainiciovigenciacargoaspiracionvotacion",$row["fechainiciovigenciacargoaspiracionvotacion"],1)?> </p>
			<p> <?php echo $obj->dateBox("Fecha final de vigencia de la votaci&oacute;n","fechafinalvigenciacargoaspiracionvotacion",$row["fechafinalvigenciacargoaspiracionvotacion"],1)?> </p>
			<p> <?php echo $obj->select("Tipo de candidato","idtipocandidatodetalleplantillavotacion",$row["idtipocandidatodetalleplantillavotacion"],1,"select idtipocandidatodetalleplantillavotacion,nombretipocandidatodetalleplantillavotacion from tipocandidatodetalleplantillavotacion where codigoestado='100'")?> </p>
			<p> <?php echo $obj->select("Estado","codigoestado",$row["codigoestado"],1,"select codigoestado,nombreestado from estado")?> </p>
			<p>
				<?php echo $obj->hiddenBox("opc",$_REQUEST["opc"])?>
				<?php echo $obj->hiddenBox("acc",$_REQUEST["acc"])?>
				<?php echo $obj->hiddenBox("idvot",$_REQUEST["idvot"])?>
				<div id="submit">
					<button type="submit" style="cursor:pointer;">Guardar</button>
					<button type="button" style="cursor:pointer;margin-left:20px;" Onclick="history.back()">Volver</button>
				</div>
			</p>
<?php
		}
?>
</fieldset>
<div id="resultado"></div>
