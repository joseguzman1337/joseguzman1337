<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 
 require_once("Facultad.php");
 class Carrera{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoCarrera;
	
	/**
	 * @type String
	 * @access private
	 */
	private $centroCosto;
	
	/**
	 * @type String
	 * @access private
	 */
	private $codigoBeneficio;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreCarrera;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreCortoCarrera;
	
	/**
	 * @type Facultad
	 * @access private
	 */
	private $facultad;
	
	/**
	 * @type Facultad
	 * @access private
	 */
	private $fechaGrado;
	
	/**
	 * @type Modalidad Academica
	 * @access private
	 */
	private $modalidadAcademica;
	
	/**
	 * @type Modalidad SIC
	 * @access private
	 */
	private $modalidadAcademicaSic;
	
	/**
	 * @type TituloProfesion
	 * @access private
	 */
	private $tituloProfesion;
	
	/**
	 * @type Singleto
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Carrera( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la carrera
	 * @access public
	 * @return void
	 */
	public function setCodigoCarrera( $codigoCarrera ){
		$this->codigoCarrera = $codigoCarrera;
	}
	
	/**
	 * Retorna el codigo de la carrera
	 * @param int $codigoCarrera
	 * @access public
	 * @return int
	 */
	public function getCodigoCarrera( ){
		return $this->codigoCarrera;
	}
	
	/**
	 * Modifica el centro de costo de la carrera
	 * @param String $centroCosto
	 * @access public
	 * @return void
	 */
	public function setCentroCosto( $centroCosto ){
		$this->centroCosto = $centroCosto;
	}
	
	/**
	 * Retorna el centro de costo de la carrera
	 * @access public
	 * @return string
	 */
	public function getCentroCosto( ){
		return $this->centroCosto;
	}
	
	/**
	 * Modifica el codigo beneficio de la carrera
	 * @param string $codigoBeneficio
	 * @access public
	 * @return void
	 */
	public function setCodigoBeneficio( $codigoBeneficio ){
		$this->codigoBeneficio = $codigoBeneficio;
	}
	
	/**
	 * Retorna el codigo beneficio de la carrera
	 * @access public
	 * @return string
	 */
	public function getCodigoBeneficio( ){
		return $this->codigoBeneficio;
	}
	
	/**
	 * Modifica el nombre de la carrera
	 * @param String $nombreCarrera
	 * @access public
	 * @return void
	 */
	public function setNombreCarrera( $nombreCarrera ){
		$this->nombreCarrera = $nombreCarrera;
	}
	
	/**
	 * Retorna el nombre de la carrera
	 * @access public
	 * @return String
	 */
	public function getNombreCarrera( ){
		return $this->nombreCarrera;
	}
	
	/**
	 * Modifica el nombre corto de la carrera
	 * @param String $nombreCortoCarrera
	 * @access public
	 * @return void
	 */
	public function setNombreCortoCarrera( $nombreCortoCarrera ){
		$this->nombreCortoCarrera = $nombreCortoCarrera;
	}
	
	/**
	 * Retorna el nombre corto de la carrera
	 * @access public
	 * @return String
	 */
	public function getNombreCortoCarrera( ){
		return $this->nombreCortoCarrera;
	}
	
	/**
	 * Modifica la facultad de la carrera
	 * @param Facultad $facultad
	 * @access public
	 * @return void
	 */
	public function setFacultad( $facultad ){
		$this->facultad = $facultad;
	}
	
	/**
	 * Retorna la facultad de la carrera
	 * @access public
	 * @return Facultad
	 */
	public function getFacultad( ){
		return $this->facultad;
	}
	
	/**
	 * Modifica la modalidad academica de la carrera
	 * @param ModalidadAcademica $modalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setModalidadAcademica( $modalidadAcademica ){
		$this->modalidadAcademica = $modalidadAcademica;
	}
	
	/**
	 * Retorna la modalidad academica de la carrera
	 * @access public
	 * @return ModalidadAcademica
	 */
	public function getModalidadAcademica( ){
		return $this->modalidadAcademica;
	}
	
	/**
	 * Modifica la modalidad academica sic de la carrera
	 * @param ModalidadSIC $modalidadAcademicaSic
	 * @access public
	 * @return void
	 */
	public function setModalidadAcademicaSic( $modalidadAcademicaSic ){
		$this->modalidadAcademicaSic = $modalidadAcademicaSic;
	}
	
	/**
	 * Retorna la modalidad academica sic de la carrera
	 * @access public
	 * @return ModalidadSIC
	 */
	public function getModalidadAcademicaSic( ){
		return $this->modalidadAcademicaSic;
	}
	
	/**
	 * Modifica el titulo de la profesion
	 * @param TituloProfesion $tituloProfesion
	 * @access public
	 * @return void
	 */
	public function setTituloProfesion( $tituloProfesion ){
		$this->tituloProfesion = $tituloProfesion;
	}
	
	/**
	 * Retorna el titulo de la profesion
	 * @access public
	 * @return TituloProfesion
	 */
	public function getTituloProfesion( ){
		return $this->tituloProfesion;
	}
	
	/**
	 * Consultar Carrera por Facultad
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarrera( $idFacultad ){
		$carreras = array( );
		$sql = "SELECT C.codigocarrera, C.nombrecarrera
				FROM carrera C
				INNER JOIN facultad F ON ( C.codigofacultad = F.codigofacultad )
				WHERE F.codigofacultad = ?
				AND C.codigomodalidadacademica IN (200)
				ORDER BY C.codigomodalidadacademica, C.nombrecarrera ASC";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idFacultad , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$carreras[ count( $carreras ) ] = $carrera;
		}
		return $carreras;
	}
	
	
	/**
	 * Consultar Carrera por Facultad y Usuario
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarreraUsuario( $idPersona, $idFacultad ){
		$carreras = array( );
		$sql = "SELECT DISTINCT C.codigocarrera, C.nombrecarrera	
				FROM usuario U 
					INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
					INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
					INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
					WHERE F.codigoestado = 100
					AND U.idusuario = ?
					AND F.codigofacultad = ?
					AND C.codigomodalidadacademica IN (200,300)
					ORDER BY C.codigomodalidadacademica, C.nombrecarrera ASC";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idPersona , false );
		$this->persistencia->setParametro( 1 , $idFacultad , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$carreras[ count( $carreras ) ] = $carrera;
		}
		return $carreras;
	}
	
	/**
	 * Buscar Estudiante por Codigo
	 * @param $txtCodigoCarrera
	 * @access public
	 */
	public function buscar( ){
			
		$sql = "SELECT codigocarrera, nombrecarrera, centrocosto, codigocentrobeneficio , codigomodalidadacademica, nombrecortocarrera, codigomodalidadacademicasic
				FROM carrera
				WHERE codigocarrera = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCodigoCarrera( ) , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$this->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			$this->setCentroCosto( $this->persistencia->getParametro( "centrocosto" ) );
			$this->setCodigoBeneficio( $this->persistencia->getParametro( "codigocentrobeneficio" ) );
			$this->setNombreCortoCarrera( $this->persistencia->getParametro( "nombrecortocarrera" ) );
			
		/*pendiente verificar
		
			/*$modalidadAcademica = new ModalidadAcademica( null );
			$modalidadAcademica->setCodigoModalidadAcademica( $this->persistencia->getParametro( "codigomodalidadacademica" ) );
			
			$modalidadAcademicaSic = new ModalidadSIC( null );
			$modalidadAcademicaSic->setCodigoModalidadAcademicaSic( $this->persistencia->getParametro( "codigomodalidadacademicasic" ) );
			
			$this->setModalidadAcademica( $modalidadAcademica );
			$this->setModalidadAcademicaSic( $modalidadAcademicaSic );
			*/
			
		}
		
		$this->persistencia->freeResult( );	 
		
	}
	
	/**
	 * Consultar Carrera por Facultad y Usuario
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarreraNotificar( ){
		$carreras = array( );
		$sql = "SELECT DISTINCT C.codigocarrera , F.codigofacultad, C.codigocentrobeneficio
				FROM carrera C
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				WHERE C.codigomodalidadacademica IN (200,300) 
				AND F.codigofacultad != 10 
				AND C.fechavencimientocarrera > NOW() 
				ORDER BY C.codigocarrera";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setCodigoBeneficio( $this->persistencia->getParametro( "codigocentrobeneficio" ) );
			
			$facultad = new Facultad( null );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			
			$carrera->setFacultad( $facultad );
			
			$carreras[ count( $carreras ) ] = $carrera;
		}
		$this->persistencia->freeResult( );	 
		
		return $carreras;
	}
	
	
	/**
	 * Buscar Estudiante por Codigo
	 * @param $txtCodigoCarrera
	 * @access public
	 */
	public function buscarTituloProfesion( ){
			
		$sql = "SELECT
					T.codigotitulo, T.nombretitulo
				FROM
					titulo T
				INNER JOIN carrera C ON ( C.codigotitulo = T.codigotitulo )
				WHERE
					C.codigocarrera = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCodigoCarrera( ) , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$tituloProfesion = new Titulo( null );
			$tituloProfesion->setCodigoTitulo( $this->persistencia->getParametro( "codigotitulo" ) );
			$tituloProfesion->setNombreTitulo( $this->persistencia->getParametro( "nombretitulo" ) );
			
			$this->setTituloProfesion( $tituloProfesion );
			
			
		}
		
		$this->persistencia->freeResult( );	 
		
	}
	
	/**
	 * Consultar Carrera Admintecnología
	 * @access public
	 * @return Array<Carrera>
	 */
	public function consultarCarreraAdmin( ){
		$carreras = array( );
		$sql = "SELECT DISTINCT C.codigocarrera , C.nombrecarrera
				FROM carrera C
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				WHERE C.codigomodalidadacademica IN (200) 
				AND F.codigofacultad != 10 
				AND C.fechavencimientocarrera > NOW() 
				ORDER BY C.codigocarrera";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$carreras[ count( $carreras ) ] = $carrera;
		}
		$this->persistencia->freeResult( );	 
		
		return $carreras;
	}
	
	
	
 }
?>