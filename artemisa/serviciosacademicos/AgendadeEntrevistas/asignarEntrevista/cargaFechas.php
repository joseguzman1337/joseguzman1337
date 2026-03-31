<?php
 require('../../Connections/sala2.php');
 require('../../funciones/funcionpassword.php');
 $rutaado = '../../funciones/adodb/';
 require('../../Connections/salaado.php');
 require("../funciones/funcionAsignacionEntrevista.php");

 	$valor = "";
 	$carrera = "";
 	$jornada = "";

	 if( isset( $_REQUEST['valor'] ) ) {
		$valor = mysql_real_escape_string( $_REQUEST['valor'] ); 	
	 }

	 if( isset( $_REQUEST['carrera'] ) ) {
	 	$carrera = mysql_real_escape_string( $_REQUEST['carrera'] );
	 }


	 if( isset( $_REQUEST['jornada'] ) ) {
	 	$jornada = mysql_real_escape_string( $_REQUEST['jornada'] );
	 }
 
	$accion = mysql_real_escape_string( $_REQUEST['accion'] );


	if( $accion == "verFechas" ){ 
		dias ( $db , $valor , $carrera , $jornada );

	} else if ( $accion == "insertar" ){

		$idEstudianteCarreraInscripcion = $_REQUEST['idEstudianteCarreraInscripcion'];
                
                /*@Modified Diego Rivera<riveradiego@unbosque.edu.co>
                 *Se añade variable $numeroRegistro con el fin de identificar si existe un registro para el id $idEstudianteCarreraInscripcion en estado 400
                 *@Since October 23,2018
                 */
                $numeroRegistro = contarRegistro($db,$idEstudianteCarreraInscripcion);
                $valorEntevistaId = $_REQUEST['valorEntevistaId'];
		$usuarioCrea = $_SESSION['idReferente'];
                if( $numeroRegistro["numeroRegistro"] == 0 ){
                    guardar( $db , $valorEntevistaId , $idEstudianteCarreraInscripcion , $usuarioCrea );	

                }else{
                    return 1;
                }
		
	} else if ( $accion == "eliminar" ){

		 $entrevistaAsignacionId = $_REQUEST['entrevistaAsignacionId'];
	 	 $usuarioCrea = $_SESSION['idReferente'];
	 	 $observacion =  mysql_real_escape_string( $_REQUEST['observacion'] );
	 	 eliminar( $db , $entrevistaAsignacionId ,  $usuarioCrea , $observacion );

	} else if ( $accion == "actualizar" ){

		 $entrevistaAsignacionId = $_REQUEST['entrevistaAsignacionId'];
	 	 $valorEntrevistaId = $_REQUEST['valorEntrevistaId'];
	 	 $observacion = mysql_real_escape_string( $_REQUEST['observacion'] );
	 	 $usuarioCrea = $_SESSION['idReferente'];
     	 actualizar ( $db , $entrevistaAsignacionId , $valorEntrevistaId , $usuarioCrea , $observacion );
     	
	}

?>