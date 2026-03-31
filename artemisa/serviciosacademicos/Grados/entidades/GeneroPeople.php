<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package entidades
    */
   
   class GeneroPeople{
   	
	/**
	 * @type int
	 * @access private 
	 */
	private $idSexoPeople;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreSexoPeople;
	
	/**
	 * @type string 
	 * @access private
	 */
	private $descripcionSexoPeople;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoSexoPeople;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function GeneroPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del sexo de people
	 * @param int $idSexoPeople
	 * @access public
	 * @return void
	 */
	public function setIdSexoPeople( $idSexoPeople ){
		$this->idSexoPeople = $idSexoPeople;
	}
	
	/**
	 * Retorna el codigo del sexo de people
	 * @access public
	 * @return int
	 */
	public function getIdSexoPeople( ){
		return $this->idSexoPeople;
	}
	
	/**
	 * Modifica el nombre de sexo de people
	 * @param string $nombreSexoPeople
	 * @access public
	 * @return void
	 */
	public function setNombreSexoPeople( $nombreSexoPeople ){
		$this->nombreSexoPeople = $nombreSexoPeople;
	}
	
	/**
	 * Retorna el nombre de sexo de people
	 * @access public
	 * @return string
	 */
	public function getNombreSexoPeople( ){
		return $this->nombreSexoPeople;
	}
	
	/**
	 * Modifica la descripcion de sexo de people
	 * @param string $descripcionSexoPeople
	 * @access public
	 * @return void
	 */
	public function setDescripcionSexoPeople( $descripcionSexoPeople ){
		$this->descripcionSexoPeople = $descripcionSexoPeople;
	}
	
	/**
	 * Retorna la descripcion de sexo de people
	 * @access public
	 * @return string
	 */
	public function getDescripcionSexoPeople( ){
		return $this->descripcionSexoPeople;
	}
	
	/**
	 * Modifica el estado de sexo de people
	 * @param int $estadoSexoPeople
	 * @access public
	 * @return void
	 */
	public function setEstadoSexoPeople( $estadoSexoPeople ){
		$this->estadoSexoPeople = $estadoSexoPeople;
	}
	
	/**
	 * Retorna la descripcion de sexo de people
	 * @access public
	 * @return string
	 */
	public function getEstadoSexoPeople( ){
		return $this->estadoSexoPeople;
	}
	
	/**
	 * Buscar Estudiante por Codigo
	 * @param $txtCodigoEstudiante
	 * @access public
	 */
	public function buscarCodigoGeneroPeople( $txtCodigoGenero ){
		
		$sql = "SELECT codigopeoplesexo
				FROM sexopeople
				WHERE codigosexo = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoGenero , false );
		
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdSexoPeople( $this->persistencia->getParametro( "codigopeoplesexo" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	
	
   }
?>