<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since enero  25, 2017
 * @package control
 */
  include( "../entidades/Prematricula.php" );
  
 class ControlPrematricula{
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
	public function ControlPrematricula( $persistencia ){
		$this->persistencia = $persistencia;
	}
		/**
	 * control para actualiza codigos de estdiantes en prematricula
	 * @access public
	 * @return array
	 */
	
	public function ActualizarCodigoEstudiantePreMatricula( $codigoNuevo , $codigoViejo ){
		$prematricula = new PreMatricula( $this->persistencia );
		$prematricula->ActualizarCodigoEstudiante($codigoNuevo, $codigoViejo);
		return $prematricula;
	}
	
 }

?>