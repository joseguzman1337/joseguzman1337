<?php
    /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
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
	
	//include '../control/ControlRol.php';
	include '../control/ControlItem.php';
	include '../control/ControlPeriodo.php';
	include '../control/ControlLineaEstrategica.php';
	include '../control/ControlPlanProgramaLinea.php';
	include '../control/controlAvancesIndicadorPlanDesarrollo.php';
	include '../control/ControlPrograma.php';
	include '../control/ControlProyecto.php';
	include '../control/ControlProgramaProyecto.php';
	include '../control/ControlIndicador.php';
	include '../control/ControlTipoIndicador.php';
	include '../control/ControlMeta.php';
        
	if($_POST){
		$keys_post = array_keys($_POST);
		foreach ($keys_post as $key_post) {
			if( is_array($_POST[$key_post]) ){
				$$key_post = $_POST[$key_post];
			}else{
				$$key_post = strip_tags(trim($_POST[$key_post]));
			}
		}
	}
	
	if($_GET){
	    $keys_get = array_keys($_GET); 
	    foreach ($keys_get as $key_get){
	    	if( is_array($_GET[$key_get]) ){ 
	        	$$key_get = $_GET[$key_get];
			}else{
				$$key_post = strip_tags(trim($_GET[$key_get]));
			}
	     } 
	}
	
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
	
	$controlPlanProgramaLinea = new ControlPlanProgramaLinea( $persistencia );	
	$controlPrograma = new ControlPrograma( $persistencia );
	$controlProyecto = new ControlProyecto( $persistencia );
	$controlIndicador = new ControlIndicador( $persistencia );
	$controlProgramaProyecto = new ControlProgramaProyecto( $persistencia );
	$controlMeta = new ControlMeta( $persistencia );
	$controlAvancesIndicadorPlanDesarrollo = new controlAvancesIndicadorPlanDesarrollo($persistencia );
	//echo "<pre>";print_r($_POST); exit( );

	switch( $tipoOperacion ){
		
		case "registrar":
			
			
			
			$controlPrograma->crearPrograma($txtPrograma, $justifiPrograma, $descPrograma, $txtResponsablePrograma, $idPersona , $txtResponsableProgramaEmail);
			$txtIdPrograma = $persistencia->lastId( );
			
			if( $cmbCarreraRegistrar != -1 ){
				$controlPlanDesarrollo = new ControlPlanDesarrollo( $persistencia );
				$planDesarrollo = $controlPlanDesarrollo->buscarPlanDesarrolloCarrera($cmbCarreraRegistrar);
				if( $planDesarrollo->getIdPlanDesarrollo( ) != "" ){
					$txtIdPlanDesarrollo = $planDesarrollo->getIdPlanDesarrollo( );
					$controlPlanProgramaLinea->crear($txtIdPlanDesarrollo, $cmbLineaEstrategica, $txtIdPrograma, $idPersona);
				}
				
			}else{
				$controlPlanProgramaLinea->crear($txtIdPlanDesarrollo, $cmbLineaEstrategica, $txtIdPrograma, $idPersona);
			}
			
			if( count( $txtProyecto ) > 1 ){
				$l = 0;
				foreach( $txtProyecto as $txtProyect ){
					
					$controlProyecto->crearProyecto($txtProyect, $justifiProyecto[$l], $descProyecto[$l], $objProyecto[$l], $accProyecto[$l], $txtResponsableProyecto[$l], $idPersona , $txtResponsableProyectoEmail[$l]);
					$txtIdProyecto = $persistencia->lastId( );
					
					$controlProgramaProyecto->crearProgramaProyecto( $txtIdPrograma, $txtIdProyecto, $idPersona );
					/*Modified Diego Rivera<riveradiego@unbosque.edu.co
					 *se añade parametro proyectoPlanDesarrolloId  en todas las instancias del $controlIndicador->crearMetaPrincipal con el fin de almacenar el id de proyecto en la meta principal
					 *se añade validacion en todas instacias  crearMetaSecundarias con el fin de que no inserte registros sin informacion
					 * Since April 10,2017
					 */
					
					
					if(count( $ckTipoIndicador[$l] ) > 1 ){
						$m = 0;
						foreach( $ckTipoIndicador[$l] as $ckTipoIndicado ){
							$txtIdTipoIndicador = $ckTipoIndicado;
							$controlIndicador->crearIndicadorPlanDesarrollo( $txtIdTipoIndicador, $txtIdProyecto, $txtIndicador[$l][$m], $idPersona );
							$txtIdIndicador = $persistencia->lastId( );
						
							$controlMeta->crearMetaPrincipal( $txtIdIndicador, $txtMetaPrincipal[$l][$m], $txtValorMetaPrincipal[$l][$m], $idPersona , $txtIdProyecto);
							$txtIdMetaPrincipal = $persistencia->lastId( );
							var_dump( $txtMeta ); exit( );
							if( count( $txtMeta[$l][$m] ) > 1 ){
								$n= 0;
								foreach( $txtMeta[$l][$m] as $txtMet ){
						
									if ( $txtMet == "") {
											
										$n++;	
									
									} else {
									
										$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMet, $txtFechaInicioMeta[$l][$m][$n], $txtFechaFinalMeta[$l][$m][$n], $txtValorMeta[$l][$m][$n], $txtAccionMeta[$l][$m][$n], $txtResponsableMeta[$l][$m][$n] , $idPersona , $txtResponsableMetaEmail[$l][$m][$n]);
										$n++;
									
									}
									
								}
							}else{
								if ( $txtMeta[$l][$m][0] != "" ){
									
							     		$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMeta[$l][$m][0], $txtFechaInicioMeta[$l][$m][0], $txtFechaFinalMeta[$l][$m][0], $txtValorMeta[$l][$m][0], $txtAccionMeta[$l][$m][0], $txtResponsableMeta[$l][$m][0], $idPersona , $txtResponsableMetaEmail[$l][$m][0]);
								
								}
							}
							$m++;
						}
							
							
						}else{
							
							$txtIdTipoIndicador = $ckTipoIndicador[$l][0];
							$controlIndicador->crearIndicadorPlanDesarrollo( $txtIdTipoIndicador, $txtIdProyecto, $txtIndicador[$l][0], $idPersona );
							$txtIdIndicador = $persistencia->lastId( );
							
							$controlMeta->crearMetaPrincipal( $txtIdIndicador, $txtMetaPrincipal[$l][0], $txtValorMetaPrincipal[$l][0], $idPersona , $txtIdProyecto );
							$txtIdMetaPrincipal = $persistencia->lastId( );
							/*if( count( $txtMeta[$l][0] ) > 1 ){
								$p= 0;
								foreach( $txtMeta[$l][0] as $txtMet ){
									
									if ( $txtMet == "" ){
										
										$p++;
										
									} else { 
									
										$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMet, $txtFechaInicioMeta[$l][0][$p], $txtFechaFinalMeta[$l][0][$p], $txtValorMeta[$l][0][$p], $txtAccionMeta[$l][0][$p], $txtResponsableMeta[$l][0][$p], $idPersona , $txtResponsableMetaEmail[$l][0][$p]);
										$p++;
									}
									
								}*/
							//}else{
								
						/*		if ( $txtMeta[$l][0][0] != "" ) {
									
									$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMeta[$l][0][0], $txtFechaInicioMeta[$l][0][0], $txtFechaFinalMeta[$l][0][0], $txtValorMeta[$l][0][0], $txtAccionMeta[$l][0][0], $txtResponsableMeta[$l][0][0], $idPersona , $txtResponsableMetaEmail[$l][0][0]);
								
								}*/
							//}
						}
					$l++;
				}
			}else{
			
			
				$controlProyecto->crearProyecto($txtProyecto[0], $justifiProyecto[0], $descProyecto[0], $objProyecto[0], $accProyecto[0], $txtResponsableProyecto[0], $idPersona , $txtResponsableProyectoEmail[0]);
				$txtIdProyecto = $persistencia->lastId( );
				
				$controlProgramaProyecto->crearProgramaProyecto( $txtIdPrograma, $txtIdProyecto, $idPersona );
				if(count( $ckTipoIndicador[0] ) > 1 ){
					$j = 0;
					foreach( $ckTipoIndicador[0] as $ckTipoIndicado ){
						$txtIdTipoIndicador = $ckTipoIndicado;
						$controlIndicador->crearIndicadorPlanDesarrollo( $txtIdTipoIndicador, $txtIdProyecto, $txtIndicador[0][$j], $idPersona );
						$txtIdIndicador = $persistencia->lastId( );
					
						$controlMeta->crearMetaPrincipal( $txtIdIndicador, $txtMetaPrincipal[0][$j], $txtValorMetaPrincipal[0][$j], $idPersona , $txtIdProyecto );
						$txtIdMetaPrincipal = $persistencia->lastId( );
						//var_dump( $txtMeta ); exit( );
						if( count( $txtMeta[0][$j] ) > 1 ){
							$k= 0;
							foreach( $txtMeta[0][$j] as $txtMet ){
								
								if ( $txtMet == "" ){
									
									$k++;
									
								} else {
								
									$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMet, $txtFechaInicioMeta[0][$j][$k], $txtFechaFinalMeta[0][$j][$k], $txtValorMeta[0][$j][$k], $txtAccionMeta[0][$j][$k], $txtResponsableMeta[0][$j][$k], $idPersona , $txtResponsableMetaEmail[0][$j][$k]);
									$k++;
								}
								
							}
						}else{
							
							if ( $txtMeta[0][$j][0] == "" ) {
								
								$j++;
								
							} else {
							
								$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMeta[0][$j][0], $txtFechaInicioMeta[0][$j][0], $txtFechaFinalMeta[0][$j][0], $txtValorMeta[0][$j][0], $txtAccionMeta[0][$j][0], $txtResponsableMeta[0][$j][0], $idPersona , $txtResponsableMetaEmail[0][$j][0]);
								$j++;
							}
								
						}
					
					}
					
					
				}else{
					
					$txtIdTipoIndicador = $ckTipoIndicador[0][0];
					$controlIndicador->crearIndicadorPlanDesarrollo( $txtIdTipoIndicador, $txtIdProyecto, $txtIndicador[0][0], $idPersona );
					$txtIdIndicador = $persistencia->lastId( );
					
					$controlMeta->crearMetaPrincipal( $txtIdIndicador, $txtMetaPrincipal[0][0], $txtValorMetaPrincipal[0][0], $idPersona , $txtIdProyecto );
					$txtIdMetaPrincipal = $persistencia->lastId( );
					if( count( $txtMeta[0][0] ) > 1 ){
						$i= 0;
						foreach( $txtMeta[0][0] as $txtMet ){
							
							if ( $txtMet  == "" ) {
								
								$i++;
								
							} else { 			
																																														                                                                		
								$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMet, $txtFechaInicioMeta[0][0][$i], $txtFechaFinalMeta[0][0][$i], $txtValorMeta[0][0][$i], $txtAccionMeta[0][0][$i], $txtResponsableMeta[0][0][$i], $idPersona ,$txtResponsableMetaEmail[0][0][$i]);
								$i++;
							
							}
						}
					}else{
						if( $txtMeta[0][0][0] != "" ){
					
							$controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtMeta[0][0][0], $txtFechaInicioMeta[0][0][0], $txtFechaFinalMeta[0][0][0], $txtValorMeta[0][0][0], $txtAccionMeta[0][0][0], $txtResponsableMeta[0][0][0], $idPersona , $txtResponsableMetaEmail[0][0][0]);
						
						}
						
					}
						
				}
			
			}
		break;
		
		
		case "actualizar":
			//$controlMeta = new ControlMeta( $persistencia );
				
			 /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
			  *Se agrega  variable  $txtEmailPrograma  en le llamdo de $controlPrograma->actualizarPrograma
			  *Se agrega  variable  $txtEmailProyecto $controlProyecto->actualizarProyecto
			  *con el fin de actualizar el email de los responsables
			  *Since April 19 , 2017  
			  */
			$controlPlanProgramaLinea->actualizar( $cmbLineaActualizaEstrategica, $idPersona, $txtIdPrograma );
			$controlPrograma->actualizarPrograma( $txtActualizaPrograma, $justifiActualizaPrograma, $descActualizaPrograma, $txtResponsableActualizaPrograma, $idPersona, $txtIdPrograma , $txtEmailPrograma );
			$controlProyecto->actualizarProyecto( $txtActualizaProyecto, $justifiActualizaProyecto, $descActualizaProyecto, $objActualizaProyecto, $accActualizaProyecto, $txtResponsableActualizaProyecto, $idPersona, $txtIdProyecto , $txtEmailProyecto );
			$controlIndicador->actualizarIndicador( $ckTipoIndicador, $txtActualizaIndicador, $idPersona, $txtIdIndicador );
			$controlMeta->actualizarMeta( $txtMetaActualizaPrincipal, $txtValorMetaActualizaPrincipal, $txtVigenciaActualizaMetaPrincipal, $idPersona, $txtIdMetaPrincipal );
			$linea = $controlMeta->buscarMetaPlanDesarrollo( $txtIdMetaPrincipal  );
                        
                        if ( $txtEmailProyecto == $txtEmailProyectoActual ) {
                                
                        } else {
                            require_once '../../../sala/lib/PHPMailer/PHPMailerAutoload.php';
                            $html = '
                                    <html>
                                            <head>
                                                <style>
                                                    table, td, th {    
                                                            border: 1px solid #ddd;
                                                            text-align: left;
                                                    }

                                                    table {
                                                            border-collapse: collapse;
                                                            width: 100%;
                                                    }

                                                    th, td {
                                                            padding: 10px;
                                                    }
                                                </style>
                                            </head>
                                            <body>
                                            <page style="margin: 0; padding: 0; font-family: Verdana, Arial; font-size: 13px;">
                                            <div style="width: 100%;">
                                                <div style="width:100%; background-color: #364329; height: 95px;"><img style="margin-left: 50px; margin-top: 15px;" src="cid:logo" alt="logo" /></div>
                                                    <div style="width:80%; margin:auto;">
                                                        <div align="justify">
                                                            <table align="center" border="1">
                                                                <tr>
                                                                    <th colspan="6" align="center">
                                                                        <h2 align="center">Ha sido  asignado como responsable del  siguiente Proyecto:</h2>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Plan de desarrollo</th>	
                                                                    <th>Linea estrategica</th>												
                                                                    <th>Nombre programa</th>												
                                                                    <th>Nombre proyecto</th>	
                                                                </tr>
                                                                <tr>
                                                                    <td>'.$linea->getProgramaProyecto( )->getIdProgramaProyecto( )->getNombrePlanDesarrollo( ).'</td>
                                                                    <td>'.$linea->getProgramaProyecto( )->getPrograma( )->getLineaEstrategica( )->getNombreLineaEstrategica( ).'</td>
                                                                    <td>'.$txtActualizaPrograma.'</td>
                                                                    <td>'.$txtActualizaProyecto.'</td>
                                                                </tr>

                                                            </table>
                                                    </div>
                                                    <p>&nbsp;</p>
                                                    <hr />        
                                                    <p style="font-size: 11px;" align="center">Av. Cra 9 No. 131 A - 02 &middot; Edificio Fundadores &middot; L&iacute;nea Gratuita 018000 113033 &middot; PBX (571) 6489000 &middot; Bogot&aacute; D.C. - Colombia.</p>
                                                </div>
                                            </div>
                                            </page>
                                            </body>
                                            </html>';

                                    $address = 'no-responder@unbosque.edu.co';
                                    $mail = new PHPMailer;
                                    $mail->setFrom($address, 'Universidad El Bosque');
                                    $mail->isHTML(true);
                                    $mail->Subject = "Nuevo responsable de proyecto - Sistema Plan de Desarrollo";
                                    $mail->Body = $html;
                                    $emails = explode(",",$txtEmailProyecto);
                                    $mail->AddEmbeddedImage('../funciones/logonegro.png', 'logo');
                                        foreach($emails as $emails=>$valor){
                                           $mail->AddAddress(trim($valor),'Universidad El Bosque');
                                           
                                           if(!$mail->Send()) {
                                                echo "Mailer Error: " . $mail->ErrorInfo;
                                           }else{

                                           }
                                        }       
                                    //$mail->AddAddress( $txtEmailProyecto,'Universidad El Bosque');
                                    
                        }
                        
                        if( !empty( $txtActualizaMeta ) ){

                            if( count( $txtActualizaMeta ) > 1 ){
                                    $i= 0;
                                    foreach( $txtActualizaMeta as $txtActualizaMet ){
                                            if( !empty( $txtActualizaMet ) ){
                                                    $controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtActualizaMet, $txtFechaActualizaInicioMeta[$i], $txtFechaActualizaFinalMeta[$i], $txtActualizaValorMeta[$i], $txtActualizaAccionMeta[$i], $txtActualizaResponsableMeta[$i], $idPersona , $txtemailResponsableMeta[$i]);
                                                    $i++;
                                            }
                                    }
                            }else{
                                    if( !empty( $txtActualizaMeta[0] ) ){
                                            $controlMeta->crearMetaSecundarias($txtIdMetaPrincipal, $txtActualizaMeta[0], $txtFechaActualizaInicioMeta[0], $txtFechaActualizaFinalMeta[0], $txtActualizaValorMeta[0], $txtActualizaAccionMeta[0], $txtActualizaResponsableMeta[0], $idPersona , $txtemailResponsableMeta[0]);	
                                    }
                            }
                        }
			
		break;
		
		case "nuevaObservacion":
		$controlAvancesIndicadorPlanDesarrollo->actualizarobservacion( $idMetaSecundaria ,  $observacion , $aprobacion);
		
		break;
			
		case "aprobacion":
			
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *Se añaden funciones  verSecundarias  y actualizarAvanceMetaPrincipal con el fin de calacular el avance de la meta principal respecto a las metas secundarias
		 *Since March 28,2017
		 */
		
	
		$valorAvance = $controlAvancesIndicadorPlanDesarrollo->AvancePorId( $metaSecundaria );
		$avance = $valorAvance->getValorAvance();	
		$controlMetaSecundaria = new  ControlMeta( $persistencia );	
		$controlMetaSecundaria->actualizaAvanceMetaSecundaria( $avance , 0 , $idPersona, $metaSecundaria );
		 
		$metasAsociadas = $controlMetaSecundaria->verSecundarias( $idMetaPrincipal );
		 
			$valorAvanceReal = 0;
						
				foreach ($metasAsociadas as $mSecundarias){
						$alcanceSecundaria = $mSecundarias->getValorMetaSecundaria( );
						$avanceSecundaria = $mSecundarias->getAvanceResponsableMetaSecundaria( );
						
					/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
					 *se quita validacion la cual calculaba el avance de la meta principla  sobre el 100%  de la meta secundaria ahora realiza el calculo asi supere el 100% de la meta secundaria* 
					 *Since March 30,2017 
					 * */	
						
					/*	if( $avanceSecundaria > $alcanceSecundaria ){
								$avanceSecundaria = $alcanceSecundaria;
								}
						*/	
							$valorAvanceReal = $valorAvanceReal + $avanceSecundaria;
						}
		
			$controlMetaSecundaria->actualizarAvanceMetaPrincipal( $valorAvanceReal , $idMetaPrincipal );
			$controlAvancesIndicadorPlanDesarrollo->actulaizarAprobacion( $metaSecundaria , $valor );
			
					
			echo $variables = $idMetaPrincipal.'_'.$metaSecundaria.'_'.$valorAvanceReal.'_'.$avance;
			
			//fin modificacion
			
		break;	
		
		case "nAprobacion":
		/*include_once ("../funciones/funciones.php");
		$funciones = new funciones();
		echo $funciones->alertaNoAprobado(1);
		*/
                //echo $valor;
                $controlAvancesIndicadorPlanDesarrollo->actulaizarAprobacion( $metaSecundaria , $valor );
		echo 'NO';
			
		break;
		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
		*Se añade case  eliminarAprobacion  lo cual  permite actualizar los avances de la meta principal y avance anual ,actualiza tabla avancesindicadorplandesarrollo cambiando estado aprobao a vacio
		*/
		case "eliminarAprobacion":
		$valor ="";
		$controlAvancesIndicadorPlanDesarrollo-> actualizarAprobacionEliminar( $metaSecundaria );
		$valorAvance = $controlAvancesIndicadorPlanDesarrollo->AvancePorId( $metaSecundaria );
		$avance = 0;	
		$controlMetaSecundaria = new  ControlMeta( $persistencia );	
		$controlMetaSecundaria->actualizaAvanceMetaSecundaria( $avance , 0 , $idPersona, $metaSecundaria );
		 
		$metasAsociadas = $controlMetaSecundaria->verSecundarias( $idMetaPrincipal );
		 
			$valorAvanceReal = 0;
						
				foreach ($metasAsociadas as $mSecundarias){
						$alcanceSecundaria = $mSecundarias->getValorMetaSecundaria( );
						$avanceSecundaria = $mSecundarias->getAvanceResponsableMetaSecundaria( );
						$valorAvanceReal = $valorAvanceReal + $avanceSecundaria;
						}
		
			$controlMetaSecundaria->actualizarAvanceMetaPrincipal( $valorAvanceReal , $idMetaPrincipal );
			$controlAvancesIndicadorPlanDesarrollo->actulaizarAprobacion( $metaSecundaria , $valor );
			
				
			echo $variables = $idMetaPrincipal.'_'.$metaSecundaria.'_'.$valorAvanceReal.'_'.$avance;




		break;	
		//fin
	}
	
?>