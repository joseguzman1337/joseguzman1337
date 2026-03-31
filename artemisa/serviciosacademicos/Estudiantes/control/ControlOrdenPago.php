<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since enero  23, 2017
 * @package control
 */
  
 include( "../entidades/OrdenPago.php" );
class ControlOrdenPago{
	
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
	public function ControlOrdenPago( $persistencia ){
		$this->persistencia = $persistencia;
	}
		/**
	 * control para actualiza codigos de estdiantes en ordenpago
	 * @access public
	 * @return array
	 */
	
	public function ActualizarCodigoEstudianteOrden( $codigoNuevo , $codigoViejo ){
		$ordenPago = new OrdenPago ( $this->persistencia);
		$ordenPago->ActualizarCodigoEstudiante( $codigoNuevo , $codigoViejo );
		return $ordenPago;
	}
}

?>