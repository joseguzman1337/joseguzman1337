<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */

 class Facultad{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoFacultad;
	
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreFacultad;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoCarreraPrincipal;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoArea;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoFacultad;
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Facultad( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la facultad
	 * @param int $codigoFacultad
	 * @access public
	 * @return void
	 */
	public function setCodigoFacultad( $codigoFacultad ){
		$this->codigoFacultad = $codigoFacultad;
	}
	
	/**
	 * Retorna el codigo de la facultad
	 * @access public
	 * @return int
	 */
	public function getCodigoFacultad( ){
		return $this->codigoFacultad;
	}
	
	/**
	 * Modifica el nombre de la facultad
	 * @param String $nombreFacultad
	 * @access public
	 */
	public function setNombreFacultad( $nombreFacultad ){
		$this->nombreFacultad = $nombreFacultad;
	}
	
	/**
	 * Retorna el nombre de la facultad
	 * @access public
	 * @return String
	 */
	public function getNombreFacultad( ){
		return $this->nombreFacultad;
	}
	
	/**
	 * Modifica la carrera principal de la facultad
	 * @param int $codigoCarreraPrincipal
	 * @access public
	 */
	public function setCarreraPrincipal( $codigoCarreraPrincipal ){
		$this->codigoCarreraPrincipal = $codigoCarreraPrincipal;
	}
	
	
	/**
	 * Retorna la carrera principal de la facultad
	 * @access public
	 * @return int
	 */
	public function getCarreraPrincipal( ){
		return $this->codigoCarreraPrincipal;
	}
	
	/**
	 * Modifica el codigo de area de la facultad
	 * @param int $codigoArea
	 * @access public
	 */
	public function setCodigoArea( $codigoArea ){
		$this->codigoArea = $codigoArea;
	}
	
	/**
	 * Retorna el codigo de area de la facultad
	 * @access public
	 * @return int
	 */
	public function getCodigoArea( ){
		return $this->codigoArea;
	}
	
	/**
	 * Modifica el estado de la facultad
	 * @param int $estadoFacultad
	 * @access public
	 */
	public function setEstadoFacultad( $estadoFacultad ){
		$this->estadoFacultad = $estadoFacultad;
	}
	
	/**
	 * Retorna el estado de la facultad
	 * @access public
	 * @return int
	 */
	public function getEstadoFacultad( ){
		return $this->estadoFacultad;
	}
	 
	 
	
	/**
	 * Consultar Facultades
	 * @access public
	 * @return Array<Facultades>
	 */
	public function consultarFacultades( $idPersona ){
		$facultades = array( );
		$sql = "SELECT DISTINCT U.idusuario, U.usuario, F.nombrefacultad, F.codigofacultad , U.numerodocumento , U.nombres
				FROM usuario U 
					INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
					INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
					INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
					WHERE F.codigoestado = 100
					AND U.idusuario = ?
					AND F.codigofacultad != 10
					ORDER BY F.codigofacultad";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idPersona , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$facultad = new Facultad( null );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			
			$facultades[ count( $facultades ) ] = $facultad;
		}
		return $facultades;
		
	}
	
	
	/**
	 * Consultar Facultades
	 * @access public
	 * @return Array<Facultades>
	 */
	public function consultar($idPersona=null ){
		$facultades = array( );
		$join = $where = null;
		$parametros = array();
		if(!empty($idPersona)){
			$join = " INNER JOIN usuariofacultad uf ON (uf.codigofacultad = F.codigofacultad) ";
			$where = " AND uf.idusuario = ? ";
			$parametros[]= $idPersona;
		}
		
		$sql = "SELECT F.nombrefacultad, F.codigofacultad
				FROM facultad F
				".$join."
					WHERE F.codigoestado = 100
					AND F.codigofacultad != 10

					ORDER BY F.nombrefacultad";
					".$where.";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		if(!empty($idPersona)){
			$this->persistencia->setParametro( 0 , $parametros[0] , false );
		}
		//echo $this->persistencia->getSQLListo( );
		
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$facultad = new Facultad( null );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			
			$facultades[ count( $facultades ) ] = $facultad;
		}
		return $facultades;
		
	}
	
	/**
	 * Buscar Facultad por CodigoCarrera
	 * @param $txtCodigoCarrera
	 * @access public
	 */
	public function buscarFacultad( $txtCodigoCarrera ){
			
		$sql = "SELECT
					F.codigofacultad, F.nombrefacultad
				FROM
					facultad F
				INNER JOIN carrera C ON ( C.codigofacultad = F.codigofacultad )
				WHERE C.codigocarrera = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCarrera , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$this->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
		}
		
		$this->persistencia->freeResult( );	 
		
	}
	
 	/**
	 * Buscar Plan Desarrollo por CodigoFacultad
	 * @param $txtCodigoFacultad
	 * @access public
	 */
	public function buscarFacultadId( $txtCodigoFacultad ){
			
		$sql = "SELECT F.codigofacultad, F.nombrefacultad
				FROM facultad F
				WHERE F.codigofacultad = ?
				AND F.codigoestado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoFacultad , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$this->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
		}
		
	}
	 
	
 }
?>