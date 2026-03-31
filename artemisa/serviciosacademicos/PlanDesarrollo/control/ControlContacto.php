<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

include '../entidades/Contacto.php';


class ControlContacto {
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlContacto( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Busca un contacto por documento
	 * @param String $documento
	 * @access public
	 * @return Contacto
	 */
	public function buscarDocumento( $documento, $txtCodigoCarrera ) {
		$contacto = new Contacto( $this->persistencia );
		$contacto->setDocumento( $documento );
		$contacto->buscarDocumento( $txtCodigoCarrera );
		return $contacto;
	}
	
	
	/**
	 * Consulta los contactos
	 * @access public
	 * @return Array<Usuarios>
	 */
	public function consultar( $txtNombres ){
		$contacto = new Contacto( $this->persistencia );
		$contacto->setNombres( $txtNombres );
		return $contacto->consultar( );
		//return $contacto;
	}
	
}
?>