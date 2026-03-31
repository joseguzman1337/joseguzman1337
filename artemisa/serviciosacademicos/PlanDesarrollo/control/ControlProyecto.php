<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 8, 2016
	*/
	
	
	require_once('../entidades/Proyecto.php'); 
	class ControlProyecto{
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
		public function ControlProyecto( $persistencia ){ 
			$this->persistencia = $persistencia;
		} 
		
		/**
		 * Consulta los Programas
		 * @access public
		 * @return Array<LineaEstrategica>
		 */
		public function consultarProyectos( $programaConsulta=0, $proyectoPlanDesarrolloId=0 ){
			$proyecto = new Proyecto( $this->persistencia );
			return $proyecto->consultarProyectos( $programaConsulta, $proyectoPlanDesarrolloId );
		}
		
		
		/**
		 * Registrar Proyecto
		 * @param string $txtNombreProyecto
		 * @param string $txtJustificacionProyecto
		 * @param string $txtDescripcionProyecto
		 * @param string $txtObjetivoProyecto
		 * @param string $txtAccionProyecto
		 * @param string $txtResponsableProyecto
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearProyecto( $txtNombreProyecto, $txtJustificacionProyecto , $txtDescripcionProyecto, $txtObjetivoProyecto, $txtAccionProyecto,  $txtResponsableProyecto, $idPersona , $ResponsableMetaEmail ) {
			$proyecto = new Proyecto( $this->persistencia );
			$proyecto->setNombreProyectoPlanDesarrollo($txtNombreProyecto);
			$proyecto->setJustificacionProyecto($txtJustificacionProyecto);
			$proyecto->setDescripcionProyecto($txtDescripcionProyecto);
			$proyecto->setObjetivoProyecto( $txtObjetivoProyecto );
			$proyecto->setAccionProyecto($txtAccionProyecto);
			$proyecto->setResponsableProyecto( $txtResponsableProyecto );
			$proyecto->setEmailResponsableProyecto( $ResponsableMetaEmail );
			return $proyecto->crearProyecto($idPersona);
		}
		
		
		/**
		 * Actualizar Proyecto
	 	 * @param string $txtActualizaProyecto, string $txtActualizaJustificacionProyecto, string $txtActualizaDescripcionProyecto, string $txtActualizaObjetivoProyecto, string $txtActualizaAccionProyecto, string $txtActualizaResponsableProyecto, int $idPersona, int $txtIdProyecto
		 * @access public
		 * @return boolean
		 */
		 
		 /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
		  *Se adiciona variable  $emailProyecto con el fin de actualizar el email del responsable
		  * Since April 19,2017
		  */
		public function actualizarProyecto( $txtActualizaProyecto, $txtActualizaJustificacionProyecto, $txtActualizaDescripcionProyecto, $txtActualizaObjetivoProyecto, $txtActualizaAccionProyecto, $txtActualizaResponsableProyecto, $idPersona, $txtIdProyecto , $emailProyecto ){
			$proyecto = new Proyecto( $this->persistencia );
			$proyecto->actualizarProyecto( $txtActualizaProyecto, $txtActualizaJustificacionProyecto, $txtActualizaDescripcionProyecto, $txtActualizaObjetivoProyecto, $txtActualizaAccionProyecto, $txtActualizaResponsableProyecto, $idPersona, $txtIdProyecto , $emailProyecto );
			return $proyecto;
		}
	}
?>