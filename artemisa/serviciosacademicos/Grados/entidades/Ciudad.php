<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Ciudad{
  	
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
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type Departamento
	 * @access private
	 */
	private $departamento;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoSapCiudad;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Ciudad( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador de la ciudad
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setId( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador de la ciudad
	 * @access public
	 * @return int
	 */
	public function getId( ){
		return $this->id;
	}
	
	/**
	 * Modifica el codigo de la ciudad
	 * @param int $codigo
	 * @access public 
	 * @return void
	 */
	public function setCodigo( $codigo ){
		$this->codigo = $codigo;
	}
	
	/**
	 * Retorna el codigo de la ciudad
	 * @access public
	 * @return int
	 */
	public function getCodigo( ){
		return $this->codigo;
	}
	
	/**
	 * Modifica el nombre de la ciudad
	 * @param string $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre de la ciudad
	 * @access public
	 * @return String
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica el estado de la ciudad
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado de la ciudad
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	/**
	 * Modifica el Departamento de la ciudad
	 * @param Departamento $departamento
	 * @access public
	 * @return void 
	 */
	public function setDepartamento( $departamento ){
		$this->departamento = $departamento;
	}
	
	/**
	 * Retorna el Departamento de la ciudad
	 * @access public
	 * @return Departamento
	 */
	public function getDepartamento( ){
		return $this->departamento;
	}
	
	/**
	 * Modifica el codigo sap de la ciudad
	 * @param int $codigoSapCiudad
	 * @access public 
	 * @return void
	 */
	public function setCodigoSapCiudad( $codigoSapCiudad ){
		$this->codigoSapCiudad = $codigoSapCiudad;
	}
	
	/**
	 * Retorna el codigo sap de la ciudad
	 * @access public
	 * @return int
	 */
	public function getCodigoSapCiudad( ){
		return $this->codigoSapCiudad;
	}
	
	
	
	/**
	 * Buscar Codigo Ciudad, Departamento, Pais People
	 * @param $txtCodigoCiudad
	 * @access public
	 */
	public function buscarCodigoLocalidad( $txtCodigoCiudad ){
		
		$sql = "SELECT p.codigosappais
						,d.codigosapdepartamento
						,c.codigosapciudad
				FROM ciudad c
				JOIN departamento d USING(iddepartamento)
				JOIN pais p USING(idpais)
				WHERE idciudad = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCiudad , false );
		
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoSapCiudad( $this->persistencia->getParametro( "codigosapciudad" ) );
			
			$departamento = new Departamento( null );
			$departamento->setCodigoSapDepartamento( $this->persistencia->getParametro( "codigosapdepartamento" ) );
			
			$pais = new Pais( null );
			$pais->setCodigoSapPais( $this->persistencia->getParametro( "codigosappais" ) );
			
			$departamento->setPais( $pais );
			
			$this->setDepartamento( $departamento );
			
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	
	
  }
?>