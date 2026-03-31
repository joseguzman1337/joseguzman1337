<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 4, 2016
	*/
	
	
	require_once('../entidades/Programa.php'); 
	class ControlPrograma{
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 * @access public
		 */
		public function ControlPrograma( $persistencia ){
			$this->persistencia = $persistencia;
		} 
		
		/**
		 * Consulta los Programas
		 * @access public
		 * @return Array<LineaEstrategica>
		 */
		public function consultarProgramas( $variables=null ){
			$programa = new Programa( $this->persistencia );
			return $programa->consultarProgramas( $variables );
		}
		
		/**
		 * Registrar Programa
		 * @param int $txtNombrePrograma
		 * @param int $txtJustificacionPrograma
		 * @param int $txtIdPrograma
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearPrograma( $txtNombrePrograma, $txtJustificacionPrograma , $txtDescripcionPrograma, $txtResponsablePrograma, $idPersona ,$txtResponsableProgramaEmail) {
			$programa = new Programa( $this->persistencia );
			$programa->setNombrePrograma( $txtNombrePrograma );
			$programa->setJustificacionProgramaPlanDesarrollo( $txtJustificacionPrograma );
			$programa->setDescripcionProgramaPlanDesarrollo( $txtDescripcionPrograma );
			$programa->setResponsableProgramaPlanDesarrollo( $txtResponsablePrograma );
			$programa->setEmailResponsableProgramaPlanDesarrollo( $txtResponsableProgramaEmail );
			return $programa->crearPrograma( $idPersona );
		}
		
		/**
		 * Actualizar Programa
	 	 * @param string $txtActualizaPrograma, string $txtActualizaJustificacionPrograma, string $txtActualizaDescripcionPrograma, string $txtActualizaResponsablePrograma, int $idPersona, int $txtIdPrograma
		 * @access public
		 * @return boolean
		 */
		 /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
		  *Se adiciona variable  $txtEmailPrograma con el fin de actualizar el email del responsable
		  * Since April 19,2017
		  */
		 
		public function actualizarPrograma( $txtActualizaPrograma, $txtActualizaJustificacionPrograma, $txtActualizaDescripcionPrograma, $txtActualizaResponsablePrograma, $idPersona, $txtIdPrograma , $txtEmailPrograma ){
			$programa = new Programa( $this->persistencia );
			$programa->actualizarPrograma( $txtActualizaPrograma, $txtActualizaJustificacionPrograma, $txtActualizaDescripcionPrograma, $txtActualizaResponsablePrograma, $idPersona, $txtIdPrograma , $txtEmailPrograma );
			return $programa;
		}
	}
?>