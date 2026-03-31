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
	
	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	 *se modifica consulta con el fin de traer las carreras 
	 * Since May 15 , 2017
	 * */
                
         /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
          *Se modifica sql se quita AND F.codigofacultad != 10  debido a que el departamento de bienestar pertence  a la facultad 10 se añade en not in  2,3
          *@Since September 18,2018
          */       
		
		$sql = "

			SELECT
				*
			FROM
				(
					SELECT DISTINCT
						U.idusuario,
						U.usuario,
						F.nombrefacultad,
						F.codigofacultad,
						'' AS nombrecarrera,
						F.codigofacultad AS codigocarrera,
						U.numerodocumento,
						U.nombres
					FROM
						usuario U
					INNER JOIN usuariofacultad UF ON (UF.usuario = U.usuario)
					INNER JOIN carrera C ON (
						C.codigocarrera = UF.codigofacultad
					)
					INNER JOIN facultad F ON (
						F.codigofacultad = C.codigofacultad
					)
					WHERE
						F.codigoestado = 100
					AND U.idusuario = ? and F.codigofacultad not in(10)
					
					UNION
						SELECT DISTINCT
							U.idusuario,
							U.usuario,
							F.nombrefacultad,
							F.codigofacultad,
							C.nombrecarrera,
							pd.codigocarrera,
							U.numerodocumento,
							U.nombres
						FROM
							usuario U
						INNER JOIN usuariofacultad UF ON (UF.usuario = U.usuario)
						INNER JOIN carrera C ON (
							C.codigocarrera = UF.codigofacultad
						)
						INNER JOIN facultad F ON (
							F.codigofacultad = C.codigofacultad
						)
						INNER JOIN PlanDesarrollo pd ON (
							pd.Codigocarrera = C.codigocarrera
						)
						WHERE
                                                    F.codigoestado = 100
                                                    AND U.idusuario = ?
                                                    AND C.codigomodalidadacademica IN (200,500)
                                                    AND C.codigocarrera NOT IN (354, 124, 119, 140, 134, 2,3)	
						
				) AS facultadCarrera
			ORDER BY
				
				nombrecarrera";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idPersona , false );
		$this->persistencia->setParametro( 1 , $idPersona , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$facultad = new Facultad( null );
			$codigoCarreraPrincipal = new Carrera ( null );
			$codigoCarreraPrincipal->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ));
			$facultad->setCodigoArea($this->persistencia->getParametro( "codigocarrera" ));
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			$facultad->setCarreraPrincipal($codigoCarreraPrincipal);
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
		/*@modified Diego Rivera<riveradiego@unbosque.edu.co>
                 *Se quita validacion AND F.codigofacultad != 10 debido a que el plan de desarrollo de bienestar universitario pertenece a otras unidades
                 *@Since September 18,2018
                 *  */
		$sql = "SELECT  lcase(F.nombrefacultad)as nombrefacultad, F.codigofacultad
				FROM facultad F
				".$join."
					WHERE F.codigoestado = 100
					".$where."
					ORDER BY F.codigofacultad";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		if(!empty($idPersona)){
			$this->persistencia->setParametro( 0 , $parametros[0] , false );
		}
	//	echo $this->persistencia->getSQLListo( );
		
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