<?php
 /**
  * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
  * @copyright Universidad el Bosque - Dirección de Tecnología
  * @package entidades
  */
 
 class Genero{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $codigo;
	
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Genero( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Modifica el codigo del Genero
	 * @param int $codigo
	 * @access public
	 * @return void 
	 */
	public function setCodigo( $codigo ){
		$this->codigo = $codigo;
	}
	
	
	/**
	 * Retorna el codigo del Genero 
	 * @access public
	 * @return int
	 */
	public function getCodigo( ){
		return $this->codigo;
	}
	
	
	/**
	 * Modifica el nombre del Genero
	 * @param string $nombre;
	 * @access public
	 * @return void 
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del Genero
	 * @access public
	 * @return string
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	/**
	 * Consultar Genero
	 * @access public
	 * @return Array
	 */
	public function consultarGenero( ){
		$generos = array( );
		
		$sql = "SELECT codigogenero, nombregenero 
				FROM genero";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$genero = new Genero( $this->persistencia );
			$genero->setCodigo( $this->persistencia->getParametro( "codigogenero" ) );
			$genero->setNombre( $this->persistencia->getParametro( "nombregenero" ) );
			
			$generos[ count( $generos ) ] = $genero;
		}
		return $generos;
		
	}
 }
?>