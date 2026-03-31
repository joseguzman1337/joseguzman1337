<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package servicio
 */

 	header ('Content-type: text/html; charset=utf-8');
	header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	ini_set('display_errors','On');
	
	
	session_start( );
	
	include '../tools/includes.php';
	
	include '../control/ControlCarrera.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlFacultad.php';
	include '../control/ControlTipoDocumento.php';
	include '../control/ControlContacto.php';
	include '../control/ControlEstudiante.php';
	include '../control/ControlTrabajoGrado.php';
	include '../control/ControlConcepto.php';
	include '../control/ControlDocumentacion.php';
	include '../control/ControlFechaGrado.php';
	include '../control/ControlPazySalvoEstudiante.php';
	include '../control/ControlPreMatricula.php';
	include '../control/ControlClienteWebService.php';
	include '../control/ControlCarreraPeople.php';
	include '../control/ControlActaAcuerdo.php';
	include '../control/ControlIncentivoAcademico.php';
	include '../control/ControlActaGrado.php';
	include '../control/ControlRegistroGrado.php';
	require_once('../../../kint/Kint.class.php');
	
	function unserializeForm($str) {
    	$strArray = explode("&", $str);
	    foreach($strArray as $item) {
	        $array = explode("=", $item);
	        $returndata[] = $array[1];
	    }
	    return $returndata;
	}
	
	function unserializeForm3($str) {
		$data = array( );
    	$strArray = explode("&", $str);
	    foreach($strArray as $item) {
	        $array = explode("=", $item);
	        $returndata[] = $array[1];
			
	    }
		foreach( $returndata as $arr ){
			if( $arr != ""){
				$data[count( $data ) ] = $arr;
			}
		}
		
	    return $data;
	}
	
	function getRealIP() {
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
	        return $_SERVER['HTTP_CLIENT_IP'];
	       
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
	   
	    return $_SERVER['REMOTE_ADDR'];
	}
		
	//d($_POST);
	if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			$$key_post = strip_tags(trim($_POST[$key_post]));
		}
	}
	
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){ 
	        $$key_get = strip_tags(trim($_GET[$key_get])); 
	     } 
	}
	
	
	if( isset ( $_SESSION["datoSesion"] ) ){
		$user = $_SESSION["datoSesion"];
		$idPersona = $user[ 0 ];
		$luser = $user[ 1 ];
		$lrol = $user[3];
		$persistencia = new Singleton( );
		$persistencia = $persistencia->unserializar( $user[ 4 ] );
		$persistencia->conectar( );
	}else{
		header("Location:error.php");
	}
	
	$controlActaAcuerdo = new ControlActaAcuerdo( $persistencia );
	$controlActaGrado = new ControlActaGrado( $persistencia );
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	
	switch ($tipoOperacion) {
		
		case "registrarGrado":
			
			$txtNumeroActaGrado = $txtCodigoCarrera."AG0";
			if( $txtCodigoEstudiantes != ""){
				$txtCodigoEstudiantes = unserializeForm( $txtCodigoEstudiantes );
				$txtNumeroDiplomas = unserializeForm3( $txtNumeroDiplomas );
				$cuenta = 0;
				if( count( $txtNumeroDiplomas ) == count( $txtCodigoEstudiantes ) ){
					foreach( $txtCodigoEstudiantes as $txtCodigoEstudiante ){
						
						$actaAcuerdo = $controlActaAcuerdo->buscarDetalleActaAcuerdoId($txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera);
						$txtIdAcuerdoActa = $actaAcuerdo->getIdActaAcuerdo( );
						$txtDireccionIp = getRealIP( );
						if( $txtIdAcuerdoActa != ""){
							
							$existeRegistroGrado = $controlRegistroGrado->buscarRegistroGradoEstudiante($txtCodigoEstudiante, $txtIdAcuerdoActa);
							
							/*
							 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
							 * Se agrego una consulta para validar si el # de diploma ya se asigno antes a este mismo usuario, esto para evitar que al doble clic
							 * se generen registros duplicados
							 * @since  December 19, 2016
							*/
							$consultarExisteRegistroGrado = $controlRegistroGrado->consultarExisteRegistroGrado($txtCodigoEstudiante, $txtIdAcuerdoActa, $txtNumeroDiplomas[$cuenta], $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona);
							if( empty($consultarExisteRegistroGrado) ){
								if( $existeRegistroGrado == 0 ){
									$txtNumeroActaGrado = ++$txtNumeroActaGrado;
									$controlActaGrado->crearActaGrado( $txtNumeroActaGrado, $idPersona );
									$txtIdActaGrado = $persistencia->lastId( );
									$controlRegistroGrado->crearRegistroGrado($txtCodigoEstudiante, $txtIdActaGrado, $txtIdAcuerdoActa, $txtNumeroDiplomas[$cuenta], $txtNumeroPromocion, $txtIdDirectivo, $txtDireccionIp, $idPersona);
									$controlEstudiante = new ControlEstudiante( $persistencia );
									$controlEstudiante->actualizarSituacionCarreraEstudiante( $txtCodigoEstudiante );
								}
							}
							/* END */
							
						}
						//echo $txtCodigoEstudiante." ".$txtNumeroDiplomas[$cuenta]." ".$txtNumeroActaGrado." ";
						$cuenta = $cuenta + 1; 
					}
				}else{
					echo "0";
				}
			}else{
				echo "1";
			}
			
			
		break;
		
		
		case "eliminarRGrado":
			
			$detalleAcuerdo = $controlActaAcuerdo->buscarDetalleActaId( $txtIdActa, $txtCodigoEstudiante );
			$txtIdDetalleActa = $detalleAcuerdo->getIdDetalleActaAcuerdo( );
			
			$controlRegistroGrado->anularRegistroGrado( $txtIdRegistroGrado, $txtCodigoEstudiante, $txtIdDetalleActa );
			
		break; 
		
		case "actualizarDiploma":
			
			$controlRegistroGrado->actualizarDiploma($txtIdRegistroGrado, $txtNumeroDiplomaAnterior, $txtObservacionDiploma, $txtNumeroDiploma2, $txtCodigoEstudiante);
			
		break; 
            
                case "registrarGradoDistancia":
                     
                        $actaAcuerdo = new ActaAcuerdo( $persistencia ); 
                        $detalleActaAcuerdo = new DetalleActaAcuerdo( $persistencia );
                        $fechaGrado = new FechaGrado( null );
			$estudiante = new Estudiante( $persistencia );
		        $txtNumeroActaGrado ="EA";
                
                        $existeGrado = $controlRegistroGrado->consultarRegistroGradoFormulario( $codigoEstudiante );
                                                
                        $controlActaGrado->crearActaGrado( $txtNumeroActaGrado, $idPersona );
                        $txtIdActaGrado = $persistencia->lastId( );
                        $insertoActa=mysql_affected_rows();                        
                        if($insertoActa==1){
                            
                            $actaAcuerdo->setNumeroAcuerdo( $idNumeroAcuerdo );
                            $actaAcuerdo->setNumeroActa( $numeroActa );
                            $actaAcuerdo->setNumeroActaConsejoDirectivo( $numeroActaCF );
                            $actaAcuerdo->setFechaActa( $fechaAcuerdoCF );
                            $actaAcuerdo->setFechaAcuerdo( $fechaAcuerdo );
                            $fechaGrado->setIdFechaGrado( $cmbFechaGradoDistancia  );			
                            $actaAcuerdo->setFechaGrado( $fechaGrado );
                       
                            $controlActaAcuerdo->crearActaAcuerdoDistancia( $actaAcuerdo , $idPersona );
                            $idActaAcuerdo = $persistencia->lastId( );
                            $insertoAcuerdo=mysql_affected_rows();
                            
                            if($insertoAcuerdo==1){
                                $detalleActaAcuerdo->setDirectivo($directivo);
                                
				$actaAcuerdo->setIdActaAcuerdo( $idActaAcuerdo );
				$estudiante->setCodigoEstudiante( $codigoEstudiante );
				
				$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
				$detalleActaAcuerdo->setEstudiante( $estudiante );
                                
                                $controlActaAcuerdo->crearDetalleActaAcuerdoDistancia( $detalleActaAcuerdo , $idPersona );
                                $insertoDetalleAcuerdo=mysql_affected_rows();
                                
                                if( $insertoDetalleAcuerdo == 1){
                                    $txtDireccionIp = getRealIP( );
                                    $controlRegistroGrado->crearRegistroGrado($codigoEstudiante, $txtIdActaGrado, $idActaAcuerdo, $numeroDiploma, "No Aplica", $directivo, $txtDireccionIp, $idPersona);
                                    $insertarGrado= mysql_affected_rows();
                                    if($insertarGrado==1){
                                        echo "1";
                                    }else{
                                        echo "2";
                                    }
                                 } else {
                                    echo "2";
                                    }
                            } else {
                                echo "2";
                            }
                        }else {
                            echo "2";
                      }                       
                break;
		
	}
?>