<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package control
    */
   
   include '../entidades/CarreraPeople.php';
   
   class ControlCarreraPeople{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlCarreraPeople( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consultar Carrera People
	 * @param string $txtItemPeople
	 * @access public
	 * @return <Array>CarreraPeople
	 */
	public function buscarCarreraPeople( $txtItemPeople ){
		$carreraPeople = new CarreraPeople( $this->persistencia );
		$carreraPeople->setItemPeople( $txtItemPeople );
		$carreraPeople->buscarCarreraPeople( );
		return $carreraPeople;
	}
	
	
   }
?>