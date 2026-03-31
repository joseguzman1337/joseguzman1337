<?php

//Explicacion de las validaciones

// Cada vez que se hace una sentencia SQL, se evalua si esa sentencia fue ejecutada correctamente
// Si no lo fue, se envia el error de la linea donde esta la validacion, el cual sera leido por el AJAX
// de la vista.

// Esto para garantizar la seguridad de la aplicacion y que el usuario no tenga acceso a los nombres de las
// tablas

require_once(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once(PATH_ROOT.'/kint/Kint.class.php');
}

require_once(PATH_SITE.'/lib/Factory.php');

$db = Factory::createDbo();

//funcion para enviar consultas a Sala Virtual
function enviarSalaVirtual($valores){

	global $Configuration;

	$url = "";
	$basicUrl = $Configuration->getHTTP_ROOT();
	$basicUrl = str_replace('artemisa','artemisavirtual',$basicUrl);
	$url = $basicUrl."/serviciosacademicos/consulta/estadisticas/matriculasnew/apirantesWeb.php";
		
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $valores);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec($curl);
	
	$output = json_decode($output,true);
	
    curl_close($curl);
    return $output;
}
    
    $nombres 	= $_REQUEST['Nombres'];
    $apellidos 	= $_REQUEST['Apellidos'];
    $email      = $_REQUEST['Email'];
    $telefono 	= $_REQUEST['Telefono'];
    $ciudad 	= $_REQUEST['Ciudad'];
    $periodo 	= $_REQUEST['FechaInicio'];
    $origen 	= $_REQUEST['Origen'];
    $carrera 	= $_REQUEST['Programa'];
    $mensaje 	= '';
	
		//si la carrera es de modalidad academica 800 u 810, redireccione la informacion a sala virtual
		$modalidadCarreraQuery = "select codigomodalidadacademica from carrera where codigocarrera=$carrera";

		$result = $db->GetRow($modalidadCarreraQuery);

		$modalidadCarrera = $result['codigomodalidadacademica'];

		if ($modalidadCarrera == '800' || $modalidadCarrera == '810') {
			$fields = array();

			$fields['Nombres'] = $_REQUEST['Nombres'];
			$fields['Apellidos'] = $_REQUEST['Apellidos'];
			$fields['Email'] = $_REQUEST['Email'];
			$fields['Ciudad'] = $_REQUEST['Ciudad'];
			$fields['Telefono'] = $_REQUEST['Telefono'];
			$fields['Programa'] = $_REQUEST['Programa'];
			$fields['FechaInicio'] = $_REQUEST['FechaInicio'];
			$fields['Origen'] = $_REQUEST['Origen'];

			$respuesta = enviarSalaVirtual($fields);
			$key = array_keys($respuesta);
			$key = $key[0];						
			respuestaJSON($key,$respuesta[$key]);
		}
    
    //Si el periodo viene vacío desde el Formulario se la asigna por defecto el periodo activo para Inscripciones.
    if($periodo == 'Fecha de ingreso'){
        $periodo = consultaPeriodo($db, $periodo);  
    }
    
    $idpreinscripcion = consultaPreinscrito($db,$email,$periodo);
    $idciudad = consultaCiudad($db,$ciudad);
    
	if(empty($idpreinscripcion)){
		$sql = "INSERT INTO preinscripcion SET fechapreinscripcion = CURDATE(),
				codigoperiodo = '".$periodo."', 
				idtrato = 1, 
				apellidosestudiante = '".$apellidos."', 
				nombresestudiante = '".$nombres."', 
				emailestudiante = '".$email."', 
				telefonoestudiante = '".$telefono."', 
				celularestudiante = '".$telefono."', 
				ciudadestudiante = '".$idciudad."', 
				codigoestadopreinscripcionestudiante = '300', 
				idusuario = '1',
				codigoestado= '100',
				codigoindicadorenvioemailacudientepreinscripcion= '100',
				idempresa = '1',				
				idtipoorigenpreinscripcion= '1',
                autorizacionpreinscripcion = '1',
				origen = '".$origen."' ";
                
				$result=$db->query($sql);

				
				if($result == false){
					respuestaJSON('error','90');
				}				

				$sql = "select MAX(idpreinscripcion) as id from preinscripcion a";
				$idUltimaInserccion=$db->query($sql);
				$idUltimaInserccion=$idUltimaInserccion->fetchRow();
				$idpreinscripcion=$idUltimaInserccion['id'];
		$mensaje .= "Insertado en Sala Correctamente ";
	}else{
		$sql = "UPDATE preinscripcion SET 
				idtrato = 1, 
				apellidosestudiante = '".$apellidos."', 
				nombresestudiante = '".$nombres."', 
				telefonoestudiante = '".$telefono."', 
				ciudadestudiante = '".$idciudad."', 
				codigoestadopreinscripcionestudiante = '300', 
				idusuario = '1',
				codigoestado= '100',
				codigoindicadorenvioemailacudientepreinscripcion= '100',
				idempresa = '1',
				idtipoorigenpreinscripcion= '1', 
				autorizacionpreinscripcion = '1' where idpreinscripcion = ".$idpreinscripcion;
				
				$result=$db->query($sql);				
				
				
				if($result == false){
					respuestaJSON('error','117');
				}
				
				
				
		$mensaje .= "Actualizado Correctamente";
	}
	
	$idpreinscripcioncarrera = carreraPreinscripcion($db,$idpreinscripcion,$carrera);
	
	if(empty($idpreinscripcioncarrera)){
		$sqlCarrera = "INSERT INTO preinscripcioncarrera 
						SET idpreinscripcion='".$idpreinscripcion."', 
						codigocarrera='".$carrera."',
						codigoestado='100'";
		$result=$db->execute($sqlCarrera);

		
		if($result == false){
			respuestaJSON('error','136');
		}
			
	}else{
		$mensaje .= " - Ya existe registro para este aspirante.";
	}
		   
	
	respuestaJSON('success', $mensaje);
	
	//============================================

	// Listado de funciones
    
    function consultaPreinscrito($db,$email = '',$periodo = ''){
		$sql = "select idpreinscripcion from preinscripcion where emailestudiante = '".$email."' and codigoperiodo = '".$periodo."' LIMIT 1";
		$idCon=$db->query($sql);
		$idConsulta=$idCon->fetchRow();
		$estudiante=$idConsulta['idpreinscripcion'];		
		return $estudiante;	
	}
	
	function carreraPreinscripcion($db, $idpreinscripcion, $carrera = 1){
		$sql = "select idpreinscripcioncarrera from preinscripcioncarrera where idpreinscripcion = '".$idpreinscripcion."' and codigocarrera = '".$carrera."'";
		$idCon=$db->query($sql);
		$idConsulta=$idCon->fetchRow();
		$carrera=$idConsulta['idpreinscripcioncarrera'];
		return $carrera;	
	}

	function consultaCiudad($db, $codigosapciudad){
		$sqlC = "select idciudad from ciudad where codigosapciudad = ".$codigosapciudad."";
    	$idConC=$db->query($sqlC);
		$idConsultaC=$idConC->fetchRow();
		$dciudad=$idConsultaC['idciudad'];
    	return $dciudad;	
	}
    
    function consultaPeriodo($db, $periodo){
       //Si el Periodo viene vacio se consulta el Periodo que se encuentra en estado de Inscripciones
       $SQL_periodo = "SELECT codigoperiodo FROM periodo WHERE codigoestadoperiodo = '4'";
       $resPeriodo = $db->GetRow($SQL_periodo);
       $periodo= $resPeriodo['codigoperiodo'];
		if($periodo!=''){
		return $periodo; 
		}else{
			$SQL_sigPeriodo = "SELECT codigoperiodo FROM periodo WHERE PeriodoId = (SELECT PeriodoId + 1 FROM periodo 
				WHERE codigoestadoperiodo = 1 )";
			$resPeriodosig = $db->GetRow($SQL_sigPeriodo);
			$periodoSig = $resPeriodosig['codigoperiodo'];
			return $periodoSig; 
		}
       
	}

	function respuestaJSON($tipo,$mensaje){

		$responseFinal = array();

		//como los tipos sólo pueden ser success o error, se asigna una llave valor
		//de manera que si es error quedara 'error'=>'mensaje de error'
		//o 'success'=>'exito'
		$responseFinal[$tipo] = $mensaje;
		

		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($responseFinal);
		exit();
	}   

?>