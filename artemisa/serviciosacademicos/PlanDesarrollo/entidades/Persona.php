<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */
 
 class Persona{
 	
	/**
	 * @type int
	 * @access private
	 */
	 private $id = "";
	 
  	/**
   	 * @type String	
   	 * @access private
   	 */
   	private $nombres;
	   
   	/**
   	 * @type String
     * @access private
    */
    private $apellidos;
		
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Persona( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id de la Persona
	 * @access public
	 * @return void
	 */ 
	public function setId( $id ){
		$this->id = $id;
	}
	 
	/**
	 * Retorna el id de la Persona
	 * @param int $id
	 * @access public
	 * @return int
  	 */
	public function getId( ){
		return $this->id;
	}
	  
  	/**
   	 * Modifica los nombres de la Persona
   	 * @access public
   	 * @return void
	 */
   	public function setNombres( $nombres ){
   		$this->nombres = $nombres;
   	}
	   
   	/**
     * Retorna los nombres de la Persona
     * @param String $nombres
     * @access public
   	 * @return String
	 */
    public function getNombres( ){
    	return $this->nombres;
    }
		
	/**
	 * Modifica los apellidos de la Persona
	 * @access public
	 * @return void
	 */
	public function setApellidos( $apellidos ){
	 	$this->apellidos = $apellidos;
	}
		 
	/**
	 * Retorna los apellidos de la Persona
	 * @param String $apellidos
	 * @access public
	 * @return String
	 */
	public function getApellidos( ){
		return $this->apellidos;
	}
		 
		 
	/**
	 * Convierte el Objeto Persona en String
	 * @access public
	 */
	public function toLinea ( ) {
		return trim( trim( $this->getApellidos( ) ) . " " . trim( $this->getNombres( ) ) );  
	}
	
	
 }
?>