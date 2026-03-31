<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  
  include '../entidades/DocumentoDuplicado.php';
  
  class ControlDocumentoDuplicado{
  	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDocumentoDuplicado( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Inserta un registro en la tabla documento duplicado
 	 * @param DocumentoDuplicado
	 * @access public
	 * @return boolean
	 */
	public function crearDocumentoDigital( $txtIdReferenciaGrado, $txtCodigoEstudiante, $txtIdRegistroGrado, $txtNumeroDiplomaDuplicado, $idDirectivo, $txtIdUsuario ){
		$documentoDuplicado = new DocumentoDuplicado( $this->persistencia );
		$documentoDuplicado->crearDocumentoDuplicado( $txtIdReferenciaGrado, $txtCodigoEstudiante, $txtIdRegistroGrado, $txtNumeroDiplomaDuplicado, $idDirectivo, $txtIdUsuario );
		return $documentoDuplicado;
	}
	
        public function listar(){
            	$documentoDuplicado = new DocumentoDuplicado( $this->persistencia );
                return  $documentoDuplicado->lista();
        }
	
  }
  
  
?>