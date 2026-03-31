<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 */
	
	include '../entidades/TipoGrado.php';
	
	class ControlTipoGrado{
		
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
	public function ControlTipoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los tipos de Grados
	 * @access public
	 * @return Array<TipoGrado>
	 */
	public function consultarTipoGrado( ){
		$tipoGrado = new TipoGrado( $this->persistencia );
		return $tipoGrado->consultar( );
	}
		
	}
?>