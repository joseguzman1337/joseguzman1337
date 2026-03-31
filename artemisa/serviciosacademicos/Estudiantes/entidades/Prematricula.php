<?php
/**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */ 
 class Prematricula{
 	/**
	 * @type int
	 * @access private
	 */
	private $idPrematricula;
	/**
	 * @type string
	 * @access private
	 */
	private $fechaPrematricula;
	/**
	 * @type int
	 * @access private
	 */
	private $codigoEstudiante;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoPeriodo;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoEstadoPrematricula;
	/**
	 * @type string
	 * @access private
	 */
	private $observacionPrematricula;
	/**
	 * @type string
	 * @access private
	 */
	private $semestrePrematricula;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia; 
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Prematricula( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica IdPrematricula del estudiante
	 * @param $IdPrematricula
	 * @access public
	 * @return void
	 */
	public function setIdPrematricula( $idPrematricula ){
		$this->idPrematricula = $idPrematricula;
	}
 	/**
	 * Retorna IdPrematricula del estudiante
	 * @access public
	 * @return IdPrematricula
	 */
	public function getIdPrematricula(){
		return $this->idPrematricula;
	}
		/**
	 * Modifica FechaPrematriculadel estudiante
	 * @param $FechaPrematricula
	 * @access public
	 * @return void
	 */
	public function setFechaPrematricula( $fechaPrematricula ){
		$this->fechaPrematricula = $fechaPrematricula;
	}
	/**
	 * Retorna FechaPrematricula del estudiante
	 * @access public
	 * @return FechaPrematricula
	 */
	public function getFechaPrematricula(){
		return $this->fechaPrematricula;
	}
		/**
	 * Modifica CodigoEstudiante del estudiante
	 * @param $CodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function setCodigoEstudiante( $codigoEstudiante ){
		$this->codigoEstudiante = $codigoEstudiante;
	}
	/**
	 * Retorna CodigoEstudiante del estudiante
	 * @access public
	 * @return CodigoEstudiante
	 */
	public function getCodigoEstudiante(){
		return $this->codigoEstudiante;
	}
		/**
	 * Modifica CodigoPeriododel estudiante
	 * @param $CodigoPeriodo
	 * @access public
	 * @return void
	 */
	public function setCodigoPeriodo( $codigoPeriodo ){
		$this->codigoPeriodo = $codigoPeriodo;
	}
	/**
	 * Retorna CodigoPeriodo del estudiante
	 * @access public
	 * @return CodigoPeriodo
	 */
	public function getCodigoPeriodo(){
		return $this->codigoPeriodo;
	}
		/**
	 * Modifica CodigoEstadoPrematricula del estudiante
	 * @param CodigoEstadoPrematricula
	 * @access public
	 * @return void
	 */
	public function setCodigoEstadoPrematricula( $codigoEstadoPrematricula ){
		$this->codigoEstadoPrematricula = $codigoEstadoPrematricula;
	}
	/**
	 * Retorna CodigoEstadoPrematricula del estudiante
	 * @access public
	 * @return CodigoEstadoPrematricula
	 */
	public function getCodigoEstadoPrematricula(){
		return $this->codigoEstadoPrematricula;
	}
		/**
	 * Modifica IObservacionPrematriculadel estudiante
	 * @param $ObservacionPrematricula
	 * @access public
	 * @return void
	 */
	public function setObservacionPrematricula( $observacionPrematricula ){
		$this->observacionPrematricula = $observacionPrematricula;
	}
	/**
	 * Retorna ObservacionPrematricula del estudiante
	 * @access public
	 * @return ObservacionPrematricula
	 */
	public function getobservacionPrematricula(){
		return $this->observacionPrematricula;
	}
	/**
	 * Modifica SemestrePrematricula del estudiante
	 * @param $SemestrePrematricula
	 * @access public
	 * @return void
	 */public function setSemestrePrematricula($semestrePrematricula){
		$this->semestrePrematricula=$semestrePrematricula;
	}
	/**
	 * RetornaS emestrePrematricula del estudiante
	 * @access public
	 * @return SemestrePrematricula
	 */
	public function getSemestrePrematricula(){
		return $this->semestrePrematricula;
	}
		/**
	 * Actualiza el codigo del estudiante en prematricula
	 * @access public
	 * @return array
	 */
	public function ActualizarCodigoEstudiante( $codigoNuevo , $codigoViejo ){
		$sql=" UPDATE 
				prematricula
			   SET
				codigoestudiante=?
			   WHERE
			    codigoestudiante=?	
		";
		
			
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $codigoNuevo , false );	
			$this->persistencia->setParametro( 1 , $codigoViejo , false );
			
			$estado = $this->persistencia->ejecutarUpdate( );
		
			if( $estado ){
				$this->persistencia->confirmarTransaccion( );
			}else{	
				$this->persistencia->cancelarTransaccion( );
			}	
		
			return $estado;	
			}
	
	
 }


?>