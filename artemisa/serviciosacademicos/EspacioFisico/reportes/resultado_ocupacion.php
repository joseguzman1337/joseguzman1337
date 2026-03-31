<?php
	session_start();
	include_once ('../templates/template.php');
	$db = getBD();
	if($_REQUEST['fecha']){
		$fechas = explode(',',$_REQUEST['fecha']);
		$inicio = $fechas[0];
		$fin = $fechas[1];
	}else{
		$inicio = $_REQUEST['FechaInicio'];
		$fin = $_REQUEST['FechaFin'];
	}
	$sede = $_REQUEST['sede'];
	$SQL = 'SELECT
				l.Ocupado,
				c.Nombre AS Aula,
				cc.Nombre AS Bloque,
				ccc.Nombre AS Sede,
				a.HoraInicio,
				a.HoraFin
			FROM
				AsignacionEspacios a
			INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
			INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
			INNER JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId AND ccc.ClasificacionEspaciosId = '.$sede.'
			LEFT JOIN LogsMonitoreosEspaciosFisicos l ON a.AsignacionEspaciosId = l.AsignacionEspaciosId
			
			WHERE
				a.FechaAsignacion BETWEEN "'.$inicio.'"
			AND "'.$fin.'"
			AND a.codigoestado = 100
			AND c.codigoestado = 100
			AND cc.codigoestado = 100
			AND ccc.codigoestado = 100
			ORDER BY
				a.HoraInicio, a.HoraFin, Aula;';
	if($Resultado=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos'.$SQL ;
		die;    
	}
	?>
	<style>
		a {
			text-decoration: none;
		}
	</style>
	<div align="center"><h3>Reporte desde <?php echo $inicio; ?> hasta <?php echo $fin; ?></h3></div>
	<table align="center" cellpadding="5" border="1">
		<tr>
			<th>Hora Inicio</th>
			<th>Hora Fin</th>
			<th>% No asignado</th>
			<th>% Asignado ocupado</th>
			<th>% Asignado no ocupado</th>
		</tr>
		<tr>
	<?php
	if(!$Resultado->EOF){
		$hora_inicio = 0;
		$hora_fin = 0;
		$p = 0;
		while(!$Resultado->EOF){				
			if($Resultado->fields['HoraInicio'] != $hora_inicio || $Resultado->fields['HoraFin'] != $hora_fin){
				$porcentaje_ocupados = round(($ocupados * 100)/$i, 3);
				$porcentaje_noasignados = round(($no_asignado * 100)/$i, 3);
				$porcentaje_noocupado = round(100 - $porcentaje_noasignados - $porcentaje_ocupados, 3);	
				if($p != 0){
					echo '</td></tr>';
					echo '<tr><td align="center">';				
					echo '<a href="detalle_reporte.php?id=1&HoraInicio='.$hora_inicio.'&HoraFin='.$hora_fin.'&fecha='.$inicio.','.$fin.'&sede='.$sede.'">'.$hora_inicio.'</a></td><td align="center"><a href="detalle_reporte.php?id=1&HoraInicio='.$hora_inicio.'&HoraFin='.$hora_fin.'&fecha='.$inicio.','.$fin.'&sede='.$sede.'">'.$hora_fin.'</a></td><td align="center"><a href="detalle_reporte.php?id=2&HoraInicio='.$hora_inicio.'&HoraFin='.$hora_fin.'&fecha='.$inicio.','.$fin.'&sede='.$sede.'&porcentaje='.$porcentaje_noasignados.'">'.$porcentaje_noasignados.' %</a></td>
					<td align="center"><a href="detalle_reporte.php?id=3&HoraInicio='.$hora_inicio.'&HoraFin='.$hora_fin.'&fecha='.$inicio.','.$fin.'&porcentaje='.$porcentaje_ocupados.'&sede='.$sede.'">'.$porcentaje_ocupados.' %</a></td><td align="center"><a href="detalle_reporte.php?id=4&HoraInicio='.$hora_inicio.'&HoraFin='.$hora_fin.'&fecha='.$inicio.','.$fin.'&porcentaje='.$porcentaje_noocupado.'&sede='.$sede.'">'.$porcentaje_noocupado.' %</a></td>';
				}
				$hora_inicio = $Resultado->fields['HoraInicio'];
				$hora_fin = $Resultado->fields['HoraFin'];
				$ocupados = 0;
				$no_asignado = 0;
				$i = 0;			
				if($Resultado->fields['Aula'] == 'Falta por Asignar'){
					$no_asignado++;
				}elseif($Resultado->fields['Ocupado'] != 'no'){
					$ocupados++;
				}			
				$i++;
			}else{
				if($Resultado->fields['Aula'] == 'Falta por Asignar'){
					$no_asignado++;
				}elseif($Resultado->fields['Ocupado'] != 'no'){
					$ocupados++;
				}			
				$i++;
			}
			$Resultado->MoveNext();
			$p++;
		}
	}
?>
		</tr>
	</table>