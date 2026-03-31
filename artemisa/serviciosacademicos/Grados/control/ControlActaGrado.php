<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   include '../entidades/ActaGrado.php';
   
   class ControlActaGrado{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlActaGrado( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Insertar Acta de Grado
 	 * @param int $txtNumeroActaGrado, $idPersona
	 * @access public
	 * @return boolean
	 */
	public function crearActaGrado( $txtNumeroActaGrado, $idPersona ){
		$actaGrado = new ActaGrado( $this->persistencia );
		$actaGrado->crearActaGrado( $txtNumeroActaGrado, $idPersona );
		return $actaGrado;
	}
	
	
   }
?>