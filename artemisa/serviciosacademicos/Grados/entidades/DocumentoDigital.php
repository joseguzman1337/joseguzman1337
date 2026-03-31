<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package entidades
    */
   
   class DocumentoDigital{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idDocumentoDigital;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function DocumentoDigital( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del documento digital
	 * @param int $idDocumentoDigital
	 * @access public
	 * @return void
	 */
	public function setIdDocumentoDigital( $idDocumentoDigital ){
		$this->idDocumentoDigital = $idDocumentoDigital;
	}
	
	/**
	 * Retorna el id del documento digital
	 * @access public
	 * @return int
	 */
	public function getIdDocumentoDigital( ){
		return $this->idDocumentoDigital;
	}
	
	/**
	 * Modifica el estudiante del documento digital
	 * @param $estudiante Estudiante
	 * @access public
	 * @return void
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el estudiante del documento digital
	 * @access public
	 * @return Estudiante
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
	/**
	 * Inserta la fecha de grado de la carrera
	 * @access public
	 * @return Boolean 
	 */
	public function crearDocumentoDigital( $txtCodigoEstudiante, $txtRutaDocumento, $txtIdUsuario ){
		$sql = "INSERT INTO DocumentoDigitalGrado (
							DocumentoDigitalGradoId,
							EstudianteId,
							RutaDocumento,
							CodigoEstado,
							UsuarioCreacion,
							UsuarioModificacion,
							FechaCreacion,
							FechaUltimaModificacion
						)
						VALUES
							(
								( SELECT IFNULL( MAX( DG.DocumentoDigitalGradoId ) +1, 1 ) 
							FROM DocumentoDigitalGrado DG
							 ), ?, ?, 100, ?, NULL, NOW(), NULL
							);";
						
		$this->persistencia->crearSentenciaSQL( $sql );


		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtRutaDocumento , true );
		$this->persistencia->setParametro( 2 , $txtIdUsuario , false );
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
			
		//$this->persistencia->freeResult( );
		
		return $estado;
	}
	
   }
?>