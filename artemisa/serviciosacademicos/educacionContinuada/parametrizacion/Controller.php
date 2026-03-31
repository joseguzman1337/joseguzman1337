<?php 
session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	
if($_POST['esAdmin']){
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
	include($rutaTemplate."template.php");
	$db = getBD();
	$main=new Controller();
	$main->main($db);	
}

class Controller{
	public function main($db){
		switch($_POST['action']){
			case 'consultaData':
				$this->consultaData($db);
			break;
			case 'deletePermiso':
				$this->deletePermiso($db);
			break;
			case 'ConsultarEstudiante':
				$this->consultaEstudiante($db);
			break;
			case 'guardarEstudiante':
				$this->guardarEstudiante($db);
			break;	
		}
		
	}
	
	public function consultaData($db){
		$Sql= "SELECT EG.numerodocumento,EG.nombresestudiantegeneral, EG.apellidosestudiantegeneral,C.nombrecarrera,C.fechainiciocarrera,
					EG.idestudiantegeneral
				FROM TemporalCarnetizacion T
				INNER JOIN estudiantegeneral EG on (T.idestudiantegeneral = EG.idestudiantegeneral)
				INNER JOIN estudiante E on(E.idestudiantegeneral=T.idestudiantegeneral)
				INNER JOIN carrera C on (C.codigocarrera = E.codigocarrera)
				WHERE C.codigomodalidadacademica = '400' 
				AND T.codigoestado = '100' GROUP BY (EG.numerodocumento)";
		
		if($data=&$db->GetAll($Sql) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		
		$html=null;
		$html="<table>  
					<th>Documento</th>	
					<th>Nombre Estudiante</th>	
					<th>Apellido Estudiante</th>
					<th>Curso</th>
					<th>Fecha Inicio</th>";
		foreach($data as $datos){
			$html.= "<tr><td>".$datos['numerodocumento']."</td>
						<td>".$datos['nombresestudiantegeneral']."</td>
						<td>".$datos['apellidosestudiantegeneral']."</td>
						<td>".$datos['nombrecarrera']."</td>
						<td>".$datos['fechainiciocarrera']."</td>";
			$html.= "<td><a class='delete' onclick='deletePermiso(".$datos['idestudiantegeneral'].");
					' id='".$dataP['idestudiantegeneral']."' >Eliminar</a></td></tr>";				
					
					
		}
		$html .= "</table>";
		echo ($html);
	}
	public function deletePermiso($db){	
		$idEstudiante = $_POST['idEstudiante'];
		/*Consultar que el permiso que se quiere eliminar no corresponda al principla "1"*/
		$sqlDelete = "UPDATE TemporalCarnetizacion SET codigoestado = 200 WHERE idestudiantegeneral = '".$idEstudiante."'";
		if ($delete = $db->Execute($sqlDelete) === false) {
			echo 'Error en el SQL de Delete';
			exit;
		}
	}
	public function consultaEstudiante($db){
			if($_POST['documento']){
				$Sql= "SELECT EG.numerodocumento,EG.nombresestudiantegeneral, EG.apellidosestudiantegeneral,C.nombrecarrera,C.fechainiciocarrera, EG.idestudiantegeneral
							FROM estudiantegeneral EG
							INNER JOIN  estudiante E ON (E.idestudiantegeneral = EG.idestudiantegeneral)
							INNER JOIN carrera C ON (C.codigocarrera = E.codigocarrera)
							WHERE C.codigomodalidadacademica = '400'
							AND EG.numerodocumento='".$_POST['documento']."'
							GROUP BY (EG.numerodocumento)";
				if($data=&$db->GetAll($Sql) === false){
					echo 'Ocurrio un error al consultar la data';
					die;
				}
			}
			if(!empty($data)){
				$html=null;
				$html="<table>  
						<th>Documento</th>	
						<th>Nombre Estudiante</th>	
						<th>Apellido Estudiante</th>
						<th>Curso</th>
						<th>Fecha Inicio</th>";
				foreach($data as $datos){
					$html.= "<tr><td>".$datos['numerodocumento']."</td>
								<td>".$datos['nombresestudiantegeneral']."</td>
								<td>".$datos['apellidosestudiantegeneral']."</td>
								<td>".$datos['nombrecarrera']."</td>
								<td>".$datos['fechainiciocarrera']."</td>";
				}
				$html .= "</table>";
			}
			echo ($html);			
	}
	public function guardarEstudiante($db){
			 $Sql= "SELECT EG.idestudiantegeneral
						FROM estudiantegeneral EG
						INNER JOIN  estudiante E ON (E.idestudiantegeneral = EG.idestudiantegeneral)
						INNER JOIN carrera C ON (C.codigocarrera = E.codigocarrera)
						WHERE C.codigomodalidadacademica = '400'
						AND EG.numerodocumento='".$_POST['documento']."'
						GROUP BY (EG.numerodocumento)";
			if($data=&$db->GetAll($Sql) === false){
				echo 'Ocurrio un error al consultar la data';
				die;
			}
			
			$idEstudiante = $data[0][0];
			
			$SqlValdia= "SELECT idestudiantegeneral
						FROM TemporalCarnetizacion
						WHERE idestudiantegeneral = '".$idEstudiante."'";
						
			if($dataExiste=&$db->GetAll($SqlValdia) === false){
				echo 'Ocurrio un error al consultar la data';
				die;
			}
			if(empty($dataExiste)){
				/*Consultar que el permiso que se quiere eliminar no corresponda al principla "1"*/
				$sqlDelete = "INSERT TemporalCarnetizacion(idestudiantegeneral,codigoestado) VALUES('".$idEstudiante."',100)  ";
				if ($delete = $db->Execute($sqlDelete) === false) {
					echo 'Error en el SQL insert';
					exit;
				}
			}else{
				$sqlUpdate = "UPDATE TemporalCarnetizacion SET codigoestado = '100' WHERE idestudiantegeneral = '".$idEstudiante."'  ";
				if ($update = $db->Execute($sqlUpdate) === false) {
					echo 'Error en el SQL update';
					exit;
				}
			}
		
	}
}

?>