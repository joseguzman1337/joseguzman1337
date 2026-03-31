<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

ini_set('max_execution_time', 0);
ini_set('memory_limit', '192M');

require("../../templates/templateAutoevaluacion.php");
$db =writeHeaderBD(false);

$id_instrumento=$_REQUEST['id_ins'];

$sql_publico = "SELECT ao.idsiq_Apublicoobjetivo,ao.estudiante,ao.docente,ao.admin,csv.idsiq_Apublicoobjetivocsv 
					FROM siq_Apublicoobjetivo ao 
					LEFT JOIN siq_Apublicoobjetivocsv csv on csv.idsiq_Apublicoobjetivo=ao.idsiq_Apublicoobjetivo
					 and csv.codigoestado=100
					WHERE idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' and ao.codigoestado=100 
					GROUP BY ao.idsiq_Apublicoobjetivo";
						
$data_publico= $db->GetRow($sql_publico);

//EXTERNOS
if($data_publico["idsiq_Apublicoobjetivocsv"]!==null){
$sql_user = 'SELECT
                        
                        csv.cedula,
						idsiq_Apublicoobjetivocsv			
                        
                        FROM
                        siq_Apublicoobjetivocsv csv 
                        
                        WHERE
						csv.idsiq_Apublicoobjetivo="'.$data_publico["idsiq_Apublicoobjetivo"].'"  AND 
                        csv.codigoestado=100  ';
		$data_res= $db->Execute($sql_user);
		foreach($data_res as $dt_res){
			$actualizado = false;
			
			//verifico si es estudiante
			$sql = "SELECT eg.idestudiantegeneral FROM estudiantegeneral eg 
			INNER JOIN estudiante e on e.idestudiantegeneral=eg.idestudiantegeneral 
			INNER JOIN periodo p on p.codigoestadoperiodo=1 
			INNER JOIN prematricula pr on pr.codigoestudiante=e.codigoestudiante AND p.codigoperiodo=pr.codigoperiodo 
			WHERE pr.codigoestadoprematricula like '4%' AND eg.numerodocumento='".$dt_res["cedula"]."'";
			$resultado= $db->GetRow($sql);
			if(count($resultado)>0){
				$sql = "UPDATE `siq_Apublicoobjetivocsv` SET `estudiante`='1', `docente`='0', `padre`='0', 
				`vecinos`='0', `practica`='0', `docencia_servicio`='0', `administrativos`='0', `otros`='0' 
				WHERE (`idsiq_Apublicoobjetivocsv`='".$dt_res["idsiq_Apublicoobjetivocsv"]."')";
				$db->Execute($sql);
				$actualizado = true;
			}
			
			if(!$actualizado){
				//verifico si es docente 
			
				$sql = "SELECT iddocente FROM docente  
				WHERE numerodocumento='".$dt_res["cedula"]."' AND codigoestado=100";
				$resultado= $db->GetRow($sql);
				if(count($resultado)>0){
					$sql = "UPDATE `siq_Apublicoobjetivocsv` SET `estudiante`='0', `docente`='1', `padre`='0', 
					`vecinos`='0', `practica`='0', `docencia_servicio`='0', `administrativos`='0', `otros`='0' 
					WHERE (`idsiq_Apublicoobjetivocsv`='".$dt_res["idsiq_Apublicoobjetivocsv"]."')";
					$db->Execute($sql);
					$actualizado = true;
				}
			}				
			
			if(!$actualizado){
			//verifico si es egresado	
			
				$sql = "SELECT eg.idestudiantegeneral FROM estudiantegeneral eg  
				INNER JOIN estudiante e on e.idestudiantegeneral=eg.idestudiantegeneral AND e.codigosituacioncarreraestudiante=400 
				WHERE eg.numerodocumento='".$dt_res["cedula"]."'";
				$resultado= $db->GetRow($sql);
				if(count($resultado)>0){
					$sql = "UPDATE `siq_Apublicoobjetivocsv` SET `estudiante`='0', `docente`='0', `padre`='0', 
					`vecinos`='0', `practica`='0', `docencia_servicio`='0', `administrativos`='0', `otros`='1' 
					WHERE (`idsiq_Apublicoobjetivocsv`='".$dt_res["idsiq_Apublicoobjetivocsv"]."')";
					$db->Execute($sql);
					$actualizado = true;
				}
			}
			
			//toco administrativo entonces o.O
			if(!$actualizado){
			//toco administrativo entonces o.O
			
					$sql = "UPDATE `siq_Apublicoobjetivocsv` SET `estudiante`='0', `docente`='0', `padre`='0', 
					`vecinos`='0', `practica`='0', `docencia_servicio`='0', `administrativos`='1', `otros`='0' 
					WHERE (`idsiq_Apublicoobjetivocsv`='".$dt_res["idsiq_Apublicoobjetivocsv"]."')";
					$db->Execute($sql);
					$actualizado = true;
			}
		
		}
		echo "Acabe";
} else {
	echo "WTF!? no son externos. Ya acabe!";
}	

?>