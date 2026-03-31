<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  include '../entidades/EstudianteDocumento.php';
  
  class ControlEstudianteDocumento{
  	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlEstudianteDocumento( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Busca un Estudiante Documento
	 * @param String $txtIdEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento ) {
		$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
		$estudianteDocumento->buscarEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento );
		return $estudianteDocumento;
	}
	
	/**
	 * Crear EstudianteDocumento
 	 * @param int $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento
	 * @param string $txtExpedidoDocumento
	 * @access public
	 * @return boolean
	 */
	public function crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento ){
		$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
		$estudianteDocumento->crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento );
		return $estudianteDocumento;
	}
	
	/**
	 * Actualizar EstudianteDocumento
 	 * @param int $txtIdEstudiante, $txtIdEstudianteDocumento
	 * @access public
	 * @return boolean
	 */
	public function actualizarEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento ){
		$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
		$estudianteDocumento->actualizarEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
		return $estudianteDocumento;
	}
	
	/**
	 * Actualizar Fecha Vencimiento EstudianteDocumento
 	 * @param int $txtIdEstudiante, $txtIdEstudianteDocumento
	 * @access public
	 * @return boolean
	 */
	public function actualizarFechaVencimientoEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento ){
		$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
		$estudianteDocumento->actualizarFechaVencimientoEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
		return $estudianteDocumento;
	}
	
	
	
  }
  
?>