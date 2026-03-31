<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

include '../entidades/Directivo.php';


class ControlDirectivo {
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDirectivo( $persistencia ) {
		$this->persistencia = $persistencia;
	}
		
	
	/**
	 * Consulta los contactos
	 * @access public
	 * @return Array<Usuarios>
	 */
	public function consultarDirectivo( $txtNombres ){
		$directivo = new Directivo( $this->persistencia );
		$directivo->setNombreDirectivo( $txtNombres );
		return $directivo->consultar( );
		//return $contacto;
	}
	
	/**
	 * Busca Secretario General
	 * @access public
	 * @return void
	 */
	public function buscarSecretarioGeneral( ) {
		$directivo = new Directivo( $this->persistencia );
		$directivo->buscarSecretarioGeneral( );
		return $directivo;
	}
	
	
	/**
	 * Consulta los contactos
	 * @access public
	 * @return Array<Usuarios>
	 */
	public function consultarFirmas( $txtFechaFirmaDocumento, $txtCodigoCarrera ){
		$directivo = new Directivo( $this->persistencia );
		return $directivo->consultarFirmas( $txtFechaFirmaDocumento, $txtCodigoCarrera );
		//return $contacto;
	}
        
        public function consultarDirectivosActuales( ){
            $directivo = new Directivo( $this->persistencia );
            return $directivo->DirectivosActuales( );
		
        }
        
        public function buscarSecretarioGeneralId( ) {
		$directivo = new Directivo( $this->persistencia );
		$directivo->buscarSecretarioGeneralId( );
		return $directivo;
	}
	
}
?>