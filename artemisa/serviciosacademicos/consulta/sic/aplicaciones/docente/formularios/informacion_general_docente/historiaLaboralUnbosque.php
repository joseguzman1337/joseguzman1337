<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">HISTORIAL LABORAL UNBOSQUE</legend>
	<div class="CSSTableGenerator" >
		<table>
			<tr>
				<td>N&uacute;mero contrato</td>
				<td>Horas por semana</td>
				<td>Tipo contrato</td>
				<td>Centro beneficio</td>
				<td>Carrera</td>
				<td>Fecha inicio</td>
				<td>Fecha final</td>
				<td>Escalaf&oacute;n</td>
			</tr>
<?php
			$res=$db->exec("select	 horasxsemanadetallecontratodocente
						,nombretipocontrato
						,nombrecentrobeneficio
						,nombrecarrera
						,fechainiciocontratodocente
						,fechafinalcontratodocente
						,nombreescalafon
					from contratodocente cd
					,tipocontrato tc
					,detallecontratodocente dc
					,carrera c
					,centrobeneficio cb
					,escalafon e
					where cd.iddocente='".$_SESSION["sissic_iddocente"]."'
						and cd.idcontratodocente=dc.idcontratodocente
						and dc.codigocarrera=c.codigocarrera
						and tc.codigotipocontrato=cd.codigotipocontrato
						and cb.codigocentrobeneficio=dc.codigocentrobeneficio
						and tc.codigoestado like '1%'
						and cd.codigoestado like '1%'
						and e.codigoescalafon=cd.codigoescalafon
					order by fechainiciocontratodocente
						,fechafinalcontratodocente");
			$i=1;
			while ($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td><?=$i?></td>
					<td><?=$row["horasxsemanadetallecontratodocente"]?></td>
					<td><?=$row["nombretipocontrato"]?></td>
					<td><?=$row["nombrecentrobeneficio"]?></td>
					<td><?=$row["nombrecarrera"]?></td>
					<td><?=$row["fechainiciocontratodocente"]?></td>
					<td><?=$row["fechafinalcontratodocente"]?></td>
					<td><?=$row["nombreescalafon"]?></td>
				</tr>
<?php
				$i++;
			}
?>
		</table>
	</div>
</fieldset>
