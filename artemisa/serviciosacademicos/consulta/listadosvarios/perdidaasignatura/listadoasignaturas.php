<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$codigocarrera = $_REQUEST['codigocarrera'];
$codigoperiodo = $_REQUEST['codigoperiodo'];
$semestre = 0;
if(isset($_REQUEST['exportar'])) {
    $formato = 'xls';
    $nombrearchivo = "Perdida_Asignaturas";
    $strType = 'application/msexcel';
    $strName = $nombrearchivo.".xls";

    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");
}
/*$SQL = 'SELECT
			m.nombremateria,
			g.idgrupo,
			g.nombregrupo,
			p.codigoestudiante
		FROM
			grupo g
		INNER JOIN materia m ON m.codigomateria = g.codigomateria
		INNER JOIN detalleprematricula d ON d.idgrupo = g.idgrupo
		INNER JOIN prematricula p ON p.idprematricula = d.idprematricula
		WHERE
			g.codigoperiodo = '.$codigoperiodo.'
		AND m.codigocarrera = '.$codigocarrera.'
		AND g.codigoestadogrupo = 10
		AND d.codigoestadodetalleprematricula = 30
		AND p.codigoestadoprematricula IN (40, 41)
		GROUP BY
			m.codigomateria, g.codigogrupo
		ORDER BY
			m.nombremateria';
	$materias = $db->GetAll($SQL);*/
	
	$SQL = 'SELECT * FROM carrera where codigocarrera = '.$codigocarrera.' LIMIT 1';
	if($carrera=&$db->Execute($SQL)===false){
        echo 'ERROR '.$SQL;
    }
	
	/*$SQL = 'SELECT
			MAX(pla.idplanestudio) as plan
		FROM
			planestudio pla, periodo per
		WHERE
			codigocarrera = '.$codigocarrera.'
		AND pla.fechavencimientoplanestudio >= NOW()
		AND pla.codigoestadoplanestudio = 100
		AND pla.fechainioplanestudio <= per.fechainicioperiodo
		AND per.codigoperiodo = '.$codigoperiodo;
		//echo $SQL; 
	if($Resultado1=&$db->Execute($SQL)===false){
        echo 'ERROR '.$SQL;
    }
	
	$SQL = 'SELECT
				d.semestredetalleplanestudio, m.nombremateria, m.codigomateria, x.maxsemestre
			FROM
				detalleplanestudio d
			INNER JOIN materia m ON m.codigomateria = d.codigomateria
			INNER JOIN (SELECT MAX(semestredetalleplanestudio) as maxsemestre FROM detalleplanestudio WHERE
				idplanestudio = '.$Resultado1->fields['plan'].') as x 
			WHERE
				idplanestudio = '.$Resultado1->fields['plan'].'
			ORDER BY
				CAST(
					d.semestredetalleplanestudio AS SIGNED
				)';*/
				
	$SQL = 'SELECT
				d.semestredetalleplanestudio, m.nombremateria, m.codigomateria
			FROM
				detalleplanestudio d 
			INNER JOIN planestudio pes on pes.idplanestudio=d.idplanestudio 
					AND pes.codigocarrera = '.$codigocarrera.'
			INNER JOIN materia m ON m.codigomateria = d.codigomateria 
			INNER JOIN grupo g ON g.codigomateria=m.codigomateria and g.codigoperiodo='.$codigoperiodo.' AND g.codigoestadogrupo = 10
			INNER JOIN detalleprematricula dpr on dpr.idgrupo=g.idgrupo AND dpr.codigoestadodetalleprematricula = 30 
			INNER JOIN planestudioestudiante pe on pe.idplanestudio=d.idplanestudio 
			INNER JOIN prematricula pr on pr.idprematricula=dpr.idprematricula and pr.codigoperiodo='.$codigoperiodo.' AND pr.codigoestadoprematricula IN (40, 41) 
					AND pe.codigoestudiante=pe.codigoestudiante 
						INNER JOIN docente doc ON g.numerodocumento = doc.numerodocumento
						WHERE d.semestredetalleplanestudio<>0 
			GROUP BY codigomateria
			ORDER BY
				CAST(
					d.semestredetalleplanestudio AS SIGNED
				)';
				
				//echo $SQL; die;
	if($Resultado=&$db->Execute($SQL)===false){
        echo 'ERROR '.$SQL;
    } /*else if($Resultado->fields['maxsemestre']<2){
		$SQL = 'SELECT
				MAX(pla.idplanestudio) as plan
			FROM
				planestudio pla, periodo per
			WHERE
				codigocarrera = '.$codigocarrera.'
			AND pla.fechavencimientoplanestudio >= NOW()
			AND pla.codigoestadoplanestudio = 100
			AND pla.fechainioplanestudio <= per.fechainicioperiodo
			AND per.codigoperiodo = '.$codigoperiodo.' AND idplanestudio != '.$Resultado1->fields['plan'];
	
		if($Resultado1=&$db->Execute($SQL)===false){
			echo 'ERROR '.$SQL;
		}
		
		$SQL = 'SELECT
				d.semestredetalleplanestudio, m.nombremateria, m.codigomateria
			FROM
				detalleplanestudio d
			INNER JOIN materia m ON m.codigomateria = d.codigomateria
			WHERE
				idplanestudio = '.$Resultado1->fields['plan'].'
			ORDER BY
				CAST(
					d.semestredetalleplanestudio AS SIGNED
				)';
		
		if($Resultado=&$db->Execute($SQL)===false){
			echo 'ERROR '.$SQL;
		}
	}*/
?>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <?php
            if(!isset($_REQUEST['exportar'])){
      ?>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <?php
           }
         ?>
		 <style>
		 table.fixed{
			table-layout: fixed;
		 }
		 table.fixed td.small{			
			width: 5%;
			word-wrap: break-word;
		 }
		 table.fixed td.medium{			
			width: 20%;
		 }
		 table.fixed td.big{			
			width: 70%;
		 }
	</style>
    </head>
	<body>
		<table border="1" cellpadding="3" cellspacing="3" align="center">
			<tr>
				<td colspan="2" align="center">
					<label id="labelresaltadogrande" >PORCENTAJE DE PÉRDIDA POR ASIGNATURA <br><?php echo $carrera->fields['nombrecarrera'] ?> </label>
				</td>
			</tr>
			<?php while(!$Resultado->EOF){ 
				if($semestre != $Resultado->fields['semestredetalleplanestudio']){
					$semestre = $Resultado->fields['semestredetalleplanestudio'];
				
			?>
			<tr>
				<td colspan="2" align="center"><label id="labelresaltadogrande">Semestre <?php echo $semestre; ?></label></td>
			</tr>
			<tr>
				<td  colspan="2" align="left" bgcolor="#C5D5D6"><b>Asignatura</b></td>
            </tr>
			<?php 
				}
			?>				
		<?php 
				$SQL = 'SELECT
							m.nombremateria,
							m.codigomateria,
							g.idgrupo,
							g.nombregrupo,
							p.codigoestudiante,
							CONCAT(
								doc.apellidodocente," ",doc.nombredocente
							) AS nombredocente
						FROM
							grupo g
						INNER JOIN materia m ON m.codigomateria = g.codigomateria
						INNER JOIN detalleprematricula d ON d.idgrupo = g.idgrupo
						INNER JOIN prematricula p ON p.idprematricula = d.idprematricula
						INNER JOIN docente doc ON g.numerodocumento = doc.numerodocumento
						INNER JOIN estudiante e on e.codigoestudiante=p.codigoestudiante 
						WHERE
							g.codigoperiodo = '.$codigoperiodo.'
						AND e.codigocarrera = '.$codigocarrera.'
						AND m.codigomateria = '.$Resultado->fields['codigomateria'].'
						AND g.codigoestadogrupo = 10
						AND d.codigoestadodetalleprematricula = 30
						AND p.codigoestadoprematricula IN (40, 41)
						GROUP BY
							m.codigomateria, g.codigogrupo
						ORDER BY
							m.nombremateria';
							
							
                $Grupos = $db->GetAll($SQL);
				if(count($Grupos)>0 && $Grupos[0]['nombremateria'] != NULL && $Grupos[0]['nombremateria'] != ''){			
		
		?>	
		<tr>
			<td><?php echo $Grupos[0]['nombremateria']; ?></td>
			<td>
				<table border="1" cellpadding="3" cellspacing="3" align="center" width="100%" class="fixed">
					<tr>
						<td bgcolor="#C5D5D6" class="small"><b>Grupo</b></td>
						<td bgcolor="#C5D5D6" class="medium"><b>Docente</b></td>
						<td bgcolor="#C5D5D6" class="small"><b># Estudiantes</b></td>
						<td bgcolor="#C5D5D6" class="big"><b>Cortes</b></td>
					</tr>
					<?php
						foreach($Grupos as $G){
							//Total Estudiantes
							$SQL_total = 'SELECT count(distinct e.codigoestudiante) Total_Alumnos
								from detalleprematricula d
								inner join prematricula p on d.idprematricula = p.idprematricula
								inner join estudiante e on e.codigoestudiante = p.codigoestudiante
								where d.codigoestadodetalleprematricula = 30
								AND p.codigoestadoprematricula IN (40, 41)
								AND d.idgrupo = '.$G['idgrupo'].'
								AND d.codigomateria = '.$G['codigomateria'].'
								AND p.codigoperiodo = '.$codigoperiodo.'
							';
							$totalestudiantes = $db->GetAll($SQL_total);
							
							//Cortes
							$bandera = true; //primer intento
							$SQL_cortes = 'SELECT
												MAX(numerocorte) AS numerocorte
											FROM
												corte
											WHERE
												codigomateria = '.$G['codigomateria'].'
											AND codigoperiodo = '.$codigoperiodo;
							$cortes = $db->GetAll($SQL_cortes);
							if($cortes[0]['numerocorte'] != NULL && $cortes[0]['numerocorte'] != ''){
							}else{
								$SQL_cortes = 'SELECT
												MAX(numerocorte) AS numerocorte
											FROM
												corte
											WHERE
												codigocarrera = '.$codigocarrera.'
											AND codigoperiodo = '.$codigoperiodo;
								$cortes = $db->GetAll($SQL_cortes);
								$bandera = false;
							}
							echo '<tr>'
								.'<td class="small">'.$G['nombregrupo'].'</td>'
								.'<td class="medium">'.$G['nombredocente'].'</td>'
								.'<td class="small">'.$totalestudiantes[0]['Total_Alumnos'].'</td>'
								.'<td class="big">
									<table border="1" cellpadding="3" cellspacing="3" align="center" style="width:100%">
										<tr>';
											for($i=1;$i<=$cortes[0]['numerocorte'];$i++){
												echo '	<td bgcolor="#C5D5D6"><b># Perdieron C'.$i.'</b></td>
														<td bgcolor="#C5D5D6"><b>% Perdieron C'.$i.'</b></td>
														<td bgcolor="#C5D5D6" width="40%"><b>Estrategia C'.$i.'</b></td>';
													if($bandera == true){
														$SQL_perdidas = 'SELECT
																			COUNT(DISTINCT d.codigoestudiante) as perdieron,
																			(SELECT estrategiaasignatura FROM estrategiaasignatura WHERE codigomateria = '.$G['codigomateria'].'
																			AND numerocorte = '.$i.' AND codigoperiodo = '.$codigoperiodo.' 
																			AND idgrupo = '.$G['idgrupo'].') as estrategia
																		FROM
																			detallenota d
																		WHERE
																			codigomateria = '.$G['codigomateria'].'
																		AND idcorte = (SELECT idcorte FROM corte WHERE codigomateria = '.$G['codigomateria'].' 
																						AND codigoperiodo = '.$codigoperiodo.' AND numerocorte = '.$i.')
																		AND d.nota < (SELECT notaminimaaprobatoria from materia WHERE codigomateria = '.$G['codigomateria'].') AND  d.idgrupo = '.$G['idgrupo'].'';
																	
																		
													}else{
														$SQL_perdidas = 'SELECT
																			COUNT(DISTINCT d.codigoestudiante) as perdieron,
																			(SELECT estrategiaasignatura FROM estrategiaasignatura WHERE codigomateria = '.$G['codigomateria'].'
																			AND numerocorte = '.$i.' AND codigoperiodo = '.$codigoperiodo.' 
																			AND idgrupo = '.$G['idgrupo'].') as estrategia
																		FROM
																			detallenota d
																		WHERE
																			codigomateria = '.$G['codigomateria'].'
																		AND idcorte = (SELECT idcorte FROM corte WHERE codigocarrera = '.$codigocarrera.' 
																						AND codigoperiodo = '.$codigoperiodo.' AND numerocorte = '.$i.')
																		AND d.nota < (SELECT notaminimaaprobatoria from materia WHERE codigomateria = '.$G['codigomateria'].') AND  d.idgrupo = '.$G['idgrupo'].'';
																		
													}
													$perdidas = $db->GetAll($SQL_perdidas);
													$porcentaje = ($perdidas[0]['perdieron'] * 100) / $totalestudiantes[0]['Total_Alumnos'];
													if($porcentaje > 65){$color = '#FC1251';}//Rojo
													if($porcentaje > 40 && $porcentaje <=65){$color = '#FDF112';}//Amarillo
													if($porcentaje <= 40){$color = '#00D100';}//Verde
												echo '<tr>
													<td>'.$perdidas[0]['perdieron'].'</td>
													<td bgcolor="'.$color.'">'.round($porcentaje).'%</td>
													<td>'.$perdidas[0]['estrategia'].'</td>
												</tr>';
											}
										echo '</tr>										
									</table>
								</td>'
							.'</tr>';
						}
					?>
				</table>
			</td>
		</tr>
		<?php
				}
				$Resultado->MoveNext();
            }
		?>
		</table>
    </body>
</html>
