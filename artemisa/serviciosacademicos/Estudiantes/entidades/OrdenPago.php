<?php
/**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */ 

 
	class OrdenPago{
	/**
	 * @type int
	 * @access private
	 */
	private $numeroOrdenPago;
	/**
	 * @type int
	 * @access private
	 */
	private $codigoEstudiante;
	/**
	 * @type string
	 * @access private
	 */
	private $fechaOrdenPago;
	/**
	 * @type int
	 * @access private
	 */
	private $idPreMatricula;
	/**
	 * @type string
	 * @access private
	 */
	private $fechaEntregaOrdenPago;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoPeriodo;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoEstadoOrdenPago;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoImprimeOrdenPago;
	/**
	 * @type string
	 * @access private
	 */
	private $observacionOrdenPago;
	/**
	 * @type string
	 * @access private
	 */
	private $codigoCopiaOrdenPago;
	/**
	 * @type string
	 * @access private
	 */
	private $documentosApordenPago;
	/**
	 * @type int
	 * @access private
	 */
	private $idSubPeriodo;
	/**
	 * @type int
	 * @access private
	 */
	private $idSubPeriodoDestino;
	/**
	 * @type string
	 * @access private
	 */
	private $documentoCuentaXcobrarSap;
	/**
	 * @type string
	 * @access private
	 */
	private $documentoCuentaCompensacionSap;
	/**
	 * @type string
	 * @access private
	 */
	private $fechaPagosApordenPago;
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia; 
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function OrdenPago( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica NumeroOrdenPagodel estudiante
	 * @param $numeroOrdenPago
	 * @access public
	 * @return void
	 */
	public function setNumeroOrdenPago( $numeroOrdenPago ){
		$this->numeroOrdenPago = $numeroOrdenPago;
	}
	/**
	 * Retorna el NumeroOrdenPago del estudiante
	 * @access public
	 * @return NumeroOrdenPago
	 */
	public function getNumeroOrdenPago(){
		return $this->numeroOrdenPago;
	}
	/**
	 * Modifica CodigoEstudiante estudiante
	 * @param $numeroOrdenPago
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
	 * Modifica FechaOrdenPago estudiante
	 * @param fechaOrdenPago
	 * @access public
	 * @return void
	 */
	public function setFechaOrdenPago( $fechaOrdenPago ){
		$this->fechaOrdenPago = $fechaOrdenPago;
	}
	/**
	 * Retorna fechaOrdenPago del estudiante
	 * @access public
	 * @return FechaOrdenPago
	 */
	public function getFechaOrdenPago(){
		return $this->fechaOrdenPago;
	}
	/**
	 * Modifica IdPreMatricula estudiante
	 * @param IdPreMatricula
	 * @access public
	 * @return void
	 */
	public function setIdPreMatricula( $idPreMatricula ){
		$this->idPreMatricula = $idPreMatricula;
	}
	/**
	 * Retorna IdPreMatricula del estudiante
	 * @access public
	 * @return IdPreMatricula
	 */
	public function getIdPreMatricula(){
		return $this->idPreMatricula;
	}
	/**
	 * Modifica FechaEntregaOrdenPago del estudiante
	 * @param FechaEntregaOrdenPago
	 * @access public
	 * @return void
	 */
	public function setFechaEntregaOrdenPago( $FechaEntregaOrdenPago ){
		$this->fechaEntregaOrdenPago = $FechaEntregaOrdenPago;
	}
	/**
	 * Retorna FechaEntregaOrdenPago del estudiante
	 * @access public
	 * @return FechaEntregaOrdenPago
	 */
	public function getFechaEntregaOrdenPago(){
		return $this->fechaEntregaOrdenPago;
	}
	/**
	 * Modifica CodigoPeriodo del estudiante
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
	 * Modifica CodigoEstadoOrdenPago del estudiante
	 * @param $CodigoEstadoOrdenPago
	 * @access public
	 * @return void
	 */
	public function setCodigoEstadoOrdenPago( $codigoEstadoOrdenPago ){
		$this->codigoEstadoOrdenPago = $codigoEstadoOrdenPago;
	}
	/**
	 * Retorna CodigoEstadoOrdenPago del estudiante
	 * @access public
	 * @return CodigoEstadoOrdenPago
	 */	
	public function getCodigoEstadoOrdenPago(){
		return $this->codigoEstadoOrdenPago;
	}
	/**
	 * Modifica CodigoImprimeOrdenPago del estudiante
	 * @param $CodigoImprimeOrdenPago
	 * @access public
	 * @return void
	 */
	public function setCodigoImprimeOrdenPago( $codigoImprimeOrdenPago ){
		$this->codigoImprimeOrdenPago = $codigoImprimeOrdenPago;
	}
	/**
	 * Retorna CodigoImprimeOrdenPago del estudiante
	 * @access public
	 * @return CodigoImprimeOrdenPago
	 */	
	public function getCodigoImprimeOrdenPago(){
		return $this->codigoImprimeOrdenPago;
	}
	/**
	 * Modifica ObservacionOrdenPago del estudiante
	 * @param $ObservacionOrdenPago
	 * @access public
	 * @return void
	 */
	public function setObservacionOrdenPago( $observacionOrdenPago ){
		$this->observacionOrdenPago = $observacionOrdenPago;
	}
	/**
	 * Retorna ObservacionOrdenPago del estudiante
	 * @access public
	 * @return ObservacionOrdenPago
	 */
	public function getObservacionOrdenPago(){
		return $this->observacionOrdenPago;
	}
	/**
	 * Modifica CodigoCopiaOrdenPago del estudiante
	 * @param $CodigoCopiaOrdenPago
	 * @access public
	 * @return void
	 */
	public function setCodigoCopiaOrdenPago( $codigoCopiaOrdenPago ){
		$this->codigoCopiaOrdenPago = $codigoCopiaOrdenPago;
	}
	/**
	 * Retorna CodigoCopiaOrdenPago del estudiante
	 * @access public
	 * @return CodigoCopiaOrdenPago
	 */
	public function getCodigoCopiaOrdenPago(){
		return $this->codigoCopiaOrdenPago;
	}
	/**
	 * Modifica DocumentosApordenPago del estudiante
	 * @param $DocumentosApordenPago
	 * @access public
	 * @return void
	 */
	public function setDocumentosApordenPago( $documentosApordenPago ){
		$this->documentosApordenPago = $documentosApordenPago;
	}
	/**
	 * Retorna DocumentosApordenPago del estudiante
	 * @access public
	 * @return DocumentosApordenPago
	 */
	public function getDocumentosApordenPago(){
		return $this->documentosApordenPago;
	}
	/**
	 * Modifica IdSubPeriodo del estudiante
	 * @param $IdSubPeriodo
	 * @access public
	 * @return void
	 */	
	public function setIdSubPeriodo( $idSubPeriodo ){
		$this->idSubPeriodo = $idSubPeriodo;
	}
	/**
	 * Retorna IdSubPeriodo del estudiante
	 * @access public
	 * @return IdSubPeriodo
	 */
	public function getIdSubPeriodo(){
		return $this->idSubPeriodo;
	}
	/**
	 * Modifica IdSubPeriodoDestino del estudiante
	 * @param $IdSubPeriodoDestino
	 * @access public
	 * @return void
	 */	
	public function setIdSubPeriodoDestino( $idSubPeriodoDestino ){
		$this->idSubPeriodoDestino = $idSubPeriodoDestino;
	}
	/**
	 * Retorna IdSubPeriodoDestino del estudiante
	 * @access public
	 * @return IdSubPeriodoDestino
	 */
	public function getIdSubPeriodoDestino(){
		return $this->idSubPeriodoDestino;
	}
	/**
	 * Modifica DocumentoCuentaXcobrarSap del estudiante
	 * @param $DocumentoCuentaXcobrarSap
	 * @access public
	 * @return void
	 */	
	public function setDocumentoCuentaXcobrarSap( $documentoCuentaXcobrarSap ){
		$this->documentoCuentaCompensacionSap = $documentoCuentaXcobrarSap;
	}
	/**
	 * Retorna DocumentoCuentaXcobrarSap del estudiante
	 * @access public
	 * @return DocumentoCuentaXcobrarSap
	 */
	public function getDocumentoCuentaXcobrarSap(){
		return $this->documentoCuentaCompensacionSap;
	}
	/**
	 * Modifica DocumentoCuentaCompensacionSap del estudiante
	 * @param $DocumentoCuentaCompensacionSap
	 * @access public
	 * @return void
	 */	
	public function setDocumentoCuentaCompensacionSap( $documentoCuentaCompensacionSap ){
		$this->documentoCuentaCompensacionSap = $documentoCuentaCompensacionSap;
	}
	/**
	 * Retorna documentoCuentaCompensacionSap del estudiante
	 * @access public
	 * @return documentoCuentaCompensacionSap
	 */
	public function getdocumentoCuentaCompensacionSap(){
		return $this->documentoCuentaCompensacionSap;
	}
	/**
	 * Modifica FechaPagosApordenPago del estudiante
	 * @param $FechaPagosApordenPago
	 * @access public
	 * @return void
	 */		
	public function setFechaPagosApordenPago( $fechaPagosApordenPago ){
		$this->fechaPagosApordenPago = $fechaPagosApordenPago;
	}
	/**
	 * Retorna FechaPagosApordenPago del estudiante
	 * @access public
	 * @return FechaPagosApordenPago
	 */	
	public function getFechaPagosApordenPago(){
		return $this->fechaEntregaOrdenPago;
	}
	/**
	 * acutaliza el codigo de esudiante
	 * @access public
	 * @return estado
	 */
	public function ActualizarCodigoEstudiante( $codigoNuevo, $codigoViejo ){
		$sql=" UPDATE 
				ordenpago
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