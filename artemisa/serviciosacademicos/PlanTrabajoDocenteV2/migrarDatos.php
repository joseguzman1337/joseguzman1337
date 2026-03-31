<?php

/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/


header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
//var_dump($db);
if($db==null){
	include_once ('../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post] ; 
     } 
 }

 if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
 }
 
 $idDocente = $_POST["id_Docente"];
 
 
 /*$sqlCodigoPeriodoAnterior = "SELECT codigoperiodo 
								FROM periodo 
								WHERE codigoperiodo < 20161
								ORDER BY codigoperiodo DESC LIMIT 1";
 
 $periodoAnterior = $db->Execute( $sqlCodigoPeriodoAnterior );*/
 
 
 
 $codigoPeriodoAnterior = $_POST["codigoPeriodoAntiguo"];
 
 $codigoPeriodo = $_POST["codigoPeriodo"];
/*
* Caso 87930
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
* Se modificá la consulta para qeu muestre el nuevo campo de innovación para nueva funcionalidad de Innovación según
* solicitud de Liliana Ahumada.
* @since Marzo 6 de 2017
*/ 
 $sqlDatosAnteriores = "SELECT
							PlanTrabajoDocenteEnsenanzaId,
							codigocarrera,
							codigomateria,
							HorasPresencialesPorSemana,
							HorasPreparacion,
							HorasEvaluacion,
							HorasAsesoria,
							HorasTIC,
                            HorasInnovar,
							HorasTaller, 
							HorasPAE,
							TipoHoras
						FROM
							PlanesTrabajoDocenteEnsenanza
						WHERE
							codigoperiodo = $codigoPeriodoAnterior
						AND iddocente = $idDocente
						AND codigoestado = 100";
						
		
	$datosAnteriores = $db->Execute( $sqlDatosAnteriores );
	/*END Caso 87930*/
	/*$sqlExisteMigracion = "SELECT
									COUNT(PlanTrabajoDocenteEnsenanzaId) AS existe
								FROM
									PlanesTrabajoDocenteEnsenanza
								WHERE
									codigoperiodo = $codigoPeriodo
								AND iddocente = $idDocente
								AND codigoestado = 100";
	
	$existeMigracion = $db->Execute( $sqlExisteMigracion );
	
	$existeMigracion = $existeMigracion->fields["existe"];*/
	
 
 	$sqlDatosAnterioresOtros = "SELECT
								PlanTrabajoDocenteOtrosId,
								codigocarrera,
								HorasDedicadas,
								TipoPlanTrabajoDocenteOtrosId,
								VocacionesPlanesTrabajoDocenteId,
								Nombres,
								TipoHoras
							FROM
								PlanesTrabajoDocenteOtros
							WHERE
								codigoperiodo = $codigoPeriodoAnterior
							AND iddocente = $idDocente
							AND codigoestado = 100";
	
	
	$datosAnterioresOtros = $db->Execute( $sqlDatosAnterioresOtros );
	
	/*$sqlExisteMigracionOtros = "SELECT
								COUNT(PlanTrabajoDocenteOtrosId) AS existeOtros
							FROM
								PlanesTrabajoDocenteOtros
							WHERE
								codigoperiodo = $codigoPeriodo
							AND iddocente = $idDocente
							AND codigoestado = 100";
	
	$existeMigracionOtros = $db->Execute( $sqlExisteMigracionOtros );
	
	$existeMigracionOtros = $existeMigracionOtros->fields["existeOtros"];*/
	
	
	
	//if( $existeMigracion == 0 && $existeMigracionOtros == 0 ){
	
	foreach($datosAnteriores as $datosAnterior ){
		
					
				
			
		
		$idDatosAnteriores = $datosAnterior["PlanTrabajoDocenteEnsenanzaId"];
		
		$codigoCarrera = $datosAnterior["codigocarrera"];
		$codigoMateria = $datosAnterior["codigomateria"];
		$horaPresencial = $datosAnterior["HorasPresencialesPorSemana"];
		$horaPreparacion = $datosAnterior["HorasPreparacion"];
		$horaEvaluacion = $datosAnterior["HorasEvaluacion"];
		$horaAsesoria = $datosAnterior["HorasAsesoria"];
		$horaTic = $datosAnterior["HorasTIC"];
        $horaInnovar = $datosAnterior["HorasInnovar"];
		$horaTaller = $datosAnterior["HorasTaller"];
		$horaPAE = $datosAnterior["HorasPAE"];
		
		$tipoHoras = $datosAnterior["TipoHoras"];
		  /*
        * Caso 87930
        * @modified Luis Dario Gualteros 
        * <castroluisd@unbosque.edu.co>
        * Se modificá la consulta para qeu muestre el nuevo campo de innovación para nueva funcionalidad de Innovación según
        * solicitud de Liliana Ahumada.
        * @since Marzo 6 de 2017
        */ 
		$insertMigrar = "INSERT INTO PlanesTrabajoDocenteEnsenanza (
						codigocarrera,
						codigomateria,
						iddocente,
						codigoperiodo,
						HorasPresencialesPorSemana,
						HorasPreparacion,
						HorasEvaluacion,
						HorasAsesoria,
						HorasTIC,
                        HorasInnovar,                        
						HorasTaller,
						HorasPAE,
						Autoevaluacion,
						PlanDeMejoraConsolidacion,
						PlanDeMejoraOportunidades,
						codigoestado,
						FechaCreacion,
						FechaUltimaModificacion,
						TipoHoras
					)
					VALUES
						(
							$codigoCarrera,
							$codigoMateria,
							$idDocente,
							'$codigoPeriodo',
							$horaPresencial,
							$horaPreparacion,
							$horaEvaluacion,
							$horaAsesoria,
							$horaTic,
                            $horaInnovar,                            
							$horaTaller,
							$horaPAE,
							'',
							'',
							'',
							'100',
							NOW(),
							NOW(),
							'$tipoHoras'
						)";
		/*END Caso 87930*/
		$migracionDatos = $db->Execute( $insertMigrar );
		
		$plan_ensenanza = $db->Insert_ID();
		
		if($migracionDatos === false ){
			echo "Ha ocurrido un problema";
		}else{
			
			$sqlActividadesAnteriores = "SELECT
										ActividadPlanTrabajoDocenteEnsenanzaId,
										Nombre,
										TipoPlanTrabajoDocenteEnsenanzaId
									FROM
										ActividadesPlanesTrabajoDocenteEnsenanza
									WHERE
										PlanTrabajoDocenteEnsenanzaId = $idDatosAnteriores
										AND codigoestado = 100";
			
				$actividadesAnteriores = $db->Execute( $sqlActividadesAnteriores );
				
				
				
				
				foreach( $actividadesAnteriores as $actividadesAnterior ){
				
				$nombreActividad = $actividadesAnterior["Nombre"];
				$tipoPlanTrabajoActividad = $actividadesAnterior["TipoPlanTrabajoDocenteEnsenanzaId"];
				
				$insertActividadesEnsenanza = "INSERT INTO ActividadesPlanesTrabajoDocenteEnsenanza (
													Nombre,
													PlanTrabajoDocenteEnsenanzaId,
													codigoestado,
													FechaCreacion,
													FechaUltimaModificacion,
													TipoPlanTrabajoDocenteEnsenanzaId
												)
												VALUES
													('$nombreActividad', $plan_ensenanza, '100', NOW(), NOW(), $tipoPlanTrabajoActividad)";
				
				$migracionDatosActividad = $db->Execute( $insertActividadesEnsenanza );
				}
			
		}
		
		//echo "<pre>";print_r($insertMigrar);
		
		/*$sqlActividadesAnteriores = "SELECT
										Nombre,
										TipoPlanTrabajoDocenteEnsenanzaId
									FROM
										ActividadesPlanesTrabajoDocenteEnsenanza
									WHERE
										PlanTrabajoDocenteEnsenanzaId = $idDatosAnteriores";
			
		$actividadesAnteriores = $db->Execute( $sqlActividadesAnteriores );
			
		
		foreach( $actividadesAnteriores as $actividadesAnterior ){
			echo $actividadesAnterior["Nombre"]."<br>";
		}*/
		
	}
	
	foreach( $datosAnterioresOtros as $datoAnteriorOtro ){
			
		$idDatosAnterioresOtros = $datoAnteriorOtro["PlanTrabajoDocenteOtrosId"];
		
		$codigoCarrera = $datoAnteriorOtro["codigocarrera"];
		$horasDedicadas = $datoAnteriorOtro["HorasDedicadas"];
		$tipoPlanTrabajo = $datoAnteriorOtro["TipoPlanTrabajoDocenteOtrosId"];
		$vocacionesId = $datoAnteriorOtro["VocacionesPlanesTrabajoDocenteId"];
		$nombrePlan = $datoAnteriorOtro["Nombres"];
		
		
		$tipoHorasOtros = $datoAnteriorOtro["TipoHoras"];
				
		$insertMigrarOtros = "INSERT INTO PlanesTrabajoDocenteOtros (
								codigocarrera,
								iddocente,
								codigoperiodo,
								HorasDedicadas,
								TipoPlanTrabajoDocenteOtrosId,
								Autoevaluacion,
								PlanDeMejoraConsolidacion,
								PlanDeMejoraOportunidades,
								codigoestado,
								VocacionesPlanesTrabajoDocenteId,
								Nombres,
								FechaCreacion,
								FechaUltimaModificacion,
								TipoHoras
							)
							VALUES
								(
									$codigoCarrera,
									$idDocente,
									'$codigoPeriodo',
									$horasDedicadas,
									$tipoPlanTrabajo,
									'',
									'',
									'',
									'100',
									$vocacionesId,
									'$nombrePlan',
									NOW(),
									NOW(),
									'$tipoHorasOtros'
								)";
		
		//echo "<pre>";print_r($insertMigrarOtros);						
		$migracionDatosOtros = $db->Execute( $insertMigrarOtros );
		
		$plan_ensenanzaOtros = $db->Insert_ID();
		
		if($migracionDatosOtros === false ){
			echo "Ha ocurrido un problema";
		}else{
			
			$sqlActividadesAnterioresOtros = "SELECT
											ActividadPlanTrabajoDocenteOtrosId,
											Nombre
										FROM
											ActividadesPlanesTrabajoDocenteOtros
										WHERE
											PlanTrabajoDocenteOtrosId = $idDatosAnterioresOtros
										AND codigoestado = 100";
			
				$actividadesAnterioresOtros = $db->Execute( $sqlActividadesAnterioresOtros );
				
				
				
				
				foreach( $actividadesAnterioresOtros as $actividadesAnteriorOtro ){
				
				$nombreActividadOtro = $actividadesAnteriorOtro["Nombre"];
				
				$insertActividadesEnsenanzaOtro = "INSERT INTO ActividadesPlanesTrabajoDocenteOtros (
													Nombre,
													PlanTrabajoDocenteOtrosId,
													codigoestado,
													FechaCreacion,
													FechaUltimaModificacion
												)
												VALUES
													('$nombreActividadOtro', $plan_ensenanzaOtros, '100', NOW(), NOW())";
				
				$migracionDatosActividadOtro = $db->Execute( $insertActividadesEnsenanzaOtro );
				}
			
		}
		
		
		
	}

		if( $migracionDatosActividad === false && $migracionDatosActividadOtro === false){
				echo "Ha ocurrido un problema";
		}else{
			echo "Los datos fueron migrados exitosamente";
		}
	
	/*}else{
		echo "Ya existen datos para el período seleccionado";
	}*/
	
?>