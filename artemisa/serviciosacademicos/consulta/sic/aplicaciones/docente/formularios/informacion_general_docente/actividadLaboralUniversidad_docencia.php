<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all">ACTIVIDAD LABORAL EN LA UNIVERSIDAD PARA EL PERIODO <?php echo $_SESSION["codigoperiodosesion"]?><br><br>DOCENCIA<br><br>ASIGNATURAS DOCENTES</legend>
	<div class="CSSTableGenerator" >
		<table>
			<tr>
				<td>C&oacute;digo materia</td>
				<td>Materia</td>
				<td>Grupo</td>
				<td>N&uacute;mero horas</td>
			</tr>
<?php
			$res=$db->exec("select codigomateria
						,nombremateria
						,nombregrupo
						,numerohorassemanales
					from grupo g 
					join materia m using(codigomateria)
					join docente d using(numerodocumento)
					where d.iddocente='".$_SESSION["sissic_iddocente"]."'
						and g.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
						and g.codigoestadogrupo=10");
			while ($row=mysql_fetch_array($res)) {
?>
				<tr>
					<td align="center"><?php echo $row["codigomateria"]?></td>
					<td><?php echo $row["nombremateria"]?></td>
					<td><?php echo $row["nombregrupo"]?></td>
					<td align="center"><?php echo $row["numerohorassemanales"]?></td>
				</tr>
<?php
			}
?>
		</table>
	</div>
</fieldset>
