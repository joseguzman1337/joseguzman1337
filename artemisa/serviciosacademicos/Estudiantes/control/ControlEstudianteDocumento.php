<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 * @since enero  23, 2017
 */
 include("../entidades/EstudianteDocumento.php");
 
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
	 * Actualizar fechavencimiento de carnet y verificacion de idestudiantegeneral en tabla estudiantedocumento
 	 * @param int $codigoEstudiante,$idestudiantegeneral
	 * @access public
	 * @return boolean
	 */
	 public function actualizarfechavencimiento( $fechavencimientoestudiantedocumeto , $tipodocumento , $numerodocumento , $idestudiantegeneral ){
	 	$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
		$estudianteDocumento->actualizarVencimiento( $fechavencimientoestudiantedocumeto , $tipodocumento , $numerodocumento , $idestudiantegeneral);
		return $estudianteDocumento;
	 }
	 
	 
	 public function actualizarfechavencimientoId($fechavencimiento,$idestudiantegeneral,$idEstudianteGeneralAntiguo ){
	 	$estudianteDocumento = new EstudianteDocumento( $this->persistencia );
	 	$estudianteDocumento->actualizarVencimientoId($fechavencimiento, $idestudiantegeneral,$idEstudianteGeneralAntiguo );
		return $estudianteDocumento;
	 }
 }
?>

