<?php
 /**
  * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
  * @copyright Universidad el Bosque - Dirección de Tecnologia
  * @package entidades
  */
 
 
 class Diploma{
 	
	
	/**
	 * @type int
	 * @access private
	 */
	private $idActualizaDiploma;
	
	
	/**
	 * @type RegistroGrado
	 * @access private
	 */
	private $registroGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroDiplomaAnterior;
	
	/**
	 * @type string
	 * @access private
	 */
	private $observacionDiploma;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function Diploma( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id de Actuliza Diploma
	 * @param int $idActualizaDiploma
	 * @access public
	 * @return void
	 */
	public function setIdActualizaDiploma( $idActualizaDiploma ){
		$this->idActualizaDiploma = $idActualizaDiploma;
	}
	
	/**
	 * Retorna el id Actualiza Diploma
	 * @access public
	 * @return int
	 */
	public function getIdActualizaDiploma( ){
		return $this->idActualizaDiploma;
	}
	
	/**
	 * Modifica el registro de grado del diploma
	 * @param $registroGrado RegistroGrado
	 * @access public
	 * @return void
	 */
	public function setRegistroGrado( $registroGrado ){
		$this->registroGrado = $registroGrado;
	}
	
	/**
	 * Retorna el registro de grado del diploma
	 * @access public
	 * @return RegistroGrado
	 */
	public function getRegistroGrado( ){
		return $this->registroGrado;
	}
	
	/**
	 * Modifica el número del diploma anterior
	 * @param int $numeroDiplomaAnterior
	 * @access public
	 * @return void
	 */
	public function setNumeroDiplomaAnterior( $numeroDiplomaAnterior ){
		$this->numeroDiplomaAnterior = $numeroDiplomaAnterior;
	}
	
	/**
	 * Retorna el número del diploma anterior
	 * @access public
	 * @return int
	 */
	public function getNumeroDiplomaAnterior( ){
		return $this->numeroDiplomaAnterior;
	}
	
	/**
	 * Modifica la observación del Diploma
	 * @param string $observacionDiploma
	 * @access public
	 * @return void
	 */
	public function setObservacionDiploma( $observacionDiploma ){
		$this->observacionDiploma = $observacionDiploma;
	}
	
	/**
	 * Retorna la observación del Diploma
	 * @access public
	 * @return string
	 */
	public function getObservacionDiploma( ){
		return $this->observacionDiploma;
	}
	
	/**
	 * Actualiza Diploma
	 * @access public
	 * @return Booelan
	 */
	public function creaDiplomaNuevo( $txtIdRegistroGrado, $txtNumeroDiplomaAnterior, $txtObservacionDiploma ){
		
		$sql = "INSERT INTO ActualizaDiplomaGrado (
				ActualizaDiplomaGrado,
				RegistroGradoId, 
				NumeroDiplomaAnterior,
				Observaciones )
				VALUES((SELECT IFNULL( MAX( ADG.ActualizaDiplomaGrado ) +1, 1 ) 
							FROM ActualizaDiplomaGrado ADG
							 ),?,?,?)";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );
		$this->persistencia->setParametro( 1 , $txtNumeroDiplomaAnterior , true );
		$this->persistencia->setParametro( 2 , $txtObservacionDiploma , true );
		
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
	
	/**
	 * Historico de observaciones
	 * @access public
	 * @return Array<ActualizaDiplomaGrado>
	 */
	public function consultarObservaciones( $txtIdRegistroGrado ) {
		$diplomas = array( );
		
		$sql = "SELECT R.RegistroGradoId, AD.NumeroDiplomaAnterior, AD.Observaciones
				FROM RegistroGrado R
				INNER JOIN ActualizaDiplomaGrado AD ON ( AD.RegistroGradoId = R.RegistroGradoId )
				WHERE R.RegistroGradoId = ?";


		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );

		$this->persistencia->ejecutarConsulta(  );
		
		while( $this->persistencia->getNext( ) ){
			$diploma = new Diploma( $this->persistencia );
			$diploma->setNumeroDiplomaAnterior( $this->persistencia->getParametro( "NumeroDiplomaAnterior" ) );
			$diploma->setObservacionDiploma( $this->persistencia->getParametro( "Observaciones" ) );
			
			$registroGrado = new RegistroGrado( null );
			$registroGrado->setIdRegistroGrado( $this->persistencia->getParametro( "RegistroGradoId" ) );
			
			
			$diploma->setRegistroGrado( $registroGrado );
			
			//echo $this->persistencia->getSQLListo( );
			
			$diplomas[ count( $diplomas ) ] = $diploma;
			
			
		}
		$this->persistencia->freeResult( );
		
		return 	$diplomas;
	}
	
	
 }
 
?>