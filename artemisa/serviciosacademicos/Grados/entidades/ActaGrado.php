<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class ActaGrado{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idActaGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroActaGrado;
	
	/**
	 * @type string
	 * @access private
	 */
	private $descripcionActaGrado;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaActaGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoActaGrado;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function ActaGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del acta de grado
	 * @param int $idActaGrado
	 * @access public
	 * @return void
	 */
	public function setIdActaGrado( $idActaGrado ){
		$this->idActaGrado = $idActaGrado;
	}
	
	/**
	 * Retorna el identificador del acta de grado
	 * @access public
	 * @return int
	 */
	public function getIdActaGrado( ){
		return $this->idActaGrado;
	}
	
	/**
	 * Modifica el numero del acta de grado
	 * @param int $numeroActaGrado
	 * @access public
	 * @return void
	 */
	public function setNumeroActaGrado( $numeroActaGrado ){
		$this->numeroActaGrado = $numeroActaGrado;
	}
	
	/**
	 * Retorna el numero del acta de grado
	 * @access public
	 * @return int
	 */
	public function getNumeroActaGrado( ){
		return $this->numeroActaGrado;
	}
	
	/**
	 * Modifica la descripcion del acta de grado
	 * @param string $descripcionActaGrado
	 * @access public
	 * @return void
	 */
	public function setDescripcionActaGrado( $descripcionActaGrado ){
		$this->descripcionActaGrado = $descripcionActaGrado;
	}
	
	/**
	 * Retorna la descripcion del acta de grado
	 * @access public
	 * @return string
	 */
	public function getDescripcionActaGrado( ){
		return $this->descripcionActaGrado;
	}
	
	/**
	 * Modifica la fecha del acta de grado
	 * @param date $fechaActaGrado
	 * @access public
	 * @return void
	 */
	public function setFechaActaGrado( $fechaActaGrado ){
		$this->fechaActaGrado = $fechaActaGrado;
	}
	
	/**
	 * Retorna la fecha del acta de grado
	 * @access public
	 * @return date
	 */
	public function getFechaActaGrado( ){
		return $this->fechaActaGrado;
	}
	
	/**
	 * Modifica el estado del acta de grado
	 * @param int $estadoActaGrado
	 * @access public
	 * @return void
	 */
	public function setEstadoActaGrado( $estadoActaGrado ){
		$this->estadoActaGrado = $estadoActaGrado;
	}
	
	/**
	 * Retorna el estado del acta de grado
	 * @access public
	 * @return int
	 */
	public function getEstadoActaGrado( ){
		return $this->estadoActaGrado;
	}
	
	
	/**
	 * Inserta el acta de grado del estudiante
	 * @access public
	 * @return Boolean 
	 */
	public function crearActaGrado( $txtNumeroActaGrado, $idPersona ){
		$sql = "INSERT INTO ActaGrado (
					ActaGradoId,
					NumeroActaGrado,
					DescripcionActaGrado,
					FechaActaGrado,
					CodigoEstado,
					UsuarioCreacion,
					UsuarioModificacion,
					FechaCreacion,
					FechaUltimaModificacion
				)
				VALUES
					((SELECT IFNULL( MAX( AG.ActaGradoId ) +1, 1 ) 
							FROM ActaGrado AG
							 ), ?, 'ACTA DE GRADO', NOW(), 100, ?, NULL, NOW(), NULL)";				
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtNumeroActaGrado , true );
		$this->persistencia->setParametro( 1 , $idPersona , true );
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