<?php
    /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package control
    */
   
   include '../entidades/Pais.php';
   include '../entidades/Departamento.php';
   include '../entidades/Ciudad.php';
   
   class ControlLocalidad{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function ControlLocalidad( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar Codigo Sap Pais, Ciudad, Departamento
	 * @param int $txtTipoDocumento
	 * @access public
	 * @return void
	 */
	public function buscarCodigoLocalidad( $txtCodigoCiudad ){
		$ciudad = new Ciudad( $this->persistencia );
		$ciudad->buscarCodigoLocalidad( $txtCodigoCiudad );
		return $ciudad;
		
	}
	
   }
?>