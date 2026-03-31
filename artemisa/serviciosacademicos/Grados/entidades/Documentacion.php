<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Documentacion{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idDocumentacion;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombreDocumentacion;
	
	/**
	 * @type int 
	 * @access private
	 */
	private $tipoDocumentacion;
	
	/**
	 * @type Singleton 
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Documentacion( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador de la Documentacion
	 * @param int $idDocumentacion
	 * @access public
	 * @return void
	 */
	public function setIdDocumentacion( $idDocumentacion ){
		$this->idDocumentacion = $idDocumentacion;
	}
	
	/**
	 * Retorna el identificador de la Documentacion
	 * @access public
	 * @return int
	 */
	public function getIdDocumentacion( ){
		return $this->idDocumentacion;
	}
	
	/**
	 * Modifica el nombre de la documentacion
	 * @param string $nombreDocumentacion
	 * @access public
	 * @return void
	 */
	public function setNombreDocumentacion( $nombreDocumentacion ){
		$this->nombreDocumentacion = $nombreDocumentacion;
	}
	
	/**
	 * Retorna el nombre de la documentacion
	 * @access public
	 * @return string
	 */
	public function getNombreDocumentacion( ){
		return $this->nombreDocumentacion;
	}
	
	/**
	 * Modifica el tipo de documentacion
	 * @param int $tipoDocumentacion
	 * @access public
	 * @return void
	 */
	public function setTipoDocumentacion( $tipoDocumentacion ){
		$this->tipoDocumentacion = $tipoDocumentacion;
	}
	
	/**
	 * Retorna el tipo de documentacion
	 * @access public
	 * @return int
	 */
	public function getTipoDocumentacion( ){
		return $this->tipoDocumentacion;
	}
	
	/**
	 * Busca si existe Documentacion Pendiente de Estudiante
	 * @access public
	 * @return void
	 */
	public function buscar( $txtCodigoCarrera, $txtCodigoEstudiante){
		
		$sql = "SELECT COUNT(DM.iddocumentacion) pendientes
				FROM documentacion DM
				INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = DM.iddocumentacion )
				WHERE DF.codigocarrera = ?
				AND DF.fechainiciodocumentacionfacultad <= CURDATE()
				AND DF.fechavencimientodocumentacionfacultad >= CURDATE()
				AND DF.codigogenerodocumento = 300
				AND DM.iddocumentacion NOT IN ( SELECT D.iddocumentacion
												FROM documentacionestudiante D
												INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = D.iddocumentacion )
												INNER JOIN carrera C ON ( C.codigocarrera = DF.codigocarrera )
												INNER JOIN tipovencimientodocumento T ON ( D.codigotipodocumentovencimiento = T.codigotipovencimientodocumento )
												WHERE D.codigoestudiante = ?
												AND D.codigotipodocumentovencimiento = 100
												AND C.codigocarrera = ?
												AND D.idempresasalud IS NOT NULL
											 )
				AND DM.iddocumentacion != 57
				ORDER BY DM.iddocumentacion";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCarrera, false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br /><br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "pendientes" );
		}
		return 0;
	}
	
	/**
	 * Busca si tiene Pendiente Ingles  
	 * @access public
	 * @return void
	 */
	public function buscarIngles( $txtCodigoEstudiante, $txtCodigoCarrera){
			$sql = "SELECT COUNT(D.iddocumentacion) AS existeIngles
					FROM documentacionestudiante D
						INNER JOIN documentacion DM ON ( DM.iddocumentacion = D.iddocumentacion )
						INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = DM.iddocumentacion )
						INNER JOIN carrera C ON ( C.codigocarrera = DF.codigocarrera )
						INNER JOIN tipovencimientodocumento T ON ( D.codigotipodocumentovencimiento = T.codigotipovencimientodocumento )
						WHERE D.codigoestudiante = ?
						AND D.codigotipodocumentovencimiento = 100
						AND D.iddocumentacion = 57
						AND C.codigocarrera = ?
						AND D.idempresasalud IS NOT NULL";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
			$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			if( $this->persistencia->getNext( ) ){
				return $this->persistencia->getParametro( "existeIngles" );
			}
			return 0;
		
	}
	
	/**
	 * Busca Documentacion Pendiente de Estudiante
	 * @access public
	 * @return void
	 */
	public function consultarDocPendiente( $txtCodigoCarrera, $txtCodigoEstudiante){
		$documentos = array( );
		$sql = "SELECT DM.iddocumentacion, DM.nombredocumentacion
				FROM documentacion DM
				INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = DM.iddocumentacion )
				WHERE DF.codigocarrera = ?
				AND DF.fechainiciodocumentacionfacultad <= CURDATE()
				AND DF.fechavencimientodocumentacionfacultad >= CURDATE()
				AND DF.codigogenerodocumento = 300
				AND DM.iddocumentacion NOT IN ( SELECT D.iddocumentacion
												FROM documentacionestudiante D
												INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = D.iddocumentacion )
												INNER JOIN carrera C ON ( C.codigocarrera = DF.codigocarrera )
												INNER JOIN tipovencimientodocumento T ON ( D.codigotipodocumentovencimiento = T.codigotipovencimientodocumento )
												WHERE D.codigoestudiante = ?
												AND D.codigotipodocumentovencimiento = 100
												AND C.codigocarrera = ?
												AND D.idempresasalud IS NOT NULL
											 )
				AND DM.iddocumentacion != 57
				ORDER BY DM.iddocumentacion";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCarrera, false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br /><br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$documento = new Documentacion( null );
			$documento->setIdDocumentacion( $this->persistencia->getParametro( "iddocumentacion" ) );
			$documento->setNombreDocumentacion( $this->persistencia->getParametro( "nombredocumentacion" ) );
			
			$documentos[ count( $documentos ) ] = $documento;
		}
		return $documentos;
		
		
	}
	
	
	/**
	 * Busca Documento Ingles  
	 * @access public
	 * @return void
	 */
	public function buscarDocIngles( $txtCodigoEstudiante, $txtCodigoCarrera){
			$sql = "SELECT D.iddocumentacion, DM.nombredocumentacion
					FROM documentacionestudiante D
						INNER JOIN documentacion DM ON ( DM.iddocumentacion = D.iddocumentacion )
						INNER JOIN documentacionfacultad DF ON ( DF.iddocumentacion = DM.iddocumentacion )
						INNER JOIN carrera C ON ( C.codigocarrera = DF.codigocarrera )
						INNER JOIN tipovencimientodocumento T ON ( D.codigotipodocumentovencimiento = T.codigotipovencimientodocumento )
						WHERE D.codigoestudiante = ?
						AND D.codigotipodocumentovencimiento = 100
						AND D.iddocumentacion = 57
						AND C.codigocarrera = ?
						AND D.idempresasalud IS NOT NULL";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
			$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			if( $this->persistencia->getNext( ) ){
				$this->setIdDocumentacion( $this->persistencia->getParametro( "iddocumentacion" ) );
				$this->setNombreDocumentacion( $this->persistencia->getParametro( "nombredocumentacion" ) );
			}
			$this->persistencia->freeResult( );
		}
	
  }
  
  
?>