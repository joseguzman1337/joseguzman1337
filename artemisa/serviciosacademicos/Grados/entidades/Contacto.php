<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
    class Contacto extends Persona{
    	
		/**
		 * @type int
		 * @access private
		 */
		private $documento;
		
		
		/**
		 * @type TipoDocumento
		 * @access private
		 */
		private $tipoDocumento;
		
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function Contacto ( $persistencia ) {
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el documento de la persona
		 * @param int $documento
		 * @access public
		 * @return void
		 */
		public function setDocumento( $documento ){
			$this->documento = $documento;
		}
		
		/**
		 * Retorna el documento de la persona
		 * @access public
		 * @return int
		 */
		public function getDocumento( ){
			return $this->documento;
		}
		
		/**
		 * Modifica el tipo de Documento de la persona
		 * @param TipoDocumento $tipoDocumento
		 * @access public
		 * @return void
		 */
		public function setTipoDocumento( $tipoDocumento ){
			$this->tipoDocumento = $tipoDocumento;
		}
		
		/**
		 * Retorna el tipo de Documento de la persona
		 * @access public
		 * @return void
		 */
		public function getTipoDocumento( ){
			return $this->tipoDocumento;
		}
		
		/**
		 * Busca un contacto por Documento
		 * @access public
		 * @return void
		 */
		public function buscarDocumento( $txtCodigoCarrera ){
			$sql = "SELECT E.idestudiantegeneral, ET.codigoestudiante, E.numerodocumento, E.tipodocumento,
    			DATE_FORMAT(E.fechanacimientoestudiantegeneral,'%Y-%m-%d') AS fechanacimientoestudiantegeneral, E.telefonoresidenciaestudiantegeneral,
				E.telefono2estudiantegeneral, E.tipodocumento, E.nombresestudiantegeneral, E.apellidosestudiantegeneral , E.emailestudiantegeneral, E.celularestudiantegeneral,
				D.nombredocumento, E.codigogenero, G.nombregenero
    			FROM estudiantegeneral E
    			INNER JOIN estudiante ET ON ( ET.idestudiantegeneral = E.idestudiantegeneral )
    			INNER JOIN carrera C ON ( C.codigocarrera  = ET.codigocarrera )
    			INNER JOIN documento D ON ( D.tipodocumento = E.tipodocumento )
    			INNER JOIN genero G ON ( G.codigogenero = E.codigogenero )
    			WHERE numerodocumento = ? 
    			AND C.codigocarrera = ? ";
			
			
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getDocumento( ) , false );
			$this->persistencia->setParametro( 1 , $txtCodigoCarrera , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			
			if( $this->persistencia->getNext( ) ){
				$this->setId( $this->persistencia->getParametro( "codigoestudiante" ) );
				$this->setNombres( $this->persistencia->getParametro( "nombresestudiantegeneral" ) );
				$this->setApellidos( $this->persistencia->getParametro( "apellidosestudiantegeneral" ) );
				
				$tipoDocumento = new TipoDocumento( null );
				$tipoDocumento->setIniciales( $this->persistencia->getParametro( "tipodocumento" ) );
				$tipoDocumento->setDescripcion( $this->persistencia->getParametro( "nombredocumento" ) );
				$this->setTipoDocumento( $tipoDocumento );
			}
		}
		
		
		/**
		 * Consulta Contacto
		 * @access public
		 * @return Array
		 */
		/*public function consultar( ){
			$contactos = array( );
			$sql = "SELECT U.idusuario, U.nombres, U.apellidos
					FROM usuario U
					WHERE CONCAT( U.nombres,' ',U.apellidos ) LIKE '%?%'
					AND U.codigorol = 3
					AND U.codigoestadousuario = 100
					ORDER BY U.apellidos ASC";
			$this->persistencia->crearSentenciaSQL( $sql );
			$txtNombres = str_replace(" ","%",$this->getNombres( ));
			$this->persistencia->setParametro( 0 , $txtNombres , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
				$contacto = new Contacto( null );
				$contacto->setId( $this->persistencia->getParametro( "idusuario" ) );
				$contacto->setNombres( $this->persistencia->getParametro( "nombres" ) );
				$contacto->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
				
				$contactos[ count( $contactos ) ] = $contacto;
			}
				return $contactos;		
			}*/
    	
    }
?>