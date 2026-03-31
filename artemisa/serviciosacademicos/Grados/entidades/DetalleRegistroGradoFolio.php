<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología - Universidad el Bosque
	 * @package entidades
	 */
	
	class DetalleRegistroGradoFolio{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idDetalleRegistroGradoFolio;
		
		/**
		 * @type Folio
		 * @access private
		 */
		private $folio;
		
		/**
		 * @type RegistroGrado
		 * @access private
		 */
		private $registroGrado;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoDetalleRegistroGradoFolio;
		
		/**
		 * @type int
		 * @access private
		 */
		private $codigoTipoDetalleRegistroGradoFolio;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function DetalleRegistroGradoFolio( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el id del detalle de registro de grado de folio
		 * @param int $idDetalleRegistroGradoFolio
		 * @access public
		 * @return void
		 */
		public function setIdDetalleRegistroGradoFolio( $idDetalleRegistroGradoFolio ){
			$this->idDetalleRegistroGradoFolio = $idDetalleRegistroGradoFolio;
		}
		
		/**
		 * Retorna el id del detalle de registro de grado de folio
		 * @access public
		 * @return int 
		 */
		public function getIdDetalleRegistroGradoFolio( ){
			return $this->idDetalleRegistroGradoFolio;
		}
		
		/**
		 * Modifica el folio del detalle registro de grado de folio
		 * @param Folio $folio
		 * @access public
		 * @return void
		 */
		public function setFolio( $folio ){
			$this->folio = $folio;
		}
		
		/**
		 * Retorna el folio del detalle registro de grado de folio
		 * @access public
		 * @return Folio
		 */
		public function getFolio( ){
			return $this->folio;
		}
		
		/**
		 * Modifica el Registro de Grado del Folio
		 * @param RegistroGrado $registroGrado
		 * @access public
		 * @return void
		 */
		public function setRegistroGrado( $registroGrado ){
			$this->registroGrado = $registroGrado;
		}
		
		/**
		 * Retorna el Registro de Grado del Folio
		 * @access public
		 * @return RegistroGrado
		 */
		public function getRegistroGrado( ){
			return $this->registroGrado;
		}
		
		/**
		 * Modifica el estado del detalle registro de grado folio
		 * @param int $estadoDetalleRegistroGradoFolio
		 * @access public
		 * @return void
		 */
		public function setEstadoDetalleRegistroGradoFolio( $estadoDetalleRegistroGradoFolio ){
			$this->estadoDetalleRegistroGradoFolio = $estadoDetalleRegistroGradoFolio;
		}
		
		/**
		 * Retorna el estado del detalle registro de grado folio
		 * @access public
		 * @return int
		 */
		public function getEstadoDetalleRegistroGradoFolio( ){
			return $this->estadoDetalleRegistroGradoFolio;
		}
		
		/**
		 * Modifica el codigo tipo detalle registro grado folio
		 * @param int $codigoTipoDetalleRegistroGradoFolio
		 * @access public
		 * @return void
		 */
		public function setCodigoTipoDetalleRegistroGradoFolio( $codigoTipoDetalleRegistroGradoFolio ){
			$this->codigoTipoDetalleRegistroGradoFolio = $codigoTipoDetalleRegistroGradoFolio;
		}
		
		/**
		 * Retorna el codigo tipo detalle registro grado folio
		 * @access public
		 * @return int
		 */
		public function getCodigoTipoDetalleRegistroGradoFolio( ){
			return $this->codigoTipoDetalleRegistroGradoFolio;
		}
		
		
		/**
		 * Buscar Detalle RegistroGraduadoFolio 
		 * @param int $txtCodigoIncentivo
		 * @access public
		 * @return String
		 */
		public function buscarDetalleRegistroGradoFolio( $txtIdRegistroGrado ){
			$sql = "SELECT iddetalleregistrograduadofolio, idregistrograduadofolio 
					FROM detalleregistrograduadofolio 
					WHERE idregistrograduado = ? 
					AND codigoestado like '1%'";
					
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );
			$this->persistencia->ejecutarConsulta( );
			if( $this->persistencia->getNext( ) ){
				$this->setIdDetalleRegistroGradoFolio( $this->persistencia->getParametro( "iddetalleregistrograduadofolio" ) );
				
				$folio = new Folio( $this->persistencia );
				$folio->setIdFolio( $this->persistencia->getParametro( "idregistrograduadofolio" ) );
				
				$this->setFolio( $folio );
				
			}
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->freeResult( );
		}
		
		/**
		 * Insertar PrevisualizacionFolioTemporal
		 * @param int txtNumeroFolio, $txtIdRegistroGrado
		 * @access public
		 * @return boolean
		 */
		public function insertarDetalleRegistroGradoFolio( $txtNumeroFolio , $txtIdRegistroGrado ){
			$sql = "INSERT INTO detalleregistrograduadofolio (
						idregistrograduadofolio,  
						idregistrograduado,  
						codigoestado, 
						codigotipodetalleregistrograduadofolio
					)
					VALUES
						(?, ?, '100','100');
					";
			
			$this->persistencia->crearSentenciaSQL( $sql );
	
	
			$this->persistencia->setParametro( 0 , $txtNumeroFolio, false );
			$this->persistencia->setParametro( 1 , $txtIdRegistroGrado, false );
			
			//echo $this->persistencia->getSQLListo( ).'<br>';
			$estado = $this->persistencia->ejecutarUpdate( );
			if( $estado )
				$this->persistencia->confirmarTransaccion( );
			else	
				$this->persistencia->cancelarTransaccion( );
				
					
			/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
			*Se elimina funcion  $this->persistencia->freeResult( );  esta provoca el error en el singleton
			*Since Octuber 18 , 2017
			*/	
			
			
			return $estado;
		
		}
		
	}
?>