<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 	include ('../../../kint/Kint.class.php');
	require_once('../entidades/UsuarioFacultad.php');
	
class ControlUsuarioFacultad {
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ControlUsuarioFacultad ( $persistencia ){ 
			$this->persistencia = $persistencia;
		} 
		
		/**
		 * Consulta los email de funcionarios activos
		 * @access public
		 * @return Array<emailUsuarioFacultad>
		 */
		public function VerEmailAutocompletar ( $email ) {
			
			$usuarioFacultad = new UsuarioFacultad( $this->persistencia );
			return $usuarioFacultad ->buscarEmail( $email );
			
		}
		
		
		public function VerNombreAutocompletar ( $nombre ) {
			
			$usuarioFacultad = new UsuarioFacultad( $this->persistencia );
			return $usuarioFacultad ->buscarNombre ( $nombre );
			
		}
		
	}


?>