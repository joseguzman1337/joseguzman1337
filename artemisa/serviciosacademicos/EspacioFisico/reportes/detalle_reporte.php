<?php
	session_start();
	include_once ('../templates/template.php');
	$db = getBD();
	$id = $_REQUEST['id'];
	$HoraInicio = $_REQUEST['HoraInicio'];
	$HoraFin = $_REQUEST['HoraFin'];
	$porcentaje = $_REQUEST['porcentaje'];
	$fechas = explode(',',$_REQUEST['fecha']);
		
		$SQL = 'SELECT
				l.Ocupado,
				c.Nombre AS Aula,
				cc.Nombre AS Bloque,
				ccc.Nombre AS Sede,
				a.HoraInicio,
				a.HoraFin,
				car.codigomodalidadacademica
			FROM
				AsignacionEspacios a
			INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
			INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
			INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
			AND ccc.ClasificacionEspaciosId = 4
			INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
			INNER JOIN carrera car ON s.codigocarrera = car.codigocarrera
			LEFT JOIN LogsMonitoreosEspaciosFisicos l ON a.AsignacionEspaciosId = l.AsignacionEspaciosId
			WHERE
				a.FechaAsignacion BETWEEN "'.$fechas[0].'"
			AND "'.$fechas[1].'"
			AND a.codigoestado = 100
			AND c.codigoestado = 100
			AND cc.codigoestado = 100
			AND ccc.codigoestado = 100
			AND a.HoraInicio = "'.$HoraInicio.'"
			AND a.HoraFin = "'.$HoraFin.'"';
			if($id == 2){
				$SQL .= 'AND c.Nombre= "Falta por Asignar"';
			}
			if($id == 3){
				$SQL .= 'AND l.Ocupado IS NULL AND c.Nombre <> "Falta por Asignar"';
			}
			if($id == 4){
				$SQL .= 'AND l.Ocupado <> ""';
			}
			$SQL .= ' ORDER BY
				a.HoraInicio,
				a.HoraFin, Aula;';
	if($Resultado=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL;
		die;
	}
?>
	<style>
		a {
			text-decoration: none;
		}
	</style>
	<div align="center"><h3>Reporte desde <?php echo $fechas[0]; ?> hasta <?php echo $fechas[1]; ?> entre las horas <?php echo $HoraInicio; ?> y <?php echo $HoraFin; ?> por modalidad acad&eacute;mica</h3></div>
	<table align="center" cellpadding="5" border="1">
		<tr>
			<?php
				if($id == 1){
					echo '<th>Modalidad</th>
						<th>% No asignado</th>
						<th>% Asignado ocupado</th>
						<th>% Asignado no ocupado</th>
						<th>Numero de aulas</th>';
				}else{
					echo '<th>Modalidad</th>
						<th>Porcentaje</th>
						<th>Porcentaje base</th>
						<th>Numero de aulas</th>';
				}
				
			?>
		</tr>
		<tr>
		<?php 		
			if(!$Resultado->EOF){
				$modalidad = array();
				$total = 0;
				while(!$Resultado->EOF){					
					if(!in_array($Resultado->fields['codigomodalidadacademica'], $modalidad[$Resultado->fields['codigomodalidadacademica']])){						
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['codigo'] = $Resultado->fields['codigomodalidadacademica'];
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['no_asigando'] = 0;
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['ocupados'] = 0;	
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['totales'] = 0;	
					}					
					if($Resultado->fields['Aula'] == 'Falta por Asignar'){
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['no_asigando']++;
					}elseif($Resultado->fields['Ocupado'] != 'no'){
						$modalidad[$Resultado->fields['codigomodalidadacademica']]['ocupados']++;
					}
					$modalidad[$Resultado->fields['codigomodalidadacademica']]['totales']++;
					$total++;
					$Resultado->MoveNext();					
				}
				$SQL='SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica';
				if($Resultado=&$db->Execute($SQL)===false){
					echo 'Error en consulta a base de datos'.$SQL;
					die;
				}
				$tabla_modalidad = $Resultado->getarray();
				foreach($tabla_modalidad as $tm){
					if(in_array($tm['codigomodalidadacademica'], $modalidad[$tm['codigomodalidadacademica']])){						
						$porcentaje_ocupados = round(($modalidad[$tm['codigomodalidadacademica']]['ocupados'] * 100)/$total, 3);
						$porcentaje_noasignados = round(($modalidad[$tm['codigomodalidadacademica']]['no_asigando'] * 100)/$total, 3);
						$porcentaje_noocupado = round(100 - $porcentaje_noasignados - $porcentaje_ocupados, 3);		
					}
					if($id == 1){
						if(in_array($tm['codigomodalidadacademica'], $modalidad[$tm['codigomodalidadacademica']])){	
							$porcentaje_base = ($porcentaje * $porcentaje_noasignados)/100;
							echo '<tr>
									<td>'.$tm['nombremodalidadacademica'].'</td>';
							echo '<td>'.$porcentaje_noasignados.' %</td><td>'.$porcentaje_ocupados.' %</td><td>'.$porcentaje_noocupado.' %</td>
								<td>'.$modalidad[$tm['codigomodalidadacademica']]['totales'].'</td>
								</tr>';
						}
					}
					if($id == 2){
						if(in_array($tm['codigomodalidadacademica'], $modalidad[$tm['codigomodalidadacademica']])){
							$porcentaje_base = ($porcentaje * $porcentaje_noasignados)/100;
							echo '<tr>
									<td>'.$tm['nombremodalidadacademica'].'</td>
									<td>'.$porcentaje_noasignados.' %</td>
									<td>'.$porcentaje_base.' %</td>
									<td>'.$modalidad[$tm['codigomodalidadacademica']]['totales'].'</td>
								</tr>';
						}
					}if($id == 3){
						if(in_array($tm['codigomodalidadacademica'], $modalidad[$tm['codigomodalidadacademica']])){
							$porcentaje_base = ($porcentaje * $porcentaje_ocupados)/100;
							echo '<tr>
								<td>'.$tm['nombremodalidadacademica'].'</td>
								<td>'.$porcentaje_ocupados.' %</td>
								<td>'.$porcentaje_base.' %</td>
								<td>'.$modalidad[$tm['codigomodalidadacademica']]['totales'].'</td>
							</tr>';
						}
					}if($id == 4){
						if(in_array($tm['codigomodalidadacademica'], $modalidad[$tm['codigomodalidadacademica']])){
							$porcentaje_base = ($porcentaje * $porcentaje_noocupado)/100;
							echo '<tr>
								<td>'.$tm['nombremodalidadacademica'].'</td>
								<td>'.$porcentaje_noocupado.' %</td>
								<td>'.$porcentaje_base.' %</td>
								<td>'.$modalidad[$tm['codigomodalidadacademica']]['totales'].'</td>
							</tr>';
						}
					}
				}
			}			
		?>
		</tr>
	</table>
	<p>&nbsp;</p>
	<table align="center" cellpadding="5" border="1">
		<tr>
			<th>Porcentaje total</th>
			<th>Porcentaje base total</th>
			<th>Total aulas</th>
		</tr>
		<tr>
			<td>100 %</td>
			<td><?php echo $porcentaje ?> %</td>
			<td><?php echo $total; ?></td>
		</tr>
	</table>
	<table align="center" cellpadding="5" border="1">
		<tr>
			<td><a href="resultado_ocupacion.php?fecha=<?php echo $_REQUEST['fecha']; ?>&sede=<?php echo $_REQUEST['sede']; ?>"><< Regresar</a></td>
		</tr>
	</table>
	