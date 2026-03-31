<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología Universidad el Bosque
    * @package control
    */
   
   include '../entidades/ProgramaProyecto.php';
   
   class ControlProgramaProyecto{
   	
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor 
		 * @param Singleton $persistencia
		 */
		public function ControlProgramaProyecto( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Registrar Programa Proyecto
		 * @param int $txtIdPrograma
		 * @param int $txtIdProyecto
		 * @param int $idPersona
		 * @access public
		 * @return boolean
		 */
		public function crearProgramaProyecto( $txtIdPrograma, $txtIdProyecto, $idPersona ){
			$programaProyecto = new ProgramaProyecto( $this->persistencia );
			
			$programa = new Programa( null );
			$programa->setIdProgramaPlanDesarrollo( $txtIdPrograma );
			
			$proyecto = new Proyecto( null );
			$proyecto->setProyectoPlanDesarrolloId( $txtIdProyecto );
			
			$programaProyecto->setPrograma( $programa );
			$programaProyecto->setProyecto( $proyecto );
			
			return $programaProyecto->crearProgramaProyecto( $idPersona );
		}
	
	
   }
?>