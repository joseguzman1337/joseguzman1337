<table class="estiloSalonesOcupados">
	<tr>
		<th COLSPAN=7>ESPACIOS OCUPADOS</th>
	</tr>
<?php
// echo "<pre>"; print_r($_REQUEST);
foreach ($_REQUEST['ListaSalonesOcupados'] as $fecha => $arregloFecha) {
	?>
	<tr>
		<th>Fecha: <?php echo $fecha ?></th>
	</tr>
	<tr>
		<th>Ubicaci&oacute;n</th> 
		<th>Sal&oacute;n</th>
		<th>Tipo Sal&oacute;n</th>
		<th>Capacidad Estudiantes</th>
		<th>Acceso a Discapacitados</th>
		<th>Hora Inicio</th>
		<th>Hora Final</th>
	</tr>
	<?php
	foreach ($arregloFecha as $key => $arregloDatos) {
		echo "<tr>";
		foreach ($arregloDatos as $key => $value) {
			?>
			<td><?php echo $value; ?></td>
			<?php

		}
		echo "</tr>";
	}
}
?>
</table>