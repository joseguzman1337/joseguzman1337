<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 * @since enero  23, 2017
 */
 include( "../entidades/EstudianteGeneral.php" );
 
 class ControlEstudianteGeneral{
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
	public function ControlEstudianteGeneral( $persistencia ){
		$this->persistencia = $persistencia;
	}
	/**
	 * Consulta los diferentes numero de documentos de estudiantes en tabla estudiantegeneral
	 * @param String $txtCodigoEstudiante
	 * @access public
	 * @return Array<Estudiantes>
	 */
	 
	 public function buscarIdentificacionEstudiante( $tipodocumento,$numeroDocumento ){
	 		
	 	$estudianteGeneral=new EstudianteGeneral( $this->persistencia );
		return $estudianteGeneral;
	 }
 }

?>