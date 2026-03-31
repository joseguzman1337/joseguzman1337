<?php
/*
 * Ajustes y creacion de function ciudad()
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 25 de Octubre de 2017.
 */

	require_once("../../../Connections/sala2.php");
	$rutaado = "../../../funciones/adodb/";
	require_once("../../../Connections/salaado.php");
        
	$nombres 	= $_REQUEST['Nombres'];
	$apellidos 	= $_REQUEST['Apellidos'];
	$email 		= $_REQUEST['Email'];
	$telefono 	= $_REQUEST['Telefono'];
	$ciudad 	= $_REQUEST['Ciudad'];
	$periodo 	= $_REQUEST['FechaInicio'];
	$origen 	= $_REQUEST['Origen'];
	$carrera 	= $_REQUEST['Programa'];
    $mensaje 	= ''; 
    
    
    $idpreinscripcion = consultaPreinscrito($db,$email,$periodo);
     
    $idciudad = ciudad($db,$ciudad);
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
                autorizacionpreinscripcion = '1' ";
				$result=$db->query($sql);
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
		$mensaje .= "Actualizado Correctamente ";
	}
	
	$idpreinscripcioncarrera = carreraPreinscripcion($db,$idpreinscripcion,$carrera);
	
	if(empty($idpreinscripcioncarrera)){
		$sqlCarrera = "INSERT INTO preinscripcioncarrera 
						SET idpreinscripcion='".$idpreinscripcion."', 
						codigocarrera='".$carrera."',
						codigoestado='100'";
        $result=$db->query($sqlCarrera);
	}else{
		$mensaje .= "Ya existe registro para este aspirante.";
	}
	
	echo $mensaje;

    /*
     * @modified Luis Dario Gualteros C.
     * <castroluisd@unbosque.edu.co>
     * Redirecionamiento al archivo conexionInfusionSoft.php para que realice la inserción de datos en el sistema de Mercadeo (InfusionSoft).
     * @since Abril 5, 2018.
    */ 

    require_once('../../interfacesinfusion/php5.3/conexionInfusionSoft.php');

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

	function ciudad($db, $codigosapciudad){
		$sql = "select idciudad from ciudad where codigosapciudad = '".$codigosapciudad."' ";
		$idCon=$db->query($sql);
		$idConsulta=$idCon->fetchRow();
		$dciudad=$idConsulta['idciudad'];
		return $dciudad;	
	}

//end	
?>