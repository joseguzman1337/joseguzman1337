<?php
	session_start();
    /*include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); */
    
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD();
    /*
    * Caso 87930
    * @modified Luis Dario Gualteros 
    * <castroluisd@unbosque.edu.co>
    * Se modificá la consulta para que muestre el nuevo campo de innovación para nueva funcionalidad de Innovación según
    * solicitud de Liliana Ahumada.
    * @since Marzo 6 de 2017
    */ 
    $SQL = 'SELECT
				*, SUM(HorasPAE) as sumapae, SUM(HorasTaller) as sumataller, SUM(HorasTIC) as sumatic, SUM(HorasInnovar) as sumaInnovar
			FROM
				PlanesTrabajoDocenteEnsenanza
			WHERE
            HorasTIC <> 0
            HorasInnovar <> 0
			OR HorasPAE <> 0
			AND codigoestado = 100
			GROUP BY
				iddocente, codigocarrera
			ORDER BY
			iddocente';
	if($Resultado=&$db->Execute($SQL)===false){
		echo 'Error en consulta a base de datos '.$SQL;
		die;    
	}
	
	if(!$Resultado->EOF){
		while(!$Resultado->EOF){
			$sql_insert="INSERT INTO PlanesTrabajoDocenteEnsenanza set codigocarrera = '".$Resultado->fields['codigocarrera']."', codigomateria = '1', 
                    iddocente = '".$Resultado->fields['iddocente']."', codigoperiodo = '".$Resultado->fields['codigoperiodo']."', HorasPresencialesPorSemana = '0', HorasPreparacion = '0', 
                    HorasEvaluacion = '0', HorasAsesoria = '0', HorasTIC = '".$Resultado->fields['sumatic']."',HorasInnovar = '".$Resultado->fields['sumaInnovar']."', HorasTaller = '".$Resultado->fields['sumataller']."', HorasPAE = '".$Resultado->fields['sumapae']."', FechaCreacion = '".date("Y-m-d H:i:s")."'";
					if($insertar_plandocente=&$db->Execute($sql_insert)===false){
						echo 'Error en la consulta '.$sql_insert.' <br />';
					}else{
						$last_id = $db->Insert_ID();
						echo 'plan trabajo - ';
						$sql_update_plan = "UPDATE PlanesTrabajoDocenteEnsenanza SET HorasTIC='0', HorasInnovar='0', HorasTaller='0', HorasPAE='0' WHERE (PlanTrabajoDocenteEnsenanzaId='".$Resultado->fields['PlanTrabajoDocenteEnsenanzaId']."')";
    /*END Caso 87930*/						
                        if($aa=&$db->Execute($sql_update_plan)===false){
							echo 'Error en la consulta '.$sql_update_plan.' <br />';
						}
						$sql_actividades = 'SELECT
												*
											FROM
												ActividadesPlanesTrabajoDocenteEnsenanza
											WHERE
												(
													TipoPlanTrabajoDocenteEnsenanzaId = 2
													OR TipoPlanTrabajoDocenteEnsenanzaId = 3
													OR TipoPlanTrabajoDocenteEnsenanzaId = 4
												)
											AND PlanTrabajoDocenteEnsenanzaId = '.$Resultado->fields['PlanTrabajoDocenteEnsenanzaId'];
						if($Actividades=&$db->Execute($sql_actividades)===false){
							echo 'Error en consulta a base de datos '.$sql_actividades.' <br />';							    
						}else{
							if(!$Actividades->EOF){
								while(!$Actividades->EOF){
									$sql_update_actividades = "UPDATE ActividadesPlanesTrabajoDocenteEnsenanza SET PlanTrabajoDocenteEnsenanzaId='".$last_id."' WHERE (ActividadPlanTrabajoDocenteEnsenanzaId='".$Actividades->fields['ActividadPlanTrabajoDocenteEnsenanzaId']."')";
									if($Update=&$db->Execute($sql_update_actividades)===false){
										echo 'Error en consulta a base de datos '.$sql_update_actividades.' <br />';							    
									}else{
										echo 'actividad<br />';
									}
									$Actividades->MoveNext();
								}
							}
						}
					}
			$Resultado->MoveNext();
		}		
	}
	$sql_update_plan = "UPDATE PlanesTrabajoDocenteEnsenanza SET HorasTIC='0', HorasInnovar ='0', HorasTaller='0', HorasPAE='0' WHERE (codigomateria <> '1')";
		if($aa=&$db->Execute($sql_update_plan)===false){
			echo 'Error en la consulta '.$sql_update_plan.' <br />';
		}
?>