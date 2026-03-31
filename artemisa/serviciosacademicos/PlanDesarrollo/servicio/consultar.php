<?php
    /**
   * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
   * @copyright Universidad el Bosque - DirecciÃ³n de TecnologÃ­a
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
  
  	require_once '../tools/includes.php';
	
	require_once '../control/ControlFacultad.php';
	require_once '../control/ControlPlanDesarrollo.php';
	require_once '../control/ControlUnidadAdministrativa.php';
 	require_once '../control/ControlPlanProgramaLinea.php';
	require_once '../control/ControlLineaEstrategica.php';
	require_once '../control/ControlPrograma.php';
	require_once '../control/ControlRender.php';
	

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
	
	$controlFacultad = new ControlFacultad( $persistencia );
	$controlUnidadAdministrativa = new ControlUnidadAdministrativa( $persistencia );
	$controlRender = new ControlRender();
	$controlplandesarrollo = new ControlPlanDesarrollo( $persistencia );	
        $controlPlanProgramaLinea = new ControlPlanProgramaLinea( $persistencia );   
 	$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia ); 
	$controlPrograma = new ControlPrograma( $persistencia );


	if($_POST["tipoOperacion"]== "consultar")
	{	
		switch($_POST['selectTipoReporte'])
		{
			case '1':
			{       
				$facultades = $_POST['cmbFacultadConsultar'];
				$codigoperiodo = $_POST['codigoperiodo'];
                                if ( $facultades == -1){
                                 echo "<script type=\"text/javascript\">alert(\"Seleccione una facultad\");</script>";  
                                } else {
                                    $facultad = explode("_",$facultades);

                                    if(sizeof( $facultad ) > 1){
                                        $facultadd = $facultad[0];
                                        $codigoCarrera = $facultad[1];

                                    }

                                    $lineas = $controlPlanProgramaLinea->verLinea( $facultadd, $codigoperiodo , $codigoCarrera );                
                                    $array['linea'] = $lineas;				
                                    $array['periodo']= $codigoperiodo;				
                                    $array['tiporeporte']= 1;
                                    $array['facultad']=$facultadd;
                                    $array['carrera']=$codigoCarrera;
                                    $controlRender->render('renderReporteFacultades',$array);
                                }
		
                        }break;
			
                        case '2': 
			{
                                if ( $_POST['cmbRectoria'] == -1){
                                    echo "<script type=\"text/javascript\">alert(\"Seleccione detalle\");</script>";  
                                } else {
                                    
                                    if($_POST['cmbRectoria']== 1)// consulta de los planes 
                                    {
                                            $plandesarrollo = $controlplandesarrollo->ConsultarPalnesDesarrollo();	
                                    }
                                    if($_POST['cmbRectoria']== 2)// consulta de las lienas
                                    {
                                            //$plandesarrollo =$controlplandesarrollo->buscarplandesarrolloreporte();	
                                    }								
                                    $codigoperiodo = $_POST['codigoperiodo'];
                                    $array['tiporeporte']= 3;
                                    $array['cmbRectoria'] = $_POST['cmbRectoria'];
                                    $array['PlanDesarrollo'] = $plandesarrollo;	
                                    $array['periodo']= $codigoperiodo;
                                    $controlRender->render('renderReporteFacultades',$array);
                                }
			} break;
                        /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                         *Se crea caso 3 el cual realiza el llamado al reporte por linea estrategica 
                         */
                        case '3':
                        {
                           $facultades = $_POST['cmbFacultadConsultar'];
                           $codigoperiodo = $_POST['codigoperiodo'];
			   $facultad = explode("_",$facultades);
                           $idLinea = $_POST['cmbLinea'];
                          
                            if ( $facultades == -1 and $idLinea == -1 ){
                                    echo "<script type=\"text/javascript\">alert(\"Seleccione facultad y línea Estratégica\");</script>";  
                            } else if ( $facultades == -1 and $idLinea != -1) {
                                    echo "<script type=\"text/javascript\">alert(\"Seleccione una Facultad\");</script>";
                            } else if ( $facultades != -1 and $idLinea == -1){
                                    echo "<script type=\"text/javascript\">alert(\"Seleccione una línea Estratégica\");</script>";
                            }else {
                           
                                if(sizeof( $facultad ) > 1 ){
                                     $facultadd = $facultad[0];
                                     $codigoCarrera = $facultad[1];
                                 }

                                $lineas = $controlPlanProgramaLinea->verLinea( $facultadd, $codigoperiodo , $codigoCarrera , $idLinea );                
                                $array['linea'] = $lineas;				
                                $array['periodo']= $codigoperiodo;				
                                $array['tiporeporte']= 1;
                                $array['facultad']=$facultadd;
                                $array['carrera']=$codigoCarrera;
                                $array['idLineaReporte']=$idLinea;
                                $controlRender->render('renderReporteFacultades',$array);
                            }
                        }break;
                        /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                         *Se crea caso 4 el cual realiza el llamado al reporte Metas sin Avances Anuales Creados
                         *@Since July 26,2018 
                         */
                        case '4':{
                                $facultades = $_POST['cmbFacultadConsultar'];
				$codigoperiodo = $_POST['codigoperiodo'];
                                if ( $facultades == -1){
                                 echo "<script type=\"text/javascript\">alert(\"Seleccione una facultad\");</script>";  
                                } else {
                                    $facultad = explode("_",$facultades);

                                    if(sizeof( $facultad ) > 1){
                                        $facultadd = $facultad[0];
                                        $codigoCarrera = $facultad[1];

                                    }

                                    $lineas = $controlPlanProgramaLinea->verLinea( $facultadd, $codigoperiodo , $codigoCarrera );                
                                    $array['linea'] = $lineas;				
                                    $array['periodo']= $codigoperiodo;				
                                    $array['tiporeporte']= 4;
                                    $array['facultad']=$facultadd;
                                    $array['carrera']=$codigoCarrera;
                                    $controlRender->render('renderReporteFacultades',$array);
                                }
                        }break;
                        /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                         *Se crea caso 5 el cual realiza el llamado al reporte Metas con alcance diferente al Alcance de los Avances
                         *@Since July 26,2018 
                         */
                        case '5':{
                              $facultades = $_POST['cmbFacultadConsultar'];
                               if ( $facultades == -1){
                                 echo "<script type=\"text/javascript\">alert(\"Seleccione una facultad\");</script>";  
                               } else {
                                    $facultad = explode("_",$facultades);
                                    if(sizeof( $facultad ) > 1){
                                        $facultadd = $facultad[0];
                                        $codigoCarrera = $facultad[1];
                                        $array['tiporeporte']= 5;
                                        $array['carrera']=$codigoCarrera;
                                        $controlRender->render('renderReporteFacultades',$array);
                                    }
                               } 
                        }
                        
		}		
	}
	else
	{
		if($_POST["tipoOperacion"]== "TipoReporte")
		{
			switch($_POST["selectTipoReporte"])
			{
				case '1': 
				{
					if ( $lrol == 101 ) {
						  $idPersona = 4186; 	 
					}
					
					$facultades = $controlFacultad->consultar( $idPersona );					
					
					
					if(count($facultades)>0)
					{
						$html='<label>Facultad:</label>
							<select id="cmbFacultadConsultar" name="cmbFacultadConsultar">
								<option value="-1">Seleccionar</option>';
                                                if ( $lrol == 101 ) {
                                                       $html.='<option value="10000_10000">PLAN DE DESARROLLO INSTITUCIONAL</option>';
                                                }                    
						foreach($facultades as $f)
						{
							
							/*@Modified Diego Rivera<riveradiego@unbosque.edu.co>
							 *Se crean variables y se asignan valores  $codigoFacultad = $f->getCodigoFacultad( ); 	$nombreFacultad = $f->getNombreFacultad( );
						          $codigoCarrera =  $f->getCarreraPrincipal()->getCodigoCarrera( );$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
							  */
							$codigoFacultad = $f->getCodigoFacultad( );
							$nombreFacultad = $f->getNombreFacultad( );
							$codigoCarrera =  $f->getCodigoArea( );
							$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
								
							if( $codigoFacultad == $codigoCarrera ){
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreFacultad.'</option>';
							}else {
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreCarrera.'</option>';
							}
							// fin modificaciones 
						}
						$html .= '</select>	';
						echo json_encode( array("html"=>$html, "success"=>true));
					}else{
						echo json_encode( array("html"=>"", "success"=>false));
					} 
				}break;
				case '2':
				{
					//<option value="2">Lineas Estrategias</option>
					$html='<label>Buscar por detalles:</label>
							<select id="cmbRectoria" name="cmbRectoria">
								<option value="-1">Seleccionar</option>
								<option value="1">Planes de desarrollo</option>
								
							</select>';
					echo json_encode( array("html"=>$html, "success"=>true));
				}break;
                                /*@Modified Diego Rivera <riveradiego@unbosque.edu.co >
                                 *Se crea case 3 el cual hace referencia al reporte por linea estrategica
                                 *@Since May 02,2018
                                 */
                                
                                case '3':
                                {   
                                    /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                     *Se añade lrol 96 en validacion para consultar todas las facultades
                                     *@Since May 11,2018 
                                     *                                      */
                                    if ( $lrol == 101 or $lrol == 96 ) {
						  $idPersona = 4186; 	 
				    }
                                    
                                    $lineas =$controlLineaEstrategica->consultarLineaEstrategica();
                                    $facultades = $controlFacultad->consultar( $idPersona );					
					$html='<label>Línea Estratégica:</label>
						<select id="cmbLinea" name="cmbLinea">
                                                    <option value="-1">Seleccionar</option>';
                                                    foreach ($lineas as $ln){
                                                      $codigoLinea = $ln->getIdLineaEstrategica();
                                                      $nombreLinea = $ln->getNombreLineaEstrategica();
                                                      $html.= '<option value="'.$codigoLinea.'">'.$nombreLinea.'</option>';
                                                    }
                                        
                                        $html.='</select><br><br>';
					
					if(count($facultades)>0)
					{
						$html.='<label>Facultad:</label>
							<select id="cmbFacultadConsultar" name="cmbFacultadConsultar">
								<option value="-1">Seleccionar</option>';
                                                  if ( $lrol == 101 ) {
                                                       $html.='<option value="10000_10000">PLAN DE DESARROLLO INSTITUCIONAL</option>';
                                                }    
                                                foreach($facultades as $f)
						{
							
							/*@Modified Diego Rivera<riveradiego@unbosque.edu.co>
							 *Se crean variables y se asignan valores  $codigoFacultad = $f->getCodigoFacultad( ); 	$nombreFacultad = $f->getNombreFacultad( );
						          $codigoCarrera =  $f->getCarreraPrincipal()->getCodigoCarrera( );$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
							  */
							$codigoFacultad = $f->getCodigoFacultad( );
							$nombreFacultad = $f->getNombreFacultad( );
							$codigoCarrera =  $f->getCodigoArea( );
							$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
								
							if( $codigoFacultad == $codigoCarrera ){
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreFacultad.'</option>';
							}else {
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreCarrera.'</option>';
							}
							// fin modificaciones 
						}
						$html .= '</select>	';
						echo json_encode( array("html"=>$html, "success"=>true));
					}else{
						echo json_encode( array("html"=>"", "success"=>false));
					} 
                                }break;
                                   /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                    *Se crea caso 4  y 5  carga de programa dependiendo el rol de usuario logueado
                                    *@Since July 26,2018 
                                    */
                               case '4': 
				{
					if ( $lrol == 101 ) {
						  $idPersona = 4186; 	 
					}
					
					$facultades = $controlFacultad->consultar( $idPersona );					
					
					
					if(count($facultades)>0)
					{
						$html='<label>Facultad:</label>
							<select id="cmbFacultadConsultar" name="cmbFacultadConsultar">
								<option value="-1">Seleccionar</option>';
						foreach($facultades as $f)
						{
							$codigoFacultad = $f->getCodigoFacultad( );
							$nombreFacultad = $f->getNombreFacultad( );
							$codigoCarrera =  $f->getCodigoArea( );
							$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
								
							if( $codigoFacultad == $codigoCarrera ){
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreFacultad.'</option>';
							}else {
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreCarrera.'</option>';
							}
							// fin modificaciones 
						}
						$html .= '</select>	';
						echo json_encode( array("html"=>$html, "success"=>true));
					}else{
						echo json_encode( array("html"=>"", "success"=>false));
                                        }
                                
                                } break;
                                case '5':{
                                    if ( $lrol == 101 ) {
						  $idPersona = 4186; 	 
					}
					
					$facultades = $controlFacultad->consultar( $idPersona );					
					
					
					if(count($facultades)>0)
					{
						$html='<label>Facultad:</label>
							<select id="cmbFacultadConsultar" name="cmbFacultadConsultar">
								<option value="-1">Seleccionar</option>';
						foreach($facultades as $f)
						{
							$codigoFacultad = $f->getCodigoFacultad( );
							$nombreFacultad = $f->getNombreFacultad( );
							$codigoCarrera =  $f->getCodigoArea( );
							$nombreCarrera =  $f->getCarreraPrincipal()->getNombreCarrera( );
								
							if( $codigoFacultad == $codigoCarrera ){
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreFacultad.'</option>';
							}else {
								$html .= '<option value="'.$codigoFacultad.'_'.$codigoCarrera.'">'.$nombreCarrera.'</option>';
							}
						
						}
						$html .= '</select>	';
						echo json_encode( array("html"=>$html, "success"=>true));
					}else{
						echo json_encode( array("html"=>"", "success"=>false));
                                        }
                                }
			}//switch
		}//if
	}		
	
?>