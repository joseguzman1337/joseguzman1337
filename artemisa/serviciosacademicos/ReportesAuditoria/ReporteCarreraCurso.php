<?php 
global $db;

include("./templates/mainjson.php");


$Hora = date('Y-m-d');
		 
		 				header('Content-type: application/vnd.ms-excel');
						header("Content-Disposition: attachment; filename=".$Hora.".xls");
						header("Pragma: no-cache");
						header("Expires: 0");


$CodigoPeriodo_ini	='20051';
$CodigoPeriodo_fin	='20131';

$CodigoCarrera		= '10';
$CodigoCurso		= '13';

$SQL_Datos='SELECT DISTINCT 
			e.idestudiantegeneral AS id,
			e.codigoestudiante,
			e.codigocarrera
			
			FROM 
			estudiante e INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante 
						 INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula 
						 INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
			
			WHERE 
			op.codigoestadoordenpago LIKE "4%" 
			AND 
			e.codigocarrera="'.$CodigoCarrera.'"
			AND
			e.idestudiantegeneral IN(
									SELECT DISTINCT 
									e.idestudiantegeneral
									
									FROM 
									estudiante e INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante 
												 INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula 
												 INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
									
									WHERE 
									op.codigoestadoordenpago LIKE "4%"
									
									AND 
									e.codigocarrera="'.$CodigoCurso.'")';
			
			if($Datos=&$db->Execute($SQL_Datos)===false){
					echo 'Error en el SQl De Datos Primarios......<br><br>'.$SQL_Datos;
					die;
				}
		?>
        <table border="1" cellpadding="0" cellspacing="0" width="100%" align="center">
            <thead>
                <tr>
                    <th>Nombre Estudiante</th>
                    <th>N&deg; Documento</th>
                    <th>Periodo Curso Basico</th>
                    <th>Periodo Medicina</th>
                    <th>Programa Academico</th>
                    <th>Semestre</th>
                    <th>Situacion Academica</th>
                </tr>
            </thead>
            <tbody>
        <?PHP		
		while(!$Datos->EOF){
			/**************************************************************************************/
				 $SQL_DatosFinales='SELECT DISTINCT 
									e.idestudiantegeneral,
									e.codigoestudiante,
									op.codigoperiodo,
									c.codigocarrera,
									c.nombrecarrera, 
									concat(eg.apellidosestudiantegeneral," ",eg.nombresestudiantegeneral) as nombre,
									eg.numerodocumento, 
									eg.telefonoresidenciaestudiantegeneral, 
									eg.celularestudiantegeneral, 
									eg.emailestudiantegeneral, 
									e.semestre,
									e.codigosituacioncarreraestudiante,
									s.nombresituacioncarreraestudiante 
									
									FROM estudiante e INNER JOIN prematricula pr ON e.codigoestudiante=pr.codigoestudiante 
													  INNER JOIN ordenpago op ON op.idprematricula=pr.idprematricula 
													  INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
													  INNER JOIN carrera c on c.codigocarrera=e.codigocarrera 
													  INNER JOIN situacioncarreraestudiante s ON s.codigosituacioncarreraestudiante=e.codigosituacioncarreraestudiante
									
									WHERE 
									op.codigoestadoordenpago LIKE "4%"
									AND 
									e.idestudiantegeneral="'.$Datos->fields['id'].'" 
									AND
									c.codigocarrera IN ("'.$CodigoCarrera.'","'.$CodigoCurso.'")';
									
						if($Dato_All=&$db->Execute($SQL_DatosFinales)===false){
								echo 'Error en el SQl De Todosw Los Datos...<br><br>'.$SQL_DatosFinales;
								die;
							}
				if(!$Dato_All->EOF){
					while(!$Dato_All->EOF){
						$PeridodCarrera		= '---/---';
						$PeridodCursoBasico	= '---/---';
						if($Dato_All->fields['codigocarrera']==10){
							$PeridodCarrera	=  $Dato_All->fields['codigoperiodo'];
							}else if($Dato_All->fields['codigocarrera']==13){
								$PeridodCursoBasico	=  $Dato_All->fields['codigoperiodo'];
								}
					/******************************************************************************************/
					?>
                    <tr>
                    	<td><?PHP echo $Dato_All->fields['nombre']?></td>
                        <td><?PHP echo $Dato_All->fields['numerodocumento']?></td>
                        <td><?PHP echo $PeridodCursoBasico?></td>
                        <td><?PHP echo $PeridodCarrera?></td>
                        <td><?PHP echo $Dato_All->fields['nombrecarrera']?></td>
                        <td><?PHP echo $Dato_All->fields['semestre']?></td>
                        <td><?PHP echo $Dato_All->fields['nombresituacioncarreraestudiante']?></td>
                    </tr>
                    <?PHP
					$Dato_All->MoveNext();
					}
					/******************************************************************************************/
					}						
			/**************************************************************************************/
			$Datos->MoveNext();
			}		
?>
		</tbody>
	 </table>