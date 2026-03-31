<?php
 /**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */ 
  
	
	class EstudianteDocumento{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idEstudianteDocumento;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estudiante;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaVencimientoEstudianteDocumento;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */
		public function EstudianteDocumento( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el idEstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setIdEstudianteDocumento( $idEstudianteDocumento ){
			$this->idEstudianteDocumento = $idEstudianteDocumento;
		}
		
		/**
		 * Retorna el idEstudianteDocumento
		 * @access public
		 * @return int
		 */
		public function getIdEstudianteDocumento( ){
			return $this->idEstudianteDocumento;
		}
		
		/**
		 * Modifica el Estudiante de EstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setEstudiante( $estudiante ){
			$this->estudiante = $estudiante;
		}
		
		/**
		 * Retorna el idEstudianteDocumento
		 * @access public
		 * @return int
		 */
		public function getEstudiante( ){
			return $this->estudiante;
		}
		
		/**
		 * Modifica la fecha de vencimiento del Estudiante de EstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setFechaVencimientoEstudianteDocumento( $fechaVencimientoEstudianteDocumento ){
			$this->fechaVencimientoEstudianteDocumento = $fechaVencimientoEstudianteDocumento;
		}
		
		/**
		 * Retorna la fecha de vencimiento del Estudiante de EstudianteDocumento
		 * @access public
		 * @return date
		 */
		public function getFechaVencimientoEstudianteDocumento( ){
			return $this->fechaVencimientoEstudianteDocumento;
		}
		
		
			
	 /**
	 * actualiza la fecha de venicimento del carnet del estudiante antiguo
	 * @access public
	 * @return array
	 */
		public function actualizarVencimiento( $fechavencimientoestudiantedocumeto , $tipodocumento , $numerodocumento , $idestudiantegeneral  ) {
	
		$sql="	UPDATE 
					estudiantedocumento
				SET 
					fechavencimientoestudiantedocumento= ? , idestudiantegeneral = ?
				WHERE			
					tipodocumento = ? and numerodocumento = ? ";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $fechavencimientoestudiantedocumeto , true);
		$this->persistencia->setParametro( 1 , $idestudiantegeneral , false );
		$this->persistencia->setParametro( 2 , $tipodocumento , true );
		$this->persistencia->setParametro( 3 , $numerodocumento , false );
		
					
			$estado = $this->persistencia->ejecutarUpdate( );
		
			if( $estado ){
				$this->persistencia->confirmarTransaccion( );
			}else{	
				$this->persistencia->cancelarTransaccion( );
			}	
			return $estado;	
					
		}
		
		
			public function actualizarVencimientoId( $fechavencimiento,$idestudiantegeneral ,$idEstudianteGeneralAntiguo  ) {
	
		$sql="	UPDATE 
					estudiantedocumento
				SET 
					fechavencimientoestudiantedocumento= ? 
				WHERE			
					idestudiantegeneral in (?,?) ";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $fechavencimiento , true);
		$this->persistencia->setParametro( 1 , $idestudiantegeneral , false );
		$this->persistencia->setParametro( 2 , $idEstudianteGeneralAntiguo  , false );
					
			$estado = $this->persistencia->ejecutarUpdate( );
		
			if( $estado ){
				$this->persistencia->confirmarTransaccion( );
			}else{	
				$this->persistencia->cancelarTransaccion( );
			}	
			return $estado;	
					
		}
		
	}
?>