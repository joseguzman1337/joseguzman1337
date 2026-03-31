<?php 
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaz
 */


 ini_set('display_errors','On');
 require_once '../../../assets/Singleton.php';
 require_once '../entidades/Persona.php';
 require_once('../control/ControlUsuarioFacultad.php');
	

	session_start( );
 
			 if( isset ( $_SESSION["datoSesion"] ) ){
				$user = $_SESSION["datoSesion"];
				$idPersona = $user[ 0 ];
				$luser = $user[ 1 ];
				$lrol = $user[3];
				$txtCodigoFacultad = $user[4];
				$persistencia = new Singleton( );
				$persistencia = $persistencia->unserializar( $user[ 5 ] );
				$persistencia->conectar( );
			}else{
				header("Location:error.php");
			}
				
			$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
			$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
			
			
			//$email = str_replace( $no_permitidas , $permitidas , $email );
	
				$controlUsuarioFacultad = new ControlUsuarioFacultad( $persistencia );
				$emailValido = $controlUsuarioFacultad->VerNombreAutocompletar($_GET['term']);
				
				$return_arr = array();
				
				foreach ($emailValido as  $correo) {
					
					$row_array['value'] = $correo->getNombres( ).' '.$correo->getApellidos( );
					$row_array['txtEmail'] = $correo->getEmailUsuarioFacultad( );
					$row_array['txtActualizaResponsableMeta'] = $correo->getNombres( ).' '.$correo->getApellidos( );
				    array_push( $return_arr , $row_array );	
					
				}
				echo json_encode( $return_arr );
		


?>