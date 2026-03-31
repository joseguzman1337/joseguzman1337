<?php 
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 * @since enero  23, 2017
 */ 
 include( "../entidades/Estudiante.php" );
 
 class ControlEstudiante{
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
	public function ControlEstudiante( $persistencia ){
		$this->persistencia = $persistencia;
	}	
	/**
	 * Consulta los diferentes codigos de estudiantes relacionados con el idestudiantegeneral
	 * @param String $idEstudianteGeneral
	 * @access public
	 * @return Array<Estudiantes>
	 */
	 public function buscarEstudiante( $idestudiantegeneral,$idestudianteantiguo ){
	 	$estudiante = new Estudiante( $this->persistencia );
		return $estudiante;
	
	 }
	 
	 /**
	 * Actualizar ideEstudianteGeneral ne tabla estudiante
 	 * @param int $codigoEstudiante,$idestudiantegeneral
	 * @access public
	 * @return boolean
	 */
	 public function actualizarIdEstudiante( $codigoEstudiante , $idestudiantegeneral ){
	 	$estudiante = new Estudiante( $this->persistencia );
		$estudiante->actualizarIdEstudianteGeneral( $codigoEstudiante , $idestudiantegeneral );
		return $estudiante;
	
	 }
	 
	
	 
 }

?>