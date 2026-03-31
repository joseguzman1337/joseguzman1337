<?php

  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades 
   */
  require_once("../../consulta/interfacespeople/cambia_fecha_people.php");
  
  class ControlClienteWebService{
  	
	/**
	 * @type String
	 * @access private
	 */
	private $path = "../tmp/";
	

	/**
	 * @type String
	 * @access private
	 */
	private $metodoALlamar = "UBI_CUENTA_CLIENTE_OPR_SRV";


	/**
	 * @type String
	 * @access private
	 */
	private $modo = "webservice";


	/**
	 * @type String
	 * @access private
	 */
	private $urlServidor = '';
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 */
	public function ControlClienteWebService($persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Verifica Deudas People
	 * @param $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function verificarDeudaPeople( $txtCodigoEstudiante, $txtCodigoCarrera ) {
		
		$deudas = array( );
		
		$controlEstudiante = new ControlEstudiante( $this->persistencia );	
		$controlCarrera = new ControlCarrera( $this->persistencia );
		
		
		$carrera = $controlCarrera->buscarCarrera($txtCodigoCarrera);
		$estudiante = $controlEstudiante->buscarEstudiante( $txtCodigoEstudiante );
		
		$txtNombreCorto = $estudiante->getTipoDocumento( )->getDescripcion( );
		
		$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
		$txtCodigoCentroBeneficio = $carrera->getCodigoBeneficio( );
		
		/*$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    	$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    	$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    	$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';*/
		
		$results=array();
		$envio=0;
		//if(verificarPSEnLinea()){
	    $client = new nusoap_client(WEBESTADOCUENTA,true, false, false, false, false, 0, 100);
		
		
	                            
	    $err = $client->getError();
	    if ($err) {
	        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
			echo '<h2>Debug</h2><pre>' . htmlspecialchars( $client->getDebug(), ENT_QUOTES) . '</pre>';
			exit();
	    }
	    
	    $proxy = $client->getProxy( );
		
		
	       $param2="   <UB_DATOSCONS_WK>
	           <NATIONAL_ID_TYPE>".$txtNombreCorto."</NATIONAL_ID_TYPE>
	    <NATIONAL_ID>".$txtNumeroDocumento."</NATIONAL_ID>
	    <DEPTID>".$txtCodigoCentroBeneficio."</DEPTID>
	        </UB_DATOSCONS_WK>";
			
		
		
		$imagen = "";
		
		//UBI_ESTADO_CUENTA_OPR_SRV Local
		//UBI_CUENTA_CLIENTE_OPR_SRV Produccion
			$resultado = $client->call("UBI_CUENTA_CLIENTE_OPR_SRV",$param2);
		
			if ($client->fault) {
				echo "<h2>Fault</h2><pre>"; print_r($resultado); echo "</pre>";
			} else {
					$err = $client->getError();
					if ($err) {
					echo "<h2>Error</h2><pre>" . $err . "</pre>";
					} else {
						if( $resultado["ERRNUM"] == 0){
							$results = $resultado["UBI_ITEMS_WRK"];
						}
					}
					if( $results != null ){
						$imagen = "../css/images/circuloRojo.png";
						$existeDeudaPeople = 0;
					}else{
						$imagen = "../css/images/circuloVerde.png";
						$existeDeudaPeople = 1;
					}	
				}
		
		$validacion = array( "imagen" => $imagen, "existeDeuda" => $existeDeudaPeople);
		
		if( is_array( $results ) && count( $results ) != 0 ){
				
			$cuentaItem = 0;
			//$resultados = $results['UBI_ITEM_WRK'];
			
			
			foreach( $results as $result ){
				
				if( empty( $result[0] ) && is_array( $result ) ){
					$resultTemp = $result;
					unset($result);
					$result[0] = $resultTemp;
				}
				
				if( count($result) > 1 ){
						
					for( $i=0; $i <= count($result); $i++ ){
						if( !empty($result[$i]) ){
							/*$txtItemPeople = $result[$i]['ITEM_TYPE'];
							$txtValorItem =$result[$i]['ITEM_AMT'];
							$txtItemDescripcion = $result[$i]['DESCR'];
							
							$carreraPeople = $controlCarreraPeople->buscarCarreraPeople( $txtItemPeople );*/
							
							$deudas[ count( $deudas ) ] = $result[$i];
							
							//return array( 'imagen' => $imagen, 'existeDeuda' => $existeDeudaPeople );
						
						}
					}
					
				}else{
					//if( !empty($result[0]) ){
						$deudas[ count( $deudas ) ] = $result[0];
					//}
					//return array( 'imagen' => $imagen, 'existeDeuda' => $existeDeudaPeople );
					
				}
				$deudas2 = array( "deudas" => $deudas );
				
				$prueba = array_merge($validacion,$deudas2);
				
				return $prueba;
				
			}
		}
		return array( "imagen" => $imagen, "existeDeuda" => $existeDeudaPeople );
	}





	/**
	 * Verifica Deudas People Cron 
	 * @param $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function verificarDeudaPeopleCron( $txtCodigoCarrera, $txtCodigoCentroBeneficio ) {
		
		$deudas = array( );
		
		$controlEstudiante = new ControlEstudiante( $this->persistencia );	
		
			$estudiantes = $controlEstudiante->consultarCronEstudiante( $txtCodigoCarrera );
			
		foreach( $estudiantes as $estudiante ){
			$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
			
			$txtNombreCorto = $estudiante->getTipoDocumento( )->getDescripcion( );
				
			$txtCodigoEstudiante = $estudiante->getCodigoEstudiante( );	
			
		//}
		//$estudiante = $controlEstudiante->buscarEstudiante( $txtCodigoEstudiante );
		
		/*$txtNombreCorto = $estudiante->getTipoDocumento( )->getDescripcion( );
		
		$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
		$txtCodigoCentroBeneficio = $carrera->getCodigoBeneficio( );*/
		
		$results=array();
		$envio=0;
		//if(verificarPSEnLinea()){
	    $client = new nusoap_client(WEBESTADOCUENTA,true, false, false, false, false, 0, 100);
		
		
	                            
	    $err = $client->getError();
	    if ($err) {
	        echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
			echo '<h2>Debug</h2><pre>' . htmlspecialchars( $client->getDebug(), ENT_QUOTES) . '</pre>';
			exit();
	    }
	    
	    $proxy = $client->getProxy( );
		
		
	       $param2="   <UB_DATOSCONS_WK>
	           <NATIONAL_ID_TYPE>".$txtNombreCorto."</NATIONAL_ID_TYPE>
	    <NATIONAL_ID>".$txtNumeroDocumento."</NATIONAL_ID>
	    <DEPTID>".$txtCodigoCentroBeneficio."</DEPTID>
	        </UB_DATOSCONS_WK>";
			
		
		
		$imagen = "";
		
		//UBI_ESTADO_CUENTA_OPR_SRV Local
		//UBI_CUENTA_CLIENTE_OPR_SRV Produccion
			$resultado = $client->call("UBI_CUENTA_CLIENTE_OPR_SRV",$param2);
			
		
			if ($client->fault) {
				echo "<h2>Fault</h2><pre>"; print_r($resultado); echo "</pre>";
			} else {
					$err = $client->getError();
					if ($err) {
					echo "<h2>Error</h2><pre>" . $err . "</pre>";
					} else {
						if( $resultado["ERRNUM"] == 0){
							$results = $resultado["UBI_ITEMS_WRK"];
						}
					}
					if( $results != null ){
						$imagen = "../css/images/circuloRojo.png";
						$existeDeudaPeople = 0;
					}else{
						$imagen = "../css/images/circuloVerde.png";
						$existeDeudaPeople = 1;
					}	
				}
		
		$validacion = array( "imagen" => $imagen, "existeDeuda" => $existeDeudaPeople);
		
		if( is_array( $results ) && count( $results ) != 0 ){
				
			$cuentaItem = 0;
			//$resultados = $results['UBI_ITEM_WRK'];
			
			
			foreach( $results as $result ){
				
				if( empty( $result[0] ) && is_array( $result ) ){
					$resultTemp = $result;
					unset($result);
					$result[0] = $resultTemp;
				}
				
				if( count($result) > 1 ){
						
					for( $i=0; $i <= count($result); $i++ ){
						if( !empty($result[$i]) ){
							/*$txtItemPeople = $result[$i]['ITEM_TYPE'];
							$txtValorItem =$result[$i]['ITEM_AMT'];
							$txtItemDescripcion = $result[$i]['DESCR'];
							
							$carreraPeople = $controlCarreraPeople->buscarCarreraPeople( $txtItemPeople );*/
							
						$deudas[ count( $deudas ) ] = $result[$i];
							
							//return array( 'imagen' => $imagen, 'existeDeuda' => $existeDeudaPeople );
						
						}
					}
					
				}else{
					//if( !empty($result[0]) ){
						$deudas[ count( $deudas ) ] = $result[0];
					//}
					//return array( 'imagen' => $imagen, 'existeDeuda' => $existeDeudaPeople );
					
				}
				$deudas2 = array( "deudas" => $deudas );
				
				$controlDeudaPeople = new ControlDeudaPeople( $this->persistencia );
				
				$controlDeudaPeople->crearDeudaPeople( $txtCodigoEstudiante );
				
				/*$prueba = array_merge($validacion,$deudas2);
				
				echo $estudiante->getCodigoEstudiante( )."<br />";
				
				echo "<pre>";print_r( $deudas2 );*/
				
				//return $prueba;
				
				}
			}
		}
		//return array( "imagen" => $imagen, "existeDeuda" => $existeDeudaPeople );
	}


	/**
	 * Modifica Datos Estudiante
	 * @param $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function modificaDatosEstudiante( $estudiante = '' , $txtCodigoEstudiante = '' ) {

	
		$results= array();
				 
			 $envio=2;
			// $servicioPS = verificarPSEnLinea();
				//if($servicioPS){
					$client = new nusoap_client(WEBORDENDEPAGO, true, false, false, false, false, 0, 200);
					$err = $client->getError();
					if ($err)
						echo '<h2>ERROR EN EL CONSTRUCTOR</h2><pre>' . $err . '</pre>';
					//$proxy = $client->getProxy();
				//}
			$parametros['UBI_OPERACION_ORD']='U';
			
			$controlEstudiante = new ControlEstudiante( $this->persistencia );
			$controlDocumentoPeople = new ControlDocumentoPeople( $this->persistencia );
			$controlLocalidad = new ControlLocalidad( $this->persistencia );
			$controlGeneroPeople = new ControlGeneroPeople( $this->persistencia );
			
			
			$buscaEstudiante = $controlEstudiante->buscarEstudiante( $txtCodigoEstudiante );
			
			$txtTipoDocumentoNuevo = $estudiante->getTipoDocumento( )->getIniciales( );
			$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
			$txtCodigoGenero = $estudiante->getGenero( )->getCodigo( );
			
			/*echo "TipoDocumentoNuevo---->".$txtTipoDocumentoNuevo."<br />";
			echo "NumeroDocumentoNuevo---->".$txtNumeroDocumento."<br />";*/
			
			$txtTipoDocumentoAnterior = $buscaEstudiante->getTipoDocumento( )->getIniciales( );
			$txtNumeroDocumentoAnterior = $buscaEstudiante->getNumeroDocumento( );
			$txtFechaNacimiento = $buscaEstudiante->getFechaNacimiento( );
			$txtCodigoCiudad = $buscaEstudiante->getCiudad( )->getId( );
			$txtDireccionEstudiante = $buscaEstudiante->getDireccion( );
			$txtTelefonoEstudiante = $buscaEstudiante->getTelefono( );
			$txtEmailEstudiante = $buscaEstudiante->getEmail( );
			
			/*echo "TipoDocumentoAnterior---->".$txtTipoDocumentoAnterior."<br />";
			echo "NumeroDocumentoAnterior---->".$txtNumeroDocumentoAnterior."<br />";*/
			
			
			$documentoPeopleNuevo = $controlDocumentoPeople->buscarTipoDocumentoPeople( $txtTipoDocumentoNuevo );
			$txtDocumentoPeopleNuevo = $documentoPeopleNuevo->getCodigoDocumentoPeople( );
			
			$documentoPeopleAnterior = $controlDocumentoPeople->buscarTipoDocumentoPeople( $txtTipoDocumentoAnterior );
			
			$txtDocumentoPeopleAnterior = $documentoPeopleAnterior->getCodigoDocumentoPeople( );
			
			$generoPeople = $controlGeneroPeople->buscarCodigoGeneroPeople( $txtCodigoGenero );
			$txtCodigoGeneroPeople = $generoPeople->getIdSexoPeople( );
			
			$estadoCivil = $controlEstudiante->buscarEstadoCivilPeople( $txtNumeroDocumentoAnterior );
			$txtCodigoEstadoCivilPeople = $estadoCivil->getEstadoCivilEstudiante( );
			
			/*echo "CodigoDocumentoPeopleNuevo---->".$txtDocumentoPeopleNuevo."<br />";
			echo "CodigoDocumentoPeopleAnterior---->".$txtDocumentoPeopleAnterior."<br />";*/
			
			$buscaLocalidad = $controlLocalidad->buscarCodigoLocalidad( $txtCodigoCiudad );
			
			
			
			$parametros['NATIONAL_ID_TYPE'] = $txtDocumentoPeopleNuevo;
			$parametros['NATIONAL_ID'] = $txtNumeroDocumento;
			
			//echo $txtDocumentoPeopleAnterior." - ".$txtNumeroDocumentoAnterior."<br />";
			
			if( $txtDocumentoPeopleNuevo != $txtDocumentoPeopleAnterior || $txtNumeroDocumento != $txtNumeroDocumentoAnterior ){
				$parametros['NATIONAL_ID_TYPE_OLD'] = $txtDocumentoPeopleAnterior;
				$parametros['NATIONAL_ID_OLD'] = $txtNumeroDocumentoAnterior;
			}else{
				$parametros['NATIONAL_ID_TYPE_OLD']="";
				$parametros['NATIONAL_ID_OLD']="";
			}
			
			
			$apellidoEstudiante = strpos(trim($estudiante->getApellidoEstudiante( ))," ");
			
			if( $apellidoEstudiante > 0 ){
				$primerApellido = substr(trim($estudiante->getApellidoEstudiante( )),0,$apellidoEstudiante);
				$segundoApellido = substr(trim($estudiante->getApellidoEstudiante( )), $apellidoEstudiante + 1, strlen(trim($estudiante->getApellidoEstudiante( ))));
			}else{
				$primerApellido = trim($estudiante->getApellidoEstudiante( ));
				$segundoApellido = "";
			}
			
			$nombreEstudiante = strpos(trim($estudiante->getNombreEstudiante( ))," ");
			if( $nombreEstudiante > 0 ){
				$primerNombre = substr(trim($estudiante->getNombreEstudiante( )),0,$nombreEstudiante);
				$segundoNombre = substr(trim($estudiante->getNombreEstudiante( )), $nombreEstudiante + 1, strlen(trim($estudiante->getNombreEstudiante( ))));
			}else{
				$primerNombre = trim($estudiante->getNombreEstudiante( ));
				$segundoNombre = "";
			}
			
			
			
			$parametros['FIRST_NAME'] = $primerNombre;
			$parametros['MIDDLE_NAME'] = $segundoNombre;
			$parametros['LAST_NAME'] = $primerApellido;
			$parametros['SECOND_LAST_NAME'] = $segundoApellido;
			
			$parametros['BIRTHDATE'] = $txtFechaNacimiento;
			
			$txtCodigoSapCiudad = $buscaLocalidad->getCodigoSapCiudad( );
			$txtCodigoSapDepartamento = $buscaLocalidad->getDepartamento( )->getCodigoSapDepartamento( );
			$txtCodigoSapPais = $buscaLocalidad->getDepartamento( )->getPais( )->getCodigoSapPais( );
			
			$parametros['BIRTHCOUNTRY'] = $txtCodigoSapPais;
			$parametros['BIRTHSTATE'] = $txtCodigoSapDepartamento;
			$parametros['BIRTHPLACE'] = $txtCodigoSapCiudad;
			
			
			
			$parametros['SEX'] = $txtCodigoGeneroPeople;
			
			$parametros['MAR_STATUS'] = $txtCodigoEstadoCivilPeople;
			
			$parametros['ADDRESS1'] = trim( $txtDireccionEstudiante );
			if($parametros['ADDRESS1'] == ""){
				$parametros['ADDRESS1']='KR 7B BIS No. 132-11';
			}
			
			
			$parametros['PHONE'] = $txtTelefonoEstudiante;
			
			if( $txtEmailEstudiante != "" ){
				$parametros['EMAIL_ADDR'] = $txtEmailEstudiante;	
			}else{
				$controlUsuario = new ControlUsuario( $this->persistencia );
				$usuarioEstudiante = $controlUsuario->buscarUsuarioDocumento( $txtNumeroDocumentoAnterior );
				$txtUsuarioEstudiante = $usuarioEstudiante->getUser( );
				$emailEstudiante = $txtUsuarioEstudiante."@unbosque.edu.co";
				
				$parametros['EMAIL_ADDR'] = $emailEstudiante;
			}
			
			
			$parametros['BUSINESS_UNIT']='UBSF0';
			
			$xml="	<m:messageRequest xmlns:m=\"http://xmlns.oracle.com/Enterprise/Tools/schemas/UBI_CREA_ORDENPAG_REQ_MSG.VERSION_1\">
					<UBI_ESTADO>I</UBI_ESTADO>
					<UBI_OPERACION_ORD>".$parametros['UBI_OPERACION_ORD']."</UBI_OPERACION_ORD>
					<NATIONAL_ID_TYPE>".$parametros['NATIONAL_ID_TYPE']."</NATIONAL_ID_TYPE>
					<NATIONAL_ID>".$parametros['NATIONAL_ID']."</NATIONAL_ID>
					<NATIONAL_ID_TYPE_OLD>".$parametros['NATIONAL_ID_TYPE_OLD']."</NATIONAL_ID_TYPE_OLD>
					<NATIONAL_ID_OLD>".$parametros['NATIONAL_ID_OLD']."</NATIONAL_ID_OLD>
					<FIRST_NAME>".$parametros['FIRST_NAME']."</FIRST_NAME>
					<MIDDLE_NAME>".$parametros['MIDDLE_NAME']."</MIDDLE_NAME>
					<LAST_NAME>".$parametros['LAST_NAME']."</LAST_NAME>
					<SECOND_LAST_NAME>".$parametros['SECOND_LAST_NAME']."</SECOND_LAST_NAME>
					<BIRTHDATE>".cambiaf_a_people2($parametros['BIRTHDATE'])."</BIRTHDATE>
					<BIRTHCOUNTRY>".$parametros['BIRTHCOUNTRY']."</BIRTHCOUNTRY>
					<BIRTHSTATE>".$parametros['BIRTHSTATE']."</BIRTHSTATE>
					<BIRTHPLACE>".$parametros['BIRTHPLACE']."</BIRTHPLACE>
					<SEX>".$parametros['SEX']."</SEX>
					<MAR_STATUS>".$parametros['MAR_STATUS']."</MAR_STATUS>
					<ADDRESS1>".$parametros['ADDRESS1']."</ADDRESS1>
					<PHONE>".$parametros['PHONE']."</PHONE>
					<EMAIL_ADDR>".$parametros['EMAIL_ADDR']."</EMAIL_ADDR>
					<BUSINESS_UNIT>".$parametros['BUSINESS_UNIT']."</BUSINESS_UNIT>
				</m:messageRequest>";
			//echo "<h1>aquuiiiiiiiiii</h1>";
			
			/*echo $xml."<br />";
			exit( );*/
			// Envio de parametros con arreglo
			//$result = $client->call('PS_UBI_SALA_ORDPAG',array($parametros));
			// Envio de parametros por xml
		
		
			/*
			 * @modified David Perez <perezdavid@unbosque.edu.co>
			 * @since  Enero 22, 2018
			 * Se comenta bloque para deshabilitar el reporte de terceros a Campus debido a lentitud extrema en el proceso
			*/
		
			//$results = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
			
			/*Fin de bloque comentado*/
			
			/*if($servicioPS){
			$hayResultado = false;
						for($i=0; $i <= 5 && !$hayResultado; $i++){
								$start = time();
								$result = $client->call('UBI_CREA_ORDENPAG1_OPR_SRV',$xml);
								$time =  time()-$start;             
								$envio = 1;
								if($time>=30 || $result===false){
									$envio=0;
									if($i>=5){
										reportarCaida(1,'Actualizacion estudiante');
									}
								} else {
									$hayResultado = true;
								}
								sleep(1); // this should halt for 3 seconds for every loop
							}
			}*/
			$results['ERRNUM'] = 0;
			$results['DESCRLONG'] = 'Sistema abajo por mantenimiento PS';
			$results['NATIONAL_ID'] = $parametros['NATIONAL_ID'];
			$results['xml'] = $xml;
			//echo "<pre>";print_r( $results ); exit( );
			
			
		return $results;
		
		
	}

  }
?>