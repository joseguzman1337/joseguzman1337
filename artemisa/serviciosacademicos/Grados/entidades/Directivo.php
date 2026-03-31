<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Directivo{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idDirectivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroDocumentoDirectivo;
	
	/**
	 * @type string
	 * @access private
	 */
	private $apellidosDirectivo;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombresDirectivo;
	
	/**
	 * @type string
	 * @access private
	 */
	private $cargoDirectivo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaInicioDirectivo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaVencimientoDirectivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTipoDirectivo;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function Directivo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del directivo
	 * @param int $idDirectivo
	 * @access public
	 * @return void
	 */
	public function setIdDirectivo( $idDirectivo ){
		$this->idDirectivo = $idDirectivo;
	}
	
	/**
	 * Retorna el identificador del directivo
	 * @access public
	 * @return int
	 */
	public function getIdDirectivo(  ){
		return $this->idDirectivo;
	}
	
	/**
	 * Modifica el apellido del directivo
	 * @param string $apellidosDirectivo
	 * @access public
	 * @return void
	 */
	public function setApellidoDirectivo( $apellidosDirectivo ){
		$this->apellidosDirectivo = $apellidosDirectivo;
	}
	
	/**
	 * Retorna el apellido del directivo
	 * @access public
	 * @return string
	 */
	public function getApellidoDirectivo(  ){
		return $this->apellidosDirectivo;
	}
	
	/**
	 * Modifica el nombre del directivo
	 * @param string $nombresDirectivo
	 * @access public
	 * @return void
	 */
	public function setNombreDirectivo( $nombresDirectivo ){
		$this->nombresDirectivo = $nombresDirectivo;
	}
	
	/**
	 * Retorna el nombre del directivo
	 * @access public
	 * @return string
	 */
	public function getNombreDirectivo(  ){
		return $this->nombresDirectivo;
	}
	
	/**
	 * Modifica el cargo del directivo
	 * @param string $cargoDirectivo
	 * @access public
	 * @return void
	 */
	public function setCargoDirectivo( $cargoDirectivo ){
		$this->cargoDirectivo = $cargoDirectivo;
	}
	
	/**
	 * Retorna el cargo del directivo
	 * @access public
	 * @return string
	 */
	public function getCargoDirectivo(  ){
		return $this->cargoDirectivo;
	}
	
	/**
	 * Modifica la fecha de inicio del directivo
	 * @param date $fechaInicioDirectivo
	 * @access public
	 * @return void
	 */
	public function setFechaInicioDirectivo( $fechaInicioDirectivo ){
		$this->fechaInicioDirectivo = $fechaInicioDirectivo;
	}
	
	/**
	 * Retorna la fecha de inicio del directivo
	 * @access public
	 * @return date
	 */
	public function getFechaInicioDirectivo(  ){
		return $this->fechaInicioDirectivo;
	}
	
	/**
	 * Modifica la fecha de vencimiento del directivo
	 * @param date $fechaVencimientoDirectivo
	 * @access public
	 * @return void
	 */
	public function setFechaVencimientoDirectivo( $fechaVencimientoDirectivo ){
		$this->fechaVencimientoDirectivo = $fechaVencimientoDirectivo;
	}
	
	/**
	 * Retorna la fecha de vencimiento del directivo
	 * @access public
	 * @return date
	 */
	public function getFechaVencimientoDirectivo(  ){
		return $this->fechaVencimientoDirectivo;
	}
	
	/**
	 * Modifica el codigo tipo del directivo
	 * @param int $fechaVencimientoDirectivo
	 * @access public
	 * @return void
	 */
	public function setCodigoTipoDirectivo( $codigoTipoDirectivo ){
		$this->codigoTipoDirectivo = $codigoTipoDirectivo;
	}
	
	/**
	 * Retorna el codigo tipo del directivo
	 * @access public
	 * @return int
	 */
	public function getCodigoTipoDirectivo(  ){
		return $this->codigoTipoDirectivo;
	}
	
	/**
	 * Modifica la carrera del directivo
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera del directivo
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera(  ){
		return $this->carrera;
	}
	
	/**
		 * Consulta Directivo
		 * @access public
		 * @return Array
		 */
		public function consultar( ){
			$directivos = array( );
			$sql = "SELECT D.iddirectivo, D.nombresdirectivo, D.apellidosdirectivo, D.cargodirectivo, D.codigocarrera, C.nombrecarrera
					FROM directivo D
					INNER JOIN usuario U ON ( D.idusuario = U.idusuario )
					INNER JOIN carrera C ON ( C.codigocarrera = D.codigocarrera )
					WHERE CONCAT( D.nombresdirectivo,' ',D.apellidosdirectivo ) LIKE '%?%'
					AND D.codigotipodirectivo = 100
					AND C.codigocarrera = 1
					GROUP BY D.iddirectivo
					ORDER BY D.apellidosdirectivo ASC";
			$this->persistencia->crearSentenciaSQL( $sql );
			$txtNombres = str_replace(" ","%",$this->getNombreDirectivo( ));
			$this->persistencia->setParametro( 0 , $txtNombres , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
				$directivo = new Directivo( $this->persistencia );
				$directivo->setIdDirectivo( $this->persistencia->getParametro( "iddirectivo" ) );
				$directivo->setNombreDirectivo( $this->persistencia->getParametro( "nombresdirectivo" ) );	
				$directivo->setApellidoDirectivo( $this->persistencia->getParametro( "apellidosdirectivo" ) );
				$directivo->setCargoDirectivo( $this->persistencia->getParametro( "cargodirectivo" ) );						
				
				$carrera = new Carrera( null );
				$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
				$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
				
				$directivo->setCarrera( $carrera );
				
				$directivos[ count( $directivos ) ] = $directivo;
			}
				return $directivos;		
	}


	/**
	 * Buscar Secretario General
	 * @access public
	 * @return Directivo
	 */
	public function buscarSecretarioGeneral( ){
		
		$sql = "SELECT CONCAT( nombresdirectivo, ' ', apellidosdirectivo ) AS nombre, ".
        " cargodirectivo FROM directivo WHERE iddirectivo = 8 ";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setNombreDirectivo( $this->persistencia->getParametro( "nombre" ) );
			$this->setCargoDirectivo( $this->persistencia->getParametro( "cargodirectivo" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
        
	
	
		/**
		 * Consulta Directivo Firmas 
		 * @access public
		 * @return Array
		 */
		public function consultarFirmas( $txtFechaFirmaDocumento, $txtCodigoCarrera ){
			$directivos = array( );
			$sql = "SELECT
						rf.iddirectivo,
						concat(
							apellidosdirectivo,
							' ',
							nombresdirectivo
						) AS nombre
					FROM
						directivo d,
						referenciafirmagrado rf
					WHERE
						d.codigotipodirectivo = '100'
					AND rf.iddirectivo = d.iddirectivo
					AND ? >= rf.fechainicioreferenciafirmagrado
					AND ? <= rf.fechafinalreferenciafirmagrado
					AND (
						d.codigocarrera = '1'
						OR d.codigocarrera = ?
					)
					ORDER BY
						nombre";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtFechaFirmaDocumento." 00:00:00" , true );
			$this->persistencia->setParametro( 1 , $txtFechaFirmaDocumento." 11:59:59" , true );
			$this->persistencia->setParametro( 2 , $txtCodigoCarrera , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
				$directivo = new Directivo( $this->persistencia );
				$directivo->setIdDirectivo( $this->persistencia->getParametro( "iddirectivo" ) );
				$directivo->setNombreDirectivo( $this->persistencia->getParametro( "nombre" ) );
				
				$directivos[ count( $directivos ) ] = $directivo;
			}
				return $directivos;		
	}
        /**
		 * Consulta presidente y secretaria consejo de facultad
		 * @access public
		 * @return Array
		 */
        public function DirectivosActuales (){
           $directivos  =array();
           $sql = "SELECT CONCAT(nombresdirectivo,' ',apellidosdirectivo) as nombre ".
            " FROM directivo ".
            " WHERE cargodirectivo IN ( 'SECRETARIA CONSEJO DIRECTIVO', 'PRESIDENTE CONSEJO DIRECTIVO' ) ".
            " AND fechavencimientodirectivo >= now( ) ORDER BY cargodirectivo";
           
           	$this->persistencia->crearSentenciaSQL( $sql );
                $this->persistencia->ejecutarConsulta( );
                while( $this->persistencia->getNext( ) ){
				$directivo = new Directivo( $this->persistencia );
				$directivo->setNombreDirectivo( $this->persistencia->getParametro( "nombre" ) );
				
				$directivos[ count( $directivos ) ] = $directivo;
			}
				return $directivos;		
        }
	
        
        /**
	 * Buscar Secretario General
	 * @access public
	 * @return Directivo
	 */
	public function buscarSecretarioGeneralId( ){
		$sql = "SELECT iddirectivo FROM directivo ".
        " WHERE cargodirectivo like '%Secretari%' and cargodirectivo like '%General%' ".
        " AND codigocarrera = 1 and fechavencimientodirectivo > now() and idusuario = 4186";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdDirectivo( $this->persistencia->getParametro( "iddirectivo" ) );
		}
		$this->persistencia->freeResult( );
	}
	
  }
?>