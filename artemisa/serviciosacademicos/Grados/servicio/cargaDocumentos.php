
<?php
/**
 * @author Diego Rivera <riveradiego@unbosque.edu.co>
 * @copyright  Desarrollo Tecnologico
 * @package servicio
 */
	ini_set('display_errors','On');
	
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
	include '../control/ControlClienteCorreo.php';

	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	 *Se incluye ControlRegistroGrado.php con el fin de poder utilizar la clase registrogrado y funciones 
	 *Since July 
	 */
 	include '../servicio/funciones.php';
	include '../control/ControlRegistroGrado.php';
	//fin modificacion
	
	
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
	
	$controlRegistroGrado = new ControlRegistroGrado( $persistencia );
	
	$no_permitidas = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
	$permitidas = array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	$fileTypes = array('pdf');
	
	$ruta = "";
	$duplicado = "";
	$tamanioArchivo = "";
	$tipoInvalido = "";
	$correcto = "";
	$archivosCorrecto = 0;
	$contadorDuplicado = 0;
	$contadorTamanioArchivo = 0;
	$contadorTipoInvalido = 0;
	$filtroDigitalizar = "";
	$encabezadoTablaInvalido = "";
	$encabezadoTablaDuplicado = "";
	$encabezadoTablaTamanio = "";
	$encabezadoTablaCorrecto = "";
	$detalleTablaInvalido = "";
	$detalleTablaDuplicado = "";
	$detalleTablaTamanio = "";
	$detalleTablaCorrecto = "";
	$pieTabla = "</tbody></table>";
	
		
	if( !empty( $_FILES ) ) {
	    $cuenta = count($_FILES);			
		for( $i = 0; $i < $cuenta ; $i++ ) {
		      $fileName = str_replace( $no_permitidas , $permitidas , basename($_FILES["fileToUpload".$i]["name"] ) );
			  $identificaRuta = substr( $fileName, 0, 3 );		
				/*verificacion de archivos:
				 *  Diplomas:        	DP
					Acta de Grado:   	AG
					Incentivo:          IA
					Mención de Honor:   MH
					Mención Meritoria:  MM
					Grado de Honor:	    GH
					Cum Laude:	        CL
					Mangna Cum Laude:	MC
					Suma Cum Laude:	    SC
					Laureada:          	LA
					Certificados Cal:   CN
					Énfasis:    	    EN*/					

				if( $identificaRuta == "DP_" ) {
						$ruta="../documentos/Diplomas/";	
				} else if( $identificaRuta == "AG_" ) {
							$ruta="../documentos/Acta de Grado/";
							
				} else if( $identificaRuta == "IA_" ) {
							$ruta="../documentos/Incentivo/";
					
				} else if( $identificaRuta == "MH_" ) {
							$ruta="../documentos/Mencion de Honor/";
							
				} else if( $identificaRuta == "MM_" ) {
							$ruta="../documentos/Mencion Meritoria/";
							
				} else if( $identificaRuta == "GH_" ) {
							$ruta="../documentos/Grado de Honor/";
							
				} else if( $identificaRuta == "CL_" ) {
							$ruta="../documentos/Cum Laude/";
							
				} else if( $identificaRuta == "MC_" ) {
							$ruta="../documentos/Mangna Cum Laude/";
							
				} else if( $identificaRuta == "SC_" ) {
							$ruta="../documentos/Suma Cum Laude/";
							
				} else if( $identificaRuta == "LA_" ) {
							$ruta="../documentos/Laureada/";
							
				} else if( $identificaRuta == "CN_" ) {
							$ruta="../documentos/Certificados Cal/";
							
				} else if( $identificaRuta == "EN_" ) {
							$ruta="../documentos/Enfasis/";
				}else{
					$ruta = "";
				}
				
				/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
				 *Se agregan variables y funciones   str_replace, substr con el fin de identificar el codigo del estudiante a traves del nombre del archivo pdf
				 *Since July 14 , 2017 
				 */
				 $codigoEstudiante = str_replace( '.pdf','',$fileName );
				 $codigoEstudiante = substr( $codigoEstudiante , 3 );
				 $filtroDigitalizar = ' E.codigoestudiante='.$codigoEstudiante;
				 //fin modificacion
				$contador=1;
				if( $ruta == "" ){
						$tipoInvalido.=  $fileName .'<br>';
						$contadorTipoInvalido = 1;
						$uploadOk = 0;		
						$detalleTablaInvalido.= detalleTabla( "N/A" , "N/A" , "N/A" , $fileName );
						
				} else {
						$fileParts = pathinfo( $_FILES["fileToUpload".$i]["name"] );
						$target_file = $ruta . $fileName;
						$check = $fileParts["extension"];
					
						if ( in_array( strtolower( $check ), $fileTypes ) ){
					        $uploadOk = 1;
					    } else {
					        $uploadOk = 0;
							$imprime = '-3';
							$tipoInvalido.=  $fileName .'<br>';
							$contadorTipoInvalido = 1;
							$detalleTablaInvalido.= detalleTabla( "N/A" , "N/A" , "N/A" , $fileName );
					    }
				    
					    if ( $_FILES["fileToUpload".$i]["size"] > 10000000 ) {
				    	    $uploadOk = 0;
							$imprime = "-2";
							$tamanioArchivo.= $fileName.'<br>';
							$contadorTamanioArchivo = 1;
							
								if ( is_numeric( $codigoEstudiante ) ) {
									     $verArchivosTamanio = $controlRegistroGrado->consultarRegistroGradoDigitalizar ( $filtroDigitalizar );
									     	
										foreach ( $verArchivosTamanio  as $tamanio) {
												$codigo = $tamanio->getEstudiante( )->getCodigoEstudiante( );
												$nombre = $tamanio->getEstudiante( )->getNombreEstudiante( );
												$carrera = $tamanio->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( );
												$detalleTablaTamanio.= detalleTabla( $codigo , $nombre , $carrera , $fileName );
										}

								} else {
												$detalleTablaTamanio.= detalleTabla( "N/A" , "N/A" , "N/A" , $fileName );
								}
							
						}
						
						if ( file_exists( $target_file ) ) {

							   $duplicado.= $fileName."<br>";
							   $contadorDuplicado = 1;
							   $uploadOk = 0;
							   $verArchivosDuplicados = $controlRegistroGrado->consultarRegistroGradoDigitalizar ( $filtroDigitalizar );
							 	
								foreach ( $verArchivosDuplicados  as $duplicados) {
										$codigo = $duplicados->getEstudiante( )->getCodigoEstudiante( );
										$nombre = $duplicados->getEstudiante( )->getNombreEstudiante( );
										$carrera = $duplicados->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( );
										$detalleTablaDuplicado.= detalleTabla( $codigo , $nombre , $carrera , $fileName );
								  }
									
							}
					
						if ( $uploadOk == 0) {
													
						}else {
								if ( move_uploaded_file( $_FILES["fileToUpload".$i]["tmp_name"], $target_file ) ) {
							 		$archivosCorrecto = 1;
									$verArchivosCorrectos = $controlRegistroGrado->consultarRegistroGradoDigitalizar ( $filtroDigitalizar );
									$contadorTamanioArchivo = 0;	
									$contadorTipoInvalido = 0;
									$contadorDuplicado = 0;
									foreach ( $verArchivosCorrectos  as $correcto ) {
											$codigo = $correcto->getEstudiante( )->getCodigoEstudiante( );
											$nombre = $correcto->getEstudiante( )->getNombreEstudiante( );
											$carrera = $correcto->getActaAcuerdo( )->getFechaGrado( )->getCarrera( )->getNombreCarrera( );
											$detalleTablaCorrecto.= detalleTabla( $codigo , $nombre , $carrera , $fileName );
									  }
									
							 	}
						}
				  }
			 }
		}

			if ( $archivosCorrecto == 1 and $contadorTipoInvalido == 0 and $contadorTamanioArchivo == 0 and $contadorDuplicado == 0 ) {
					$encabezadoTablaCorrecto = encabezadoTabla( " Archivos cargados correctamente " );
				    $mesanjeAlerta = $encabezadoTablaCorrecto.$detalleTablaCorrecto.$pieTabla.'<br><br>';
			
			}  else if ( $archivosCorrecto == 1 and  ( $contadorTipoInvalido <> 0 or $contadorTamanioArchivo <> 0 or $contadorDuplicado <> 0 ) ){
					$encabezadoTablaCorrecto = encabezadoTabla( " Archivos cargados correctamente " );
				    $mesanjeAlerta = $encabezadoTablaCorrecto.$detalleTablaCorrecto.$pieTabla.'<br><br>';
			
			} else{
					$mesanjeAlerta = "";
			}
					
			if ( $contadorTipoInvalido == 1 ) {
					$encabezadoTablaInvalido =encabezadoTabla( " Nombre de archivos no validos y/o formato de archivo no valido ");
					$mesanjeAlerta.= $encabezadoTablaInvalido.$detalleTablaInvalido.$pieTabla.'<br><br>';
			}
			
			if ( $contadorTamanioArchivo == 1 ) {
					$encabezadoTablaTamanio = encabezadoTabla( " Tamaño de archivos supera al permitido " );
					$mesanjeAlerta.= $encabezadoTablaTamanio.$detalleTablaTamanio.$pieTabla.'<br><br>';
			}

			if ( $contadorDuplicado == 1 ) {
					$encabezadoTablaDuplicado = encabezadoTabla( " Duplicados " );
					$mesanjeAlerta.= $encabezadoTablaDuplicado.$detalleTablaDuplicado.$pieTabla.'<br><br>';
			}	
			
		

			echo $formulario = "
								<form method='POST' action='../servicio/reporteNovedades.php' id='verArchivo'>
									<textarea style='display:none' name='contenido'>".$mesanjeAlerta."</textarea>
									<a href='#' id='CargarReporte'>Generar Reporte</a>
								</form>";
			
?>