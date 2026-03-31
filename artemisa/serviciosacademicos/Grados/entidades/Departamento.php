<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Departamento{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigo;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type Pais
	 * @access private
	 */
	private $pais;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoSapDepartamento;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Departamento( $persitencia ){
		$this->persistencia = $persitencia;
	}
	
	/**
	 * Modifica el identificador del departamento
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setId( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador del departamento
	 * @access public
	 * @return int
	 */
	public function getId( ){
		return $this->id;
	}
	
	/**
	 * Modifica el codigo del departamento
	 * @param int $codigo
	 * @access public
	 * @return void
	 */
	public function setCodigo( $codigo ){
		$this->codigo = $codigo;
	}
	
	
	/**
	 * Retorna el codigo del departamento
	 * @access public
	 * @return int
	 */
	public function getCodigo( ){
		return $this->codigo;
	}
	
	/**
	 * Modifica el nombre del departamento
	 * @param string $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del departamento
	 * @access public
	 * @return string
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica el estado del departamento
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado del departamento
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	/**
	 * Modifica el pais del departamento
	 * @param Pais $pais
	 * @access public
	 * @return void
	 */
	public function setPais( $pais ){
		$this->pais = $pais;
	}
	
	/**
	 * Retorna el pais del departamento
	 * @access public
	 * @return Pais
	 */
	public function getPais( ){
		return $this->pais;
	}
	
	/**
	 * Modifica el codigo sap del departamento
	 * @param int $codigoSapDepartamento
	 * @access public
	 * @return void
	 */
	public function setCodigoSapDepartamento( $codigoSapDepartamento ){
		$this->codigoSapDepartamento = $codigoSapDepartamento;
	}
	
	
	/**
	 * Retorna el codigo sap del departamento
	 * @access public
	 * @return int
	 */
	public function getCodigoSapDepartamento( ){
		return $this->codigoSapDepartamento;
	}
	
	
	
	
  }
?>